<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Service;
use App\Models\EventDetail;
use App\Models\CountPage;
class EventDetailController extends Controller
{
    public function index()
    {
        $countPages = CountPage::first();

        CountPage::where('id', $countPages->id)
            ->update([
                'eventdetails' => $countPages->eventdetails + 1
            ]);

        $countPages = CountPage::first();

        $events = Event::all();
        $services = Service::all();
        $eventdetails = EventDetail::all();
        return view('admin.eventdetail.index', compact('events', 'services', 'eventdetails', 'countPages'));
    }

   

    public function store(Request $request)
    {
         // Validación de los datos del formulario
         $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'servicio_id' => 'required|exists:servicios,id',
            'costo_servicio' => 'required|numeric|min:0',
        ]);
        EventDetail::create($request->all());
        return redirect()->route('eventdetails.index')->with('success', 'Servicio creado correctamente');
    }

   

    public function update(Request $request, EventDetail $eventdetail)
    {
        // Validación de los datos del formulario
        $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'servicio_id' => 'required|exists:servicios,id',
            'costo_servicio' => 'required|numeric|min:0',
        ]);
        $eventdetail->update($request->all());
        return redirect()->route('eventdetails.index')->with('success', 'Servicio actualizado correctamente');
    }

    public function destroy(EventDetail $eventdetail)
    {
        $eventdetail->delete();
        return redirect()->route('eventdetails.index')->with('success', 'Servicio eliminado correctamente');
    }
}
