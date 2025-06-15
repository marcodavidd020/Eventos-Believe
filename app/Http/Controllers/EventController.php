<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\CountPage;
use App\Models\Booking;
use GuzzleHttp\Client;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countPages = CountPage::first();

        CountPage::where('id', $countPages->id)
            ->update([
                'events' => $countPages->events + 1
            ]);

        $countPages = CountPage::first();

        /* dd($countPages->events); */

        $events = Event::all();
        return view('admin.event.index', compact('events', 'countPages'));
    }

    /* Show */
    public function show(Event $event)
    {
        $hasBooking = false;
        
        if (auth()->check()) {
            $idUser = auth()->user()->id;
            $bookingsCount = Booking::where('evento_id', $event->id)->where('usuario_id', $idUser)->count();
            $hasBooking = $bookingsCount > 0;
        }
        
        return view('client.event.show', compact('event', 'hasBooking'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        /* dd($request->all()); */

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'capacidad' => 'required|integer|min:1',
            'precio_entrada' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'hora' => 'required',
            'ubicacion' => 'required|string|max:255',
            'estado' => 'required|in:Activo,Inactivo,Programado',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Asegúrate de que este campo está en tu formulario
        ]);

        $eventData = $request->all();

        if ($request->hasFile('imagen')) {
            $result = $request->file('imagen')->storeOnCloudinary();
            $eventData['imagen'] = $result->getSecurePath();
            $eventData['public_id'] = $result->getPublicId();
        }

        Event::create($eventData);

        return redirect()->route('events.index')->with('success', 'Evento creado correctamente');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'capacidad' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'hora' => 'required',
            'ubicacion' => 'required|string|max:255',
            'estado' => 'required|in:Activo,Inactivo,Programado',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $eventData = $request->all();

        if ($request->hasFile('imagen')) {
            $result = $request->file('imagen')->storeOnCloudinary();
            $eventData['imagen'] = $result->getSecurePath();
            $eventData['public_id'] = $result->getPublicId();
        } else {
            $eventData['imagen'] = $event->imagen;
            $eventData['public_id'] = $event->public_id;
        }

        $event->update($eventData);

        return redirect()->route('events.index')->with('success', 'Evento actualizado correctamente');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Evento eliminado correctamente');
    }

    public function RecolectarDatos(Request $request)
    {
        dd($request->all());
        try {
            $lcComerceID           = "d029fa3a95e174a19934857f535eb9427d967218a36ea014b70ad704bc6c8d1c";
            $lnMoneda              = 2;
            $lnTelefono            = $request->tnTelefono;
            $lcNombreUsuario       = $request->tcRazonSocial;
            $lnCiNit               = $request->tcCiNit;
            $lcNroPago             = "UAGRM-SC-GRUPO1-1";
            $lnMontoClienteEmpresa = $request->tnMonto;
            $lcCorreo              = $request->tcCorreo;
            $lcUrlCallBack         = "http://localhost:8000/";
            $lcUrlReturn           = "http://localhost:8000/";
            $laPedidoDetalle       = $request->taPedidoDetalle;
            $lcUrl                 = "";

            $loClient = new Client();

            if ($request->tnTipoServicio == 1) {
                $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/generarqrv2";
            } elseif ($request->tnTipoServicio == 2) {
                $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/realizarpagotigomoneyv2";
            }

            $laHeader = [
                'Accept' => 'application/json'
            ];

            $laBody   = [
                "tcCommerceID"          => $lcComerceID,
                "tnMoneda"              => $lnMoneda,
                "tnTelefono"            => $lnTelefono,
                'tcNombreUsuario'       => $lcNombreUsuario,
                'tnCiNit'               => $lnCiNit,
                'tcNroPago'             => $lcNroPago,
                "tnMontoClienteEmpresa" => $lnMontoClienteEmpresa,
                "tcCorreo"              => $lcCorreo,
                'tcUrlCallBack'         => $lcUrlCallBack,
                "tcUrlReturn"           => $lcUrlReturn,
                'taPedidoDetalle'       => $laPedidoDetalle
            ];

            $loResponse = $loClient->post($lcUrl, [
                'headers' => $laHeader,
                'json' => $laBody
            ]);

            $laResult = json_decode($loResponse->getBody()->getContents());

            if ($request->tnTipoServicio == 1) {

                $laValues = explode(";", $laResult->values)[1];


                $laQrImage = "data:image/png;base64," . json_decode($laValues)->qrImage;
                echo '<img src="' . $laQrImage . '" alt="Imagen base64">';
            } elseif ($request->tnTipoServicio == 2) {

                $csrfToken = csrf_token();

                echo '<h5 class="text-center mb-4">' . $laResult->message . '</h5>';
                echo '<p class="blue-text">Transacción Generada: </p><p id="tnTransaccion" class="blue-text">' . $laResult->values . '</p><br>';
                echo '<iframe name="QrImage" style="width: 100%; height: 300px;"></iframe>';
                echo '<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>';

                echo '<script>
                        $(document).ready(function() {
                            function hacerSolicitudAjax(numero) {
                                // Agrega el token CSRF al objeto de datos
                                var data = { _token: "' . $csrfToken . '", tnTransaccion: numero };

                                $.ajax({
                                    url: \'/consultar\',
                                    type: \'POST\',
                                    data: data,
                                    success: function(response) {
                                        var iframe = document.getElementsByName(\'QrImage\')[0];
                                        iframe.contentDocument.open();
                                        iframe.contentDocument.write(response.message);
                                        iframe.contentDocument.close();
                                    },
                                    error: function(error) {
                                        console.error(error);
                                    }
                                });
                            }

                            setInterval(function() {
                                hacerSolicitudAjax(' . $laResult->values . ');
                            }, 7000);
                        });
                    </script>';
            }
        } catch (\Throwable $th) {

            return $th->getMessage() . " - " . $th->getLine();
        }
    }
}
