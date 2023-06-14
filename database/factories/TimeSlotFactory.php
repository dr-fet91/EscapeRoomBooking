<?php

namespace Database\Factories;

use App\Models\EscapeRoom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TimeSlot>
 */
class TimeSlotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = now();
        $endTime = $startTime->addHour(); 
        return [
            'escape_room_id' => EscapeRoom::factory(),
            'start_time' => $startTime,
            'end_time' => $endTime,
        ];
    }
}
