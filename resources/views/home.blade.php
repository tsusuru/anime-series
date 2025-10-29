<ul class="space-y-2">
    @forelse(($publishers ?? collect()) as $publisher)
        <li class="p-3 border rounded">
            {{ $publisher->name }}
        </li>
    @empty
        <li>Nog geen publishers.</li>
    @endforelse
</ul>
