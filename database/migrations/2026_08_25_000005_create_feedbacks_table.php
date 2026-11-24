<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->nullable()->constrained('members')->onDelete('cascade');
            $table->string('nama_pengirim', 100)->nullable();
            $table->timestamp('tanggal_saran')->useCurrent();
            $table->text('teks_saran');
            $table->integer('bintang');
            $table->enum('status_tampil', ['tampil', 'tidak'])->default('tidak');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
