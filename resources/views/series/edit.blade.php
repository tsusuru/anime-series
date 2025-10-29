<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Serie bewerken
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 rounded border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                        <p class="font-semibold">Er ging iets mis:</p>
                        <ul class="list-disc ms-5 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('series.update', $serie) }}" class="space-y-5">
                    @csrf @method('PUT')

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Titel</label>
                        <input name="title" value="{{ old('title', $serie->title) }}" class="w-full border rounded px-3 py-2" required>
                        @error('title') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Synopsis</label>
                        <textarea name="synopsis" class="w-full border rounded px-3 py-2" required>{{ old('synopsis', $serie->synopsis) }}</textarea>
                        @error('synopsis') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Episodes</label>
                            <input type="number" name="episodes" min="1" value="{{ old('episodes', $serie->episodes) }}" class="w-full border rounded px-3 py-2" required>
                            @error('episodes') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm text-gray-700 mb-1">Release datum</label>
                            <input type="date" name="release_date" value="{{ old('release_date', optional($serie->release_date)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2" required>
                            @error('release_date') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Publisher</label>
                        <select name="publisher_id" class="w-full border rounded px-3 py-2" required>
                            @foreach($publishers as $p)
                                <option value="{{ $p->id }}" @selected(old('publisher_id', $serie->publisher_id) == $p->id)>{{ $p->name }}</option>
                            @endforeach
                        </select>
                        @error('publisher_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center gap-2">
                        <input id="active" name="active" type="checkbox" value="1" {{ old('active', $serie->active) ? 'checked' : '' }}>
                        <label for="active" class="text-sm text-gray-700">Actief</label>
                    </div>

                    <div class="flex gap-3">
                        <button class="px-4 py-2 bg-gray-900 text-white rounded">Bijwerken</button>
                        <a href="{{ route('series.show', $serie) }}" class="underline">Annuleren</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
