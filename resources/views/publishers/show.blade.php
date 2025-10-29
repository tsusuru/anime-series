<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Publisher: {{ $publisher->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Kaart met details --}}
            <div class="bg-white shadow sm:rounded-lg p-6">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-gray-500">ID</dt>
                        <dd class="font-medium">{{ $publisher->id }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Status</dt>
                        <dd class="font-medium">
                            {{ $publisher->active ? 'Actief' : 'Inactief' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Aangemaakt</dt>
                        <dd class="font-medium">
                            {{ $publisher->created_at?->format('Y-m-d H:i') ?? '—' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Bijgewerkt</dt>
                        <dd class="font-medium">
                            {{ $publisher->updated_at?->format('Y-m-d H:i') ?? '—' }}
                        </dd>
                    </div>
                </dl>

                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('publishers.edit', $publisher) }}" class="px-4 py-2 border rounded">
                        Bewerken
                    </a>

                    <form method="POST" action="{{ route('publishers.toggle', $publisher) }}">
                        @csrf @method('PATCH')
                        <button type="submit" class="px-4 py-2 border rounded">
                            Zet {{ $publisher->active ? 'uit' : 'aan' }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('publishers.destroy', $publisher) }}"
                          onsubmit="return confirm('Weet je zeker dat je {{ $publisher->name }} wilt verwijderen?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-4 py-2 border rounded text-red-600">
                            Verwijderen
                        </button>
                    </form>

                    <a href="{{ route('publishers.index') }}" class="px-4 py-2 underline">
                        ← Terug naar lijst
                    </a>
                </div>
            </div>

            {{-- (optioneel) Lijst met gekoppelde series, als je die eager load in controller: $publisher->load('series') --}}
            @if($publisher->relationLoaded('series'))
                <div class="bg-white shadow sm:rounded-lg p-6">
                    <h3 class="font-semibold mb-3">Series van deze publisher</h3>
                    <ul class="list-disc ms-6">
                        @forelse($publisher->series as $serie)
                            <li>
                                <a class="underline" href="{{ route('series.show', $serie) }}">{{ $serie->title }}</a>
                            </li>
                        @empty
                            <li class="text-gray-600">Nog geen series gekoppeld.</li>
                        @endforelse
                    </ul>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
