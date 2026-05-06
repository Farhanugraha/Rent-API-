<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('renter_id')->constrained('renter_accounts')->onDelete('cascade'); 
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade'); 
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->decimal('total_price', 12, 2);
            $table->enum('status', ['pending', 'confirmed', 'ongoing', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};