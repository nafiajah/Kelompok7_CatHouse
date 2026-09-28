<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. setuju setuju
     */
    public function up(): void
    {
        Schema::create('data_kucing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_variant')->constrained('variants')->onDelete('cascade');
            $table->string('nama_kucing', 50)->unique();
            $table->text('deskripsi');
            $table->string('foto', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_kucing');
    }
};
