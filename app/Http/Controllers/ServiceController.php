<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\CountPage;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countPages = CountPage::first();

        CountPage::where('id', $countPages->id)
            ->update([
                'services' => $countPages->services + 1
            ]);

        $countPages = CountPage::first();
        //
        $services = Service::all();
        $suppliers = Supplier::all();
        return view('admin.service.index', compact('services','suppliers', 'countPages'));
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
            'descripcion' => 'required|string',
            'proveedor_id' => 'required|exists:proveedores,id',
        ]);

        Service::create($request->all());
        return redirect()->route('services.index')->with('success', 'Servicio creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('admin.service.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'proveedor_id' => 'required|exists:proveedores,id',
        ]);

        $service->update($request->all());
        return redirect()->route('services.index')->with('success', 'Servicio actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Servicio eliminado correctamente');
    }
}
