<?php

namespace Database\Factories;

use App\Models\EscapeRoom;
use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'escape_room_id' => EscapeRoom::factory(),
            'time_slot_id' => TimeSlot::factory(),
            'discount_percent' => fake()->numberBetween(0, 50),
        ];
    }
}
