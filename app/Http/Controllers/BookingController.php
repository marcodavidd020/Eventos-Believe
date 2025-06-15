<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\CountPage;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countPages = CountPage::first();

        CountPage::where('id', $countPages->id)
            ->update([
                'bookings' => $countPages->bookings + 1
            ]);

        $countPages = CountPage::first();

        $bookings = Booking::all();
        return view('admin.booking.index', compact('bookings', 'countPages'));
    }

    public function indexClient()
    {
        $bookings = Booking::where('usuario_id', auth()->user()->id)->get();
        return view('client.booking.index', compact('bookings'));
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
        Booking::create(
            [
                'codigo' => uniqid(),
                'fecha' => date('Y-m-d'),
                'costo_entrada' => $request->costo_entrada,
                'cantidad' => 1,
                'costo_total' => $request->costo_entrada,
                'estado' => 'Pagado',
                'usuario_id' => auth()->user()->id,
                'evento_id' => $request->evento_id,
            ]
        );

        return redirect()->route('booking-client')->with('success', 'Reserva creada correctamente');
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
