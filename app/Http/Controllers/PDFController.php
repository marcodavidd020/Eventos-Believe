<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Sponsor;
use App\Models\Service;
use App\Models\Sponsorship;
use App\Models\Event;
use App\Models\EventDetail;
use App\Models\User;
use App\Models\Promotion;
use App\Models\Supplier;
use App\Models\Booking;
class PDFController extends Controller
{
    public function sponsorspdf()
    {
        $sponsors = Sponsor::all();
        $pdf = Pdf::loadView('admin.sponsor.pdf', compact('sponsors'));
        return $pdf->download('patrocinador.pdf');
    }

    public function servicespdf()
    {
        $services = Service::all();
        $pdf = Pdf::loadView('admin.service.pdf', compact('services'));
        return $pdf->download('servicios.pdf');
    }

    public function sponsorshipspdf()
    {    
        $sponsorships = Sponsorship::all();
        $pdf = Pdf::loadView('admin.sponsorship.pdf', compact('sponsorships'));
        return $pdf->download('patrocinios.pdf');
    }

    public function eventspdf()
    {
        $events = Event::all();
        $pdf = Pdf::loadView('admin.event.pdf', compact('events'));
        return $pdf->download('eventos.pdf');
    }

    public function eventdetailspdf()
    {
        $eventdetails = EventDetail::all();
        $pdf = Pdf::loadView('admin.eventdetail.pdf', compact('eventdetails'));
        return $pdf->download('eventosservicio.pdf');
    }

    public function userspdf()
    {
        $users = User::all();
        $pdf = Pdf::loadView('admin.user.pdf', compact('users'));
        return $pdf->download('usuarios.pdf');
    }

    public function promotionspdf()
    {
        $promotions = Promotion::all();
        $pdf = Pdf::loadView('admin.promotion.pdf', compact('promotions'));
        return $pdf->download('promocion.pdf');
    }

    public function supplierspdf()
    {
        $suppliers = Supplier::all();
        $pdf = Pdf::loadView('admin.supplier.pdf', compact('suppliers'));
        return $pdf->download('proveedores.pdf');
    }

    public function bookingspdf()
    {
        $bookings = Booking::all();
        $pdf = Pdf::loadView('admin.booking.pdf', compact('bookings'));
        return $pdf->download('reservas.pdf');
    }
}
