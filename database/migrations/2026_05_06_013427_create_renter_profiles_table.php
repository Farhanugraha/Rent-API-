<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('renter_profiles', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('renter_id')->constrained('renter_accounts')->onDelete('cascade'); 
            $table->string('full_name')->nullable();
            $table->char('nik', 16)->unique()->nullable();
            $table->string('license_no')->unique()->nullable();
            $table->string('sim_image_url')->nullable();  
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('renter_profiles');
    }
};