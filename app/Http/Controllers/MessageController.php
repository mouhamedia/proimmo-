<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index(Request $request, ?User $user = null)
    {
        $currentUser = Auth::user();
        $recipients = $this->recipientsFor($currentUser);

        $selectedRecipient = $user && $recipients->firstWhere('id', $user->id)
            ? $user
            : ($request->query('user')
                ? $recipients->firstWhere('id', (int) $request->query('user'))
                : $recipients->first());

        $thread = collect();
        if ($selectedRecipient) {
            $thread = Message::between($currentUser->id, $selectedRecipient->id)
                ->with(['sender', 'recipient'])
                ->orderBy('created_at')
                ->get();

            Message::where('sender_id', $selectedRecipient->id)
                ->where('recipient_id', $currentUser->id)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }

        $recipients = $recipients->map(function (User $recipient) use ($currentUser) {
            $lastMessage = Message::between($currentUser->id, $recipient->id)
                ->with(['sender', 'recipient'])
                ->latest('created_at')
                ->first();

            $unreadCount = Message::where('sender_id', $recipient->id)
                ->where('recipient_id', $currentUser->id)
                ->whereNull('read_at')
                ->count();

            $recipient->setAttribute('last_message', $lastMessage);
            $recipient->setAttribute('unread_count', $unreadCount);

            return $recipient;
        })->sortByDesc(function (User $recipient) {
            return optional($recipient->last_message)->created_at?->timestamp ?? 0;
        })->values();

        $unreadTotal = Message::where('recipient_id', $currentUser->id)
            ->whereNull('read_at')
            ->count();

        $sentTotal = Message::where('sender_id', $currentUser->id)->count();
        $receivedTotal = Message::where('recipient_id', $currentUser->id)->count();

        return view('messages.index', compact(
            'recipients',
            'selectedRecipient',
            'thread',
            'unreadTotal',
            'sentTotal',
            'receivedTotal'
        ));
    }

    public function store(Request $request)
    {
        $currentUser = Auth::user();

        $validated = $request->validate([
            'recipient_id' => ['required', 'exists:users,id'],
            'subject' => ['nullable', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:5000'],
        ]);

        $recipient = User::findOrFail($validated['recipient_id']);

        if (! $this->canMessage($currentUser, $recipient)) {
            return back()->with('error', 'Vous ne pouvez pas contacter cet utilisateur.');
        }

        Message::create([
            'sender_id' => $currentUser->id,
            'recipient_id' => $recipient->id,
            'subject' => $validated['subject'] ?? null,
            'body' => $validated['body'],
        ]);

        return redirect()
            ->route('messages.index', $recipient)
            ->with('success', 'Message envoyé avec succès.');
    }

    private function recipientsFor(User $currentUser)
    {
        $query = User::query()->whereKeyNot($currentUser->id);

        if ($currentUser->role === 'admin') {
            return $query->orderBy('role')->orderBy('name')->get();
        }

        if ($currentUser->role === 'manager') {
            return $query->where(function ($builder) use ($currentUser) {
                $builder->where('residence_id', $currentUser->residence_id)
                    ->orWhere('role', 'admin');
            })->orderBy('role')->orderBy('name')->get();
        }

        if ($currentUser->role === 'tenant') {
            return $query->where(function ($builder) use ($currentUser) {
                $builder->where('residence_id', $currentUser->residence_id)
                    ->whereIn('role', ['manager', 'technician', 'maintenance'])
                    ->orWhere('role', 'admin');
            })->orderBy('role')->orderBy('name')->get();
        }

        if (in_array($currentUser->role, ['technician', 'maintenance'], true)) {
            return $query->where(function ($builder) use ($currentUser) {
                $builder->where('residence_id', $currentUser->residence_id)
                    ->whereIn('role', ['manager', 'tenant'])
                    ->orWhere('role', 'admin');
            })->orderBy('role')->orderBy('name')->get();
        }

        return $query->orderBy('name')->get();
    }

    private function canMessage(User $sender, User $recipient): bool
    {
        if ($sender->id === $recipient->id) {
            return false;
        }

        if ($sender->role === 'admin') {
            return true;
        }

        if ($sender->role === 'manager') {
            return $recipient->role === 'admin' || $recipient->residence_id === $sender->residence_id;
        }

        if ($sender->role === 'tenant') {
            return $recipient->role === 'admin' || ($recipient->residence_id === $sender->residence_id && in_array($recipient->role, ['manager', 'technician', 'maintenance'], true));
        }

        if (in_array($sender->role, ['technician', 'maintenance'], true)) {
            return $recipient->role === 'admin' || ($recipient->residence_id === $sender->residence_id && in_array($recipient->role, ['manager', 'tenant'], true));
        }

        return false;
    }
}