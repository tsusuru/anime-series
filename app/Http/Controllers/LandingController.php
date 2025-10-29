<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use App\Models\Publisher;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $q        = $request->query('q');
        $pub      = $request->query('publisher_id');
        $status   = $request->query('status', 'active');
        $perPage  = 9;

        $query = Serie::query()->with('publisher');

        if ($q) {
            $query->where(fn($qq) =>
            $qq->where('title','like',"%{$q}%")
                ->orWhere('synopsis','like',"%{$q}%")
            );
        }
        if ($pub) {
            $query->where('publisher_id', $pub);
        }
        if ($status === 'active')      $query->where('active', true);
        elseif ($status === 'inactive')$query->where('active', false);

        $series     = $query->latest()->paginate($perPage)->withQueryString();
        $publishers = Publisher::orderBy('name')->get();

        // Voorgevulde naam in de suggestie-balk (als er een publisher_id in de query zit)
        $publisherName = optional($publishers->firstWhere('id', (int)$pub))->name;

        return view('landing.index', compact('series','publishers','q','pub','status','publisherName'));
    }

}
