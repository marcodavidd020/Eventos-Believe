<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'reservas';

    protected $fillable = [
        'codigo',
        'fecha',
        'costo_entrada',
        'cantidad',
        'costo_total',
        'estado',
        'usuario_id',
        'evento_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function evento()
    {
        return $this->belongsTo(Event::class, 'evento_id');
    }
}
