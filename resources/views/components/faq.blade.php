@props(['questions'])
<section id="faq" class="py-20 px-4 bg-gray-50">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 bg-purple-100 rounded-full mb-4">
                <span class="text-purple-700 font-medium text-sm">Questions fréquentes</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                Vous avez des <span class="gradient-text">questions</span>?
            </h2>
            <p class="text-xl text-gray-600">
                Nous avons les réponses
            </p>
        </div>
        <div class="space-y-4">
            @foreach ($questions as $q)
                <details class="group bg-white rounded-2xl shadow-sm hover:shadow-md transition overflow-hidden">
                    <summary class="flex items-center justify-between cursor-pointer p-6 font-semibold text-gray-900">
                        <span>{{ $q['question'] }}</span>
                        <svg class="w-5 h-5 text-gray-500 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </summary>
                    <div class="px-6 pb-6 text-gray-600">
                        {{ $q['answer'] }}
                    </div>
                </details>
            @endforeach
        </div>
    </div>
</section>
