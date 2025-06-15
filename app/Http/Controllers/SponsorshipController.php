<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sponsorship;
use App\Models\Event;
use App\Models\Sponsor;
use App\Models\CountPage;

class SponsorshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countPages = CountPage::first();

        CountPage::where('id', $countPages->id)
            ->update([
                'sponsorships' => $countPages->sponsorships + 1
            ]);

        $countPages = CountPage::first();

        $sponsorships = Sponsorship::all();
        $events = Event::all();
        $sponsors = Sponsor::all();

        return view('admin.sponsorship.index', compact('sponsorships', 'events', 'sponsors', 'countPages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'aporte' => 'required|numeric|min:0',
            'patrocinador_id' => 'required|exists:patrocinadores,id',
            'evento_id' => 'required|exists:eventos,id'
        ]);

        Sponsorship::create($request->all());

        return redirect()->route('sponsorships.index')->with('success', 'Patrocinio creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sponsorship $sponsorship)
    {
        $request->validate([
            'aporte' => 'required|numeric|min:0',
            'patrocinador_id' => 'required|exists:patrocinadores,id',
            'evento_id' => 'required|exists:eventos,id'
        ]);

        $sponsorship->update($request->all());
        return redirect()->route('sponsorships.index')->with('success', 'Patrocinio actualizado correctamente');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sponsorship $sponsorship)
    {
        $sponsorship->delete();
        return redirect()->route('sponsorships.index')->with('success', 'Patrocinio eliminado correctamente');
    }
}
