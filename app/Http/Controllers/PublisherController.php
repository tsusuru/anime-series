<?php
// app/Http/Controllers/PublisherController.php
namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');                      // zoekterm
        $status = $request->query('status');           // all|active|inactive

        $query = Publisher::query();

        if ($q) {
            $query->where('name', 'like', "%{$q}%");
        }
        if ($status === 'active')   $query->where('active', true);
        if ($status === 'inactive') $query->where('active', false);

        $publishers = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('publishers.index', compact('publishers', 'q', 'status'));
    }

    public function create()
    {
        return view('publishers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => ['required','string','max:255'],
            'active' => ['sometimes','boolean'],
        ]);
        $data['active'] = (bool)($data['active'] ?? true);

        $publisher = Publisher::create($data);
        return redirect()->route('publishers.show', $publisher);
    }

    public function show(Publisher $publisher)
    {
        return view('publishers.show', compact('publisher'));
    }

    public function edit(Publisher $publisher)
    {
        return view('publishers.edit', compact('publisher'));
    }

    public function update(Request $request, Publisher $publisher)
    {
        $data = $request->validate([
            'name'   => ['required','string','max:255'],
            'active' => ['sometimes','boolean'],
        ]);
        $data['active'] = (bool)($data['active'] ?? $publisher->active);

        $publisher->update($data);
        return redirect()->route('publishers.show', $publisher);
    }

    public function destroy(Publisher $publisher)
    {
        $publisher->delete();
        return redirect()->route('publishers.index');
    }

    public function toggle(Publisher $publisher)
    {
        $publisher->update(['active' => ! $publisher->active]);
        return back();
    }
}
