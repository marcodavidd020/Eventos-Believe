<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sponsor;
use App\Models\CountPage;

class SponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countPages = CountPage::first();

        CountPage::where('id', $countPages->id)
            ->update([
                'sponsors' => $countPages->sponsors + 1
            ]);

        $countPages = CountPage::first();
        
        $sponsors = Sponsor::with('sponsorships')->get();
        return view('admin.sponsor.index', compact('sponsors', 'countPages'));
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
            'nombre' => 'required|string|max:255',
            'descripcion' => 'string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required|numeric',   
        ]);

        Sponsor::create($request->all());
        return redirect()->route('sponsors.index')->with('success', 'Patrocinador creado correctamente');
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
    public function update(Request $request, Sponsor $sponsor)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required|numeric',   
        ]);
        $sponsor->update($request->all());
        return redirect()->route('sponsors.index')->with('success', 'Patrocinador actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sponsor $sponsor)
    {
        $sponsor->delete();
        return redirect()->route('sponsors.index')->with('success', 'Patrocinador eliminado correctamente');
    }
}
