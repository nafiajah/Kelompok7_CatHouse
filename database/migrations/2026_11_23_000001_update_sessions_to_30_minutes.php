<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        if (!Schema::hasTable('sessions')) {
            return;
        }

        $thirtyMinSessions = [
            ['jam_sesi' => '08:00 - 08:30', 'token_sesi' => 10],
            ['jam_sesi' => '08:30 - 09:00', 'token_sesi' => 10],
            ['jam_sesi' => '09:00 - 09:30', 'token_sesi' => 10],
            ['jam_sesi' => '09:30 - 10:00', 'token_sesi' => 10],
            ['jam_sesi' => '10:00 - 10:30', 'token_sesi' => 10],
            ['jam_sesi' => '10:30 - 11:00', 'token_sesi' => 10],
            ['jam_sesi' => '11:00 - 11:30', 'token_sesi' => 10],
            ['jam_sesi' => '11:30 - 12:00', 'token_sesi' => 10],
            ['jam_sesi' => '12:00 - 12:30', 'token_sesi' => 10],
            ['jam_sesi' => '12:30 - 13:00', 'token_sesi' => 10],
            ['jam_sesi' => '13:00 - 13:30', 'token_sesi' => 10],
            ['jam_sesi' => '13:30 - 14:00', 'token_sesi' => 10],
            ['jam_sesi' => '14:00 - 14:30', 'token_sesi' => 10],
            ['jam_sesi' => '14:30 - 15:00', 'token_sesi' => 10],
            ['jam_sesi' => '15:00 - 15:30', 'token_sesi' => 10],
            ['jam_sesi' => '15:30 - 16:00', 'token_sesi' => 10],
            ['jam_sesi' => '16:00 - 16:30', 'token_sesi' => 10],
            ['jam_sesi' => '16:30 - 17:00', 'token_sesi' => 10],
        ];

        $existingIds = DB::table('sessions')->orderBy('id')->pluck('id')->values();

        foreach ($thirtyMinSessions as $index => $data) {
            $alreadyExists = DB::table('sessions')->where('jam_sesi', $data['jam_sesi'])->exists();
            if ($alreadyExists) {
                continue;
            }

            if (isset($existingIds[$index])) {
                DB::table('sessions')
                    ->where('id', $existingIds[$index])
                    ->update($data);
            } else {
                DB::table('sessions')->insert($data);
            }
        }
    }

    public function down(): void
    {

    }
};
