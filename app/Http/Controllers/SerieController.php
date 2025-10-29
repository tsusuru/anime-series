<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use App\Models\Publisher;
use Illuminate\Http\Request;

class SerieController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $status = $request->query('status'); // all|active|inactive
        $publisher = $request->query('publisher'); // id

        $query = Serie::with('publisher');

        if ($q) {
            $query->where(function ($qbuilder) use ($q) {
                $qbuilder->where('title', 'like', "%{$q}%")
                    ->orWhere('synopsis', 'like', "%{$q}%");
            });
        }
        if ($status === 'active')   $query->where('active', true);
        if ($status === 'inactive') $query->where('active', false);
        if ($publisher)             $query->where('publisher_id', $publisher);

        $series = $query->latest()->paginate(10)->withQueryString();
        $publishers = Publisher::orderBy('name')->get(['id','name']);

        return view('series.index', compact('series','q','status','publisher','publishers'));
    }

    public function create()
    {
        $publishers = Publisher::orderBy('name')->get(['id','name']);
        return view('series.create', compact('publishers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => ['required','string','max:255'],
            'synopsis'     => ['required','string'],
            'episodes'     => ['required','integer','min:1'],
            'release_date' => ['required','date'],
            'publisher_id' => ['required','exists:publishers,id'],
            'active'       => ['sometimes','boolean'],
        ]);

        $data['active'] = (bool)($data['active'] ?? true);
        $data['user_id'] = $request->user()?->id; // optioneel: koppel aan ingelogde user

        $serie = Serie::create($data);

        return redirect()->route('series.show', $serie);
    }

    public function show(Serie $serie)
    {
        $serie->load('publisher','user');
        return view('series.show', compact('serie'));
    }

    public function edit(Serie $serie)
    {
        $publishers = Publisher::orderBy('name')->get(['id','name']);
        return view('series.edit', compact('serie','publishers'));
    }

    public function update(Request $request, Serie $serie)
    {
        $data = $request->validate([
            'title'        => ['required','string','max:255'],
            'synopsis'     => ['required','string'],
            'episodes'     => ['required','integer','min:1'],
            'release_date' => ['required','date'],
            'publisher_id' => ['required','exists:publishers,id'],
            'active'       => ['sometimes','boolean'],
        ]);

        if (array_key_exists('active', $data)) {
            $data['active'] = (bool)$data['active'];
        }

        $serie->update($data);

        return redirect()->route('series.show', $serie);
    }

    public function destroy(Serie $serie)
    {
        $serie->delete();
        return redirect()->route('series.index');
    }

    public function toggle(Serie $serie)
    {
        $serie->update(['active' => ! $serie->active]);
        return back();
    }
}
