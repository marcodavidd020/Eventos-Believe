<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;

class Promotion extends Model
{
    use HasFactory;
    protected $table = 'promociones';
    protected $fillable = [
        'descripcion', 'descuento', 'fecha_inicio', 'fecha_fin', 'evento_id'
    ];

    public function evento()
    {
        return $this->belongsTo(Event::class, 'evento_id');
    }

    public $timestamps = false;
}
