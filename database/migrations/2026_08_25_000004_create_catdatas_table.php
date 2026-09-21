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
        Schema::create('catdatas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_jenis_kucings')->constrained('variants')->onDelete('cascade');
            $table->string('nama_kucing', 50)->unique();
            $table->text('deskripsi');
            $table->string('foto', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
