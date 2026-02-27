@props(['icon', 'color', 'title', 'description', 'items'])
<div class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition group">
    <div class="w-14 h-14 {{ $color }} rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
        {!! $icon !!}
    </div>
    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $title }}</h3>
    <p class="text-gray-600 mb-4">{{ $description }}</p>
    <ul class="space-y-2 text-sm text-gray-600">
        @foreach ($items as $item)
            <li class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ $item }}
            </li>
        @endforeach
    </ul>
</div>
