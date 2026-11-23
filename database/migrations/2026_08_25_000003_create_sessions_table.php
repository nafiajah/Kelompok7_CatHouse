<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->string('jam_sesi', 20)->unique();
            $table->integer('token_sesi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
