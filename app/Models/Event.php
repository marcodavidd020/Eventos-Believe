<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = 'eventos';
    protected $fillable = ['nombre', 'descripcion', 'capacidad', 'precio_entrada', 'fecha', 'hora', 'ubicacion', 'estado', 'imagen', 'public_id'];

    /* public function service()
    {
        return $this->belongsTo(Service::class, 'servicio_id');
    } */

    /**
     * Relación con promociones - Un evento puede tener una promoción activa
     */
    public function promotion()
    {
        return $this->hasOne(Promotion::class, 'evento_id')
                    ->where('fecha_inicio', '<=', now())
                    ->where('fecha_fin', '>=', now());
    }

    /**
     * Relación con todas las promociones del evento
     */
    public function promotions()
    {
        return $this->hasMany(Promotion::class, 'evento_id');
    }

    /**
     * Obtener el precio con descuento aplicado
     */
    public function getDiscountedPriceAttribute()
    {
        if ($this->promotion && $this->promotion->descuento > 0) {
            return $this->precio_entrada * (1 - $this->promotion->descuento / 100);
        }
        return $this->precio_entrada;
    }

    /**
     * Verificar si el evento tiene una promoción activa
     */
    public function hasActivePromotion()
    {
        return $this->promotion !== null;
    }
}
