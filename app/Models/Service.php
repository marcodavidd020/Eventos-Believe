<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = 'servicios';
    protected $fillable = [
        'nombre',
        'descripcion',
        'proveedor_id'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Supplier::class, 'proveedor_id');
    }

    public function eventos()
    {
        return $this->hasMany(Event::class, 'servicio_id');
    }
}
