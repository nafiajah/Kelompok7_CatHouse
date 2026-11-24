<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $table = Schema::hasTable('members') ? 'members' : (Schema::hasTable('users') ? 'users' : null);
        if ($table && DB::getDriverName() === 'mysql') {
            try {
                DB::statement("SET FOREIGN_KEY_CHECKS=0;");
                DB::statement("ALTER TABLE `{$table}` MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT");
                DB::statement("SET FOREIGN_KEY_CHECKS=1;");
            } catch (\Throwable $e) {
            }
        }

        if (Schema::hasTable('reservations')) {
            Schema::table('reservations', function (Blueprint $t) {
                if (!Schema::hasColumn('reservations', 'nama_pemesan')) {
                    $t->string('nama_pemesan', 100)->nullable()->after('id_sesi');
                }
                if (!Schema::hasColumn('reservations', 'email_pemesan')) {
                    $t->string('email_pemesan', 100)->nullable()->after('nama_pemesan');
                }
                if (!Schema::hasColumn('reservations', 'no_telp_pemesan')) {
                    $t->string('no_telp_pemesan', 50)->nullable()->after('email_pemesan');
                }
            });
        }

        if (Schema::hasTable('feedbacks')) {
            if (DB::getDriverName() === 'mysql') {
                try {
                    DB::statement("ALTER TABLE `feedbacks` MODIFY `id_user` BIGINT UNSIGNED NULL");
                } catch (\Throwable $e) {}
            }
            Schema::table('feedbacks', function (Blueprint $t) {
                if (!Schema::hasColumn('feedbacks', 'nama_pengirim')) {
                    $t->string('nama_pengirim', 100)->nullable()->after('id_user');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('reservations')) {
            Schema::table('reservations', function (Blueprint $t) {
                $columns = [];
                if (Schema::hasColumn('reservations', 'nama_pemesan')) {
                    $columns[] = 'nama_pemesan';
                }
                if (Schema::hasColumn('reservations', 'email_pemesan')) {
                    $columns[] = 'email_pemesan';
                }
                if (Schema::hasColumn('reservations', 'no_telp_pemesan')) {
                    $columns[] = 'no_telp_pemesan';
                }
                if (!empty($columns)) {
                    $t->dropColumn($columns);
                }
            });
        }
    }
};
