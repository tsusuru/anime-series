<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Publishers
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Zoek / Filter / Acties --}}
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="GET" action="{{ route('publishers.index') }}" class="flex flex-col sm:flex-row gap-3 sm:items-end">
                    <div class="flex-1">
                        <label class="block text-sm text-gray-700 mb-1">Zoek op naam</label>
                        <input type="text" name="q" value="{{ $q ?? '' }}" class="w-full border rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Status</label>
                        <select name="status" class="border rounded px-3 py-2">
                            <option value="">Alle</option>
                            <option value="active"   @selected(($status ?? '')==='active')>Actief</option>
                            <option value="inactive" @selected(($status ?? '')==='inactive')>Inactief</option>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button class="px-4 py-2 bg-gray-900 text-white rounded">Zoek</button>
                        <a href="{{ route('publishers.create') }}" class="px-4 py-2 border rounded">Nieuwe publisher</a>
                    </div>
                </form>
            </div>

            {{-- Lijst --}}
            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                            <tr class="text-left bg-gray-50">
                                <th class="px-3 py-2">Naam</th>
                                <th class="px-3 py-2 text-center">Status</th>
                                <th class="px-3 py-2 text-right">Acties</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($publishers as $p)
                                <tr class="border-t">
                                    <td class="px-3 py-2">
                                        <a href="{{ route('publishers.show', $p) }}" class="text-indigo-600 underline">
                                            {{ $p->name }}
                                        </a>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        @if($p->active)
                                            <span class="inline-flex items-center gap-1 text-green-700">● Actief</span>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-red-700">● Inactief</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">
                                        <div class="flex gap-3 justify-end">
                                            <a href="{{ route('publishers.edit', $p) }}" class="underline">Bewerken</a>

                                            <form method="POST" action="{{ route('publishers.toggle', $p) }}">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="underline">
                                                    Zet {{ $p->active ? 'uit' : 'aan' }}
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('publishers.destroy', $p) }}"
                                                  onsubmit="return confirm('Weet je zeker dat je {{ $p->name }} wilt verwijderen?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="underline text-red-600">Verwijderen</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-3 py-6 text-gray-600">Geen publishers gevonden.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginatie (alleen tonen als het een paginator is) --}}
                    @if(method_exists($publishers, 'links'))
                        <div class="mt-4">
                            {{ $publishers->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
