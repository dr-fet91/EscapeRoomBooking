<?php

namespace Database\Seeders;

use App\Models\EscapeRoom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EscapeRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EscapeRoom::factory(10)->create();
    }
}
