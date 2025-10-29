<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Series
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="GET" action="{{ route('series.index') }}" class="grid sm:grid-cols-4 gap-3">
                    <div class="sm:col-span-2">
                        <label class="block text-sm text-gray-700 mb-1">Zoek op titel</label>
                        <input type="text" name="q" value="{{ $q ?? '' }}" class="w-full border rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Publisher</label>
                        <select name="publisher_id" class="w-full border rounded px-3 py-2">
                            <option value="">Alle</option>
                            @foreach($publishers as $p)
                                <option value="{{ $p->id }}" @selected(($pub ?? '') == $p->id)>{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full border rounded px-3 py-2">
                            <option value="">Alle</option>
                            <option value="active"   @selected(($status ?? '')==='active')>Actief</option>
                            <option value="inactive" @selected(($status ?? '')==='inactive')>Inactief</option>
                        </select>
                    </div>

                    <div class="sm:col-span-4 flex gap-2">
                        <button class="px-4 py-2 bg-gray-900 text-white rounded">Zoek</button>
                        <a href="{{ route('series.create') }}" class="px-4 py-2 border rounded">Nieuwe serie</a>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="px-3 py-2">Titel</th>
                            <th class="px-3 py-2">Publisher</th>
                            <th class="px-3 py-2">Episodes</th>
                            <th class="px-3 py-2">Release</th>
                            <th class="px-3 py-2 text-center">Status</th>
                            <th class="px-3 py-2 text-right">Acties</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($series as $s)
                            <tr class="border-t">
                                <td class="px-3 py-2">
                                    <a href="{{ route('series.show', $s) }}" class="text-indigo-600 underline">{{ $s->title }}</a>
                                </td>
                                <td class="px-3 py-2">{{ $s->publisher?->name ?? '—' }}</td>
                                <td class="px-3 py-2">{{ $s->episodes }}</td>
                                <td class="px-3 py-2">{{ $s->release_date?->format('Y-m-d') }}</td>
                                <td class="px-3 py-2 text-center">
                                    {{ $s->active ? 'Actief' : 'Inactief' }}
                                </td>
                                <td class="px-3 py-2">
                                    <div class="flex gap-3 justify-end">
                                        <a href="{{ route('series.edit', $s) }}" class="underline">Bewerken</a>

                                        <form method="POST" action="{{ route('series.toggle', $s) }}">
                                            @csrf @method('PATCH')
                                            <button class="underline" type="submit">
                                                Zet {{ $s->active ? 'uit' : 'aan' }}
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('series.destroy', $s) }}"
                                              onsubmit="return confirm('Verwijderen?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="underline text-red-600">Verwijderen</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td class="px-3 py-6 text-gray-600" colspan="6">Geen series gevonden.</td></tr>
                        @endforelse
                        </tbody>
                    </table>

                    @if(method_exists($series,'links'))
                        <div class="mt-4">{{ $series->links() }}</div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
