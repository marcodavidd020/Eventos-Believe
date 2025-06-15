<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    use HasFactory;
    protected $table = 'patrocinios';
    protected $fillable = [
        'aporte',
        'patrocinador_id',
        'evento_id'
    ];

    public function patrocinador()
    {
        return $this->belongsTo(Sponsor::class, 'patrocinador_id');
    }

    public function evento()
    {
        return $this->belongsTo(Event::class, 'evento_id');
    }
}
