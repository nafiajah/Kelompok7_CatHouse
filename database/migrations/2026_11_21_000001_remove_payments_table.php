<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('reservations')) {
            if (!Schema::hasColumn('reservations', 'jumlah_tamu')) {
                Schema::table('reservations', function (Blueprint $table) {
                    $table->integer('jumlah_tamu')->default(1)->after('id_sesi');
                });
            }

            if (!Schema::hasColumn('reservations', 'total_harga')) {
                Schema::table('reservations', function (Blueprint $table) {
                    $table->decimal('total_harga', 10, 2)->default(0)->after('jumlah_tamu');
                });
            }

            if (Schema::hasTable('payments')) {
                if (Schema::hasColumn('reservations', 'id_payments')) {
                    $payments = DB::table('payments')->get()->keyBy('id');
                    foreach ($payments as $paymentId => $payment) {
                        DB::table('reservations')
                            ->where('id_payments', $paymentId)
                            ->update([
                                'jumlah_tamu' => $payment->jumlah_tamu,
                                'total_harga' => $payment->total_harga,
                            ]);
                    }
                } elseif (Schema::hasColumn('payments', 'id_reservasi')) {
                    $payments = DB::table('payments')->get()->keyBy('id_reservasi');
                    foreach ($payments as $reservationId => $payment) {
                        DB::table('reservations')
                            ->where('id', $reservationId)
                            ->update([
                                'jumlah_tamu' => $payment->jumlah_tamu,
                                'total_harga' => $payment->total_harga,
                            ]);
                    }
                }
            }

            if (Schema::hasColumn('reservations', 'id_payments')) {
                if (DB::getDriverName() === 'sqlite') {
                    Schema::disableForeignKeyConstraints();
                    Schema::create('reservations_temp', function (Blueprint $table) {
                        $table->id();
                        $table->foreignId('id_users')->constrained('members')->onDelete('cascade');
                        $table->foreignId('id_sesi')->nullable()->constrained('sessions')->onDelete('set null');
                        $table->integer('jumlah_tamu')->default(1);
                        $table->decimal('total_harga', 10, 2)->default(0);
                        $table->date('tanggal_reservasi');
                        $table->time('waktu_reservasi');
                    });

                    DB::statement('INSERT INTO reservations_temp (id, id_users, id_sesi, jumlah_tamu, total_harga, tanggal_reservasi, waktu_reservasi) SELECT id, id_users, id_sesi, jumlah_tamu, total_harga, tanggal_reservasi, waktu_reservasi FROM reservations');
                    Schema::drop('reservations');
                    Schema::rename('reservations_temp', 'reservations');
                    Schema::enableForeignKeyConstraints();
                } else {
                    Schema::table('reservations', function (Blueprint $table) {
                        $table->dropForeign(['id_payments']);
                        $table->dropColumn('id_payments');
                    });
                }
            }
        }

        Schema::dropIfExists('payments');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Payment feature intentionally removed
    }
};
