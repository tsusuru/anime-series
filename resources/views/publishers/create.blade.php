<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nieuwe Publisher
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                {{-- Globale foutmelding (optioneel) --}}
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

                <form method="POST" action="{{ route('publishers.store') }}" class="space-y-5">
                    @csrf

                    {{-- Naam --}}
                    <div>
                        <label class="block text-sm text-gray-700 mb-1" for="name">Naam</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            class="w-full rounded border px-3 py-2 @error('name') border-red-500 @enderror"
                            required
                            autofocus
                        >
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Actief --}}
                    <div class="flex items-center gap-2">
                        <input
                            id="active"
                            name="active"
                            type="checkbox"
                            value="1"
                            {{ old('active', true) ? 'checked' : '' }}
                            class="h-4 w-4 rounded border-gray-300"
                        >
                        <label for="active" class="text-sm text-gray-700">Actief</label>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded">
                            Opslaan
                        </button>
                        <a href="{{ route('publishers.index') }}" class="underline">Annuleren</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
