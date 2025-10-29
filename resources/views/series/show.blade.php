<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Serie: {{ $serie->title }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow sm:rounded-lg p-6">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-gray-500">Publisher</dt>
                        <dd class="font-medium">{{ $serie->publisher?->name ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Status</dt>
                        <dd class="font-medium">{{ $serie->active ? 'Actief' : 'Inactief' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Episodes</dt>
                        <dd class="font-medium">{{ $serie->episodes }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Release</dt>
                        <dd class="font-medium">{{ $serie->release_date?->format('Y-m-d') }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-gray-500">Synopsis</dt>
                        <dd class="font-medium whitespace-pre-line">{{ $serie->synopsis }}</dd>
                    </div>
                </dl>

                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('series.edit', $serie) }}" class="px-4 py-2 border rounded">Bewerken</a>

                    <form method="POST" action="{{ route('series.toggle', $serie) }}">
                        @csrf @method('PATCH')
                        <button class="px-4 py-2 border rounded" type="submit">
                            Zet {{ $serie->active ? 'uit' : 'aan' }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('series.destroy', $serie) }}" onsubmit="return confirm('Verwijderen?')">
                        @csrf @method('DELETE')
                        <button class="px-4 py-2 border rounded text-red-600" type="submit">Verwijderen</button>
                    </form>

                    <a href="{{ route('series.index') }}" class="px-4 py-2 underline">← Terug naar lijst</a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
