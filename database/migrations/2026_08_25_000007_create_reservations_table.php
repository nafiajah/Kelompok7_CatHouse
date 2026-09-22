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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_payments')->constrained('payments')->onDelete('cascade');
            $table->foreignId('id_users')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_sesi')->nullable()->constrained('sessions')->onDelete('set null');
            $table->date('tanggal_reservasi');
            $table->time('waktu_reservasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
