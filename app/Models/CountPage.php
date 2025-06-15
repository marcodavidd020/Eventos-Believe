<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountPage extends Model
{
    use HasFactory;
    protected $table = 'count_pages';
    protected $fillable = ['sponsors', 'events','eventdetails', 'sponsorships', 'promotions', 'providers', 'bookings', 'bookings-users', 'services', 'users', 'home', 'stores'];
}
