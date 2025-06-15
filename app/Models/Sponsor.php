<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;
    protected $table = 'patrocinadores';

    protected $fillable = [
        'nombre',
        'descripcion',
        'email',
        'telefono',
    ];

    // Habilitar timestamps para que funcione created_at
    public $timestamps = true;

    /**
     * Relación con patrocinios
     */
    public function sponsorships()
    {
        return $this->hasMany(Sponsorship::class, 'patrocinador_id');
    }
}
