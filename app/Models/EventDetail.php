<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventDetail extends Model
{
    use HasFactory;

    protected $table = 'detalle_eventos';

    protected $fillable = [
        'evento_id',
        'servicio_id',
        'costo_servicio',
    ];

    public function evento()
    {
        return $this->belongsTo(Event::class, 'evento_id');
    }

    public function servicio()
    {
        return $this->belongsTo(Service::class, 'servicio_id');
    }
}
