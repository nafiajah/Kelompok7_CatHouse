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
        if (Schema::hasTable('users') && !Schema::hasTable('members')) {
            Schema::rename('users', 'members');
        }

        $table = Schema::hasTable('members') ? 'members' : (Schema::hasTable('users') ? 'users' : null);
        if ($table && Schema::hasColumn($table, 'nama_pelanggan') && !Schema::hasColumn($table, 'nama_lengkap')) {
            Schema::table($table, function (Blueprint $t) {
                $t->renameColumn('nama_pelanggan', 'nama_lengkap');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $table = Schema::hasTable('members') ? 'members' : (Schema::hasTable('users') ? 'users' : null);
        if ($table && Schema::hasColumn($table, 'nama_lengkap') && !Schema::hasColumn($table, 'nama_pelanggan')) {
            Schema::table($table, function (Blueprint $t) {
                $t->renameColumn('nama_lengkap', 'nama_pelanggan');
            });
        }

        if (Schema::hasTable('members') && !Schema::hasTable('users')) {
            Schema::rename('members', 'users');
        }
    }
};
