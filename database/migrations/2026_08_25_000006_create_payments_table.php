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
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); 
            $table->enum('metode_pembayaran', [
                'Transfer Bank',
                'Kartu Kredit',
                'E-Wallet',
                'Tunai'
            ]);
            $table->decimal('total_harga', 10, 2);
            
            $table->timestamp('tanggal_pembayaran')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
