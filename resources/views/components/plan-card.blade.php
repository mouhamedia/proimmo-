@props(['plan'])
<div class="bg-{{ $plan['bg'] }} rounded-3xl p-8 border-2 border-{{ $plan['border'] }} hover:border-{{ $plan['hover'] }} transition {{ $plan['extra'] ?? '' }}">
    <div class="mb-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $plan['title'] }}</h3>
        <div class="flex items-baseline mb-2">
            <span class="text-5xl font-extrabold text-gray-900">{{ $plan['price'] }}</span>
            <span class="text-gray-600 ml-2">{{ $plan['unit'] }}</span>
        </div>
        <p class="text-gray-600">{{ $plan['desc'] }}</p>
    </div>
    <ul class="space-y-4 mb-8">
        @foreach ($plan['features'] as $feature)
            <li class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="text-gray-700">{{ $feature }}</span>
            </li>
        @endforeach
    </ul>
    <a href="{{ $plan['cta_link'] }}" class="block w-full px-6 py-3 {{ $plan['cta_class'] }} rounded-xl font-semibold text-center {{ $plan['cta_hover'] }}">
        {{ $plan['cta_text'] }}
    </a>
</div>
