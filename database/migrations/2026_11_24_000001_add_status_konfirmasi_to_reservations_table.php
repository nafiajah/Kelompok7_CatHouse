<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('reservations') && !Schema::hasColumn('reservations', 'status_konfirmasi')) {
            Schema::table('reservations', function (Blueprint $table) {
                $table->string('status_konfirmasi', 20)->default('belum')->after('waktu_reservasi');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('reservations') && Schema::hasColumn('reservations', 'status_konfirmasi')) {
            Schema::table('reservations', function (Blueprint $table) {
                $table->dropColumn('status_konfirmasi');
            });
        }
    }
};
