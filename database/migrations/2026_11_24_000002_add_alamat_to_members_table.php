<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tableName = Schema::hasTable('members')
            ? 'members'
            : (Schema::hasTable('users') ? 'users' : null);

        if ($tableName && !Schema::hasColumn($tableName, 'alamat')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('alamat', 100)->nullable()->after('email');
            });
        }
    }

    public function down(): void
    {
        $tableName = Schema::hasTable('members')
            ? 'members'
            : (Schema::hasTable('users') ? 'users' : null);

        if ($tableName && Schema::hasColumn($tableName, 'alamat')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('alamat');
            });
        }
    }
};
