<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('count_pages', function (Blueprint $table) {
            $table->id();
            $table->integer('sponsors');
            $table->integer('events');
            $table->integer('eventdetails');
            $table->integer('sponsorships');
            $table->integer('promotions');
            $table->integer('providers');
            $table->integer('bookings');
            $table->integer('bookings-users');
            $table->integer('services');
            $table->integer('users');
            $table->integer('home');
            $table->integer('stores');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
