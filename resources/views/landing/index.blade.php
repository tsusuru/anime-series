<x-public-layout title="Anime List">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- Header --}}
        <div class="flex items-baseline justify-between">
            <div>
                <h1 class="font-semibold text-2xl">Series</h1>
                <p class="text-sm text-gray-500">
                    The total amount of series found:
                    <span class="font-medium">
                        {{ method_exists($series,'total') ? $series->total() : $series->count() }}
                    </span>
                </p>
            </div>
        </div>

        {{-- Filters --}}
        <div class="bg-white shadow sm:rounded-lg p-6">
            <form method="GET" action="{{ route('landing') }}" class="grid gap-4 sm:grid-cols-4">
                {{-- Status --}}
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border rounded px-3 py-2">
                        <option value="">Alle</option>
                        <option value="active"   @selected(($status ?? '')==='active')>Actief</option>
                        <option value="inactive" @selected(($status ?? '')==='inactive')>Inactief</option>
                    </select>
                </div>

                {{-- Publisher suggestie (type & kies) --}}
                <div class="sm:col-span-2">
                    <label class="block text-sm text-gray-700 mb-1">Publisher (type to search)</label>
                    <input
                        id="publisher_name"
                        list="publishers-list"
                        class="w-full border rounded px-3 py-2"
                        placeholder="Start typing a publisher..."
                        value="{{ $publisherName ?? '' }}"
                        autocomplete="off"
                    >
                    <datalist id="publishers-list">
                        @foreach($publishers as $p)
                            <option data-id="{{ $p->id }}" value="{{ $p->name }}"></option>
                        @endforeach
                    </datalist>
                    <input type="hidden" name="publisher_id" id="publisher_id" value="{{ $pub }}">
                    <p class="text-xs text-gray-500 mt-1">Kies een optie uit de lijst om te filteren.</p>
                </div>

                {{-- Zoekterm --}}
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Search term</label>
                    <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Search title or synopsis"
                           class="w-full border rounded px-3 py-2">
                </div>

                {{-- CTA --}}
                <div class="sm:col-span-4">
                    <button class="px-4 py-2 bg-emerald-600 text-white rounded">Find!</button>
                    <a href="{{ route('landing') }}" class="ms-2 underline">Reset filters</a>
                </div>
            </form>
        </div>

        {{-- Cards grid --}}
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($series as $s)
                <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                    <div class="aspect-video bg-gray-100 flex items-center justify-center">
                        <svg viewBox="0 0 64 64" class="w-16 h-16 text-gray-300" fill="currentColor">
                            <path d="M8 12h48a4 4 0 014 4v32a4 4 0 01-4 4H8a4 4 0 01-4-4V16a4 4 0 014-4zm0 4v23l10-10 10 10 14-14 14 14V16H8z"/>
                        </svg>
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-semibold mb-1">{{ $s->title }}</h3>
                        <p class="text-sm text-gray-500 mb-3">{{ \Illuminate\Support\Str::limit($s->synopsis, 140) }}</p>
                        <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                            <span class="inline-flex items-center gap-1">
                                <svg viewBox="0 0 24 24" class="w-4 h-4" fill="currentColor">
                                    <path d="M19 21H5v-2h2v-3a5 5 0 015-5h2l3-3V6h2v4l-3 3v3h3v2z"/>
                                </svg>
                                {{ $s->publisher?->name ?? '—' }}
                            </span>
                            <span class="flex items-center gap-3">
                                <span>{{ $s->episodes }} eps</span>
                                <span>{{ $s->release_date?->format('Y') }}</span>
                            </span>
                        </div>
                        <a href="{{ route('series.show', $s) }}" class="inline-block px-4 py-2 bg-indigo-600 text-white rounded">
                            See details
                        </a>
                    </div>
                </div>
            @empty
                <div class="sm:col-span-2 lg:col-span-3">
                    <div class="bg-white shadow sm:rounded-lg p-8 text-center text-gray-600">
                        No series found for your filters.
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Paginatie --}}
        @if(method_exists($series,'links'))
            <div>{{ $series->links() }}</div>
        @endif
    </div>

    {{-- Klein scriptje: zet publisher_id zodra user een geldige optie kiest --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('publisher_name');
            const hidden = document.getElementById('publisher_id');
            const list = document.getElementById('publishers-list');

            function sync() {
                const opt = Array.from(list.options)
                    .find(o => o.value.toLowerCase() === input.value.trim().toLowerCase());
                hidden.value = opt ? opt.dataset.id : '';
            }
            input.addEventListener('change', sync);
            input.addEventListener('blur', sync);
            input.addEventListener('input', () => {
                if (!input.value) hidden.value = '';
            });
        });
    </script>
</x-public-layout>
