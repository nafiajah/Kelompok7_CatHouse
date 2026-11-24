<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add nama_pengirim to feedbacks table if not exists
        if (Schema::hasTable('feedbacks') && !Schema::hasColumn('feedbacks', 'nama_pengirim')) {
            Schema::table('feedbacks', function (Blueprint $table) {
                $table->string('nama_pengirim', 100)->nullable()->after('id_user');
            });
        }

        // 2. Change foto in data_kucing to LONGTEXT to support base64 images on serverless
        if (Schema::hasTable('data_kucing') && Schema::hasColumn('data_kucing', 'foto')) {
            DB::statement('ALTER TABLE `data_kucing` MODIFY `foto` LONGTEXT NULL');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('feedbacks') && Schema::hasColumn('feedbacks', 'nama_pengirim')) {
            Schema::table('feedbacks', function (Blueprint $table) {
                $table->dropColumn('nama_pengirim');
            });
        }

        if (Schema::hasTable('data_kucing') && Schema::hasColumn('data_kucing', 'foto')) {
            DB::statement('ALTER TABLE `data_kucing` MODIFY `foto` VARCHAR(255) NOT NULL');
        }
    }
};
