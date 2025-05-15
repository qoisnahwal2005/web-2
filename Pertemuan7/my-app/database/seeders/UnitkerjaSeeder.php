<?php

namespace Database\Seeders;

use App\Models\unitkerja;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitkerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        unitkerja::create([
            "kode" => "A123",
            "nama" => "LPPM",
        ]);
    }
}
