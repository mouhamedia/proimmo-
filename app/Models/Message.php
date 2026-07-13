<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender_id',
        'recipient_id',
        'subject',
        'body',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function scopeBetween(Builder $query, int $firstUserId, int $secondUserId): Builder
    {
        return $query->where(function (Builder $builder) use ($firstUserId, $secondUserId) {
            $builder->where('sender_id', $firstUserId)->where('recipient_id', $secondUserId);
        })->orWhere(function (Builder $builder) use ($firstUserId, $secondUserId) {
            $builder->where('sender_id', $secondUserId)->where('recipient_id', $firstUserId);
        });
    }
}