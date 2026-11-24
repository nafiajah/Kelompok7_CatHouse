<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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
        if (Schema::hasTable('feedbacks')) {
            Schema::table('feedbacks', function (Blueprint $t) {
                if (Schema::hasColumn('feedbacks', 'nama_pengirim')) {
                    $t->dropColumn('nama_pengirim');
                }
            });
        }
    }
};
