<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Promotion;
use App\Models\CountPage;

class PromotionController extends Controller
{
    public function index()
    {
        $countPages = CountPage::first();

        CountPage::where('id', $countPages->id)
            ->update([
                'promotions' => $countPages->promotions + 1
            ]);

        $countPages = CountPage::first();

        $events = Event::all();
        $promotions = Promotion::all();
        return view('admin.promotion.index', compact('events', 'promotions', 'countPages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'descuento' => 'required|integer|min:0|max:100',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'evento_id' => 'required|exists:eventos,id',
        ]);

        Promotion::create($request->all());
        return redirect()->route('promotions.index')->with('success', 'Promocion creado correctamente');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promotion $promotion)
    {
        $request->validate([
           'descripcion' => 'required|string|max:255',
            'descuento' => 'required|integer|min:0|max:100',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'evento_id' => 'required|exists:eventos,id',
        ]);

        $promotion->update($request->all());
        return redirect()->route('promotions.index')->with('success', 'Promocion actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return redirect()->route('promotions.index')->with('success', 'Promocion eliminado correctamente');
    }
}
