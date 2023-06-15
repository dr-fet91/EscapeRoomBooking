<?php

namespace Tests\Unit;

use App\Models\EscapeRoom;
use App\Models\TimeSlot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EscapeRoomControllerTest extends TestCase
{
    use RefreshDatabase;
    public function testGetAllEscapeRooms()
    {
        // Create some escape rooms
        EscapeRoom::factory()->count(3)->create();

        // Send a GET request to api/escape-rooms
        $response = $this->get('api/escape-rooms');

        // Assert the response status code
        $response->assertStatus(200);

        // Assert the response structure and data
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'theme',
                    'max_participants',
                ]
            ]
        ]);
    }

    public function testGetSpecificEscapeRoom()
    {
        // Create an escape room
        $escapeRoom = EscapeRoom::factory()->create();

        // Send a GET request to api/escape-rooms/{id}
        $response = $this->get('api/escape-rooms/' . $escapeRoom->id);

        // Assert the response status code
        $response->assertStatus(200);

        // Assert the response structure and data
        $response->assertJsonStructure([
            'id',
            'name',
            'theme',
            'max_participants',
            'created_at',
            'updated_at',
        ]);
    }

    public function testGetTimeSlotsForEscapeRoom()
    {
        // Create an escape room
        $escapeRoom = EscapeRoom::factory()->create();

        // Create some time slots for the escape room
        TimeSlot::factory()->count(3)->create([
            'escape_room_id' => $escapeRoom->id,
        ]);

        // Send a GET request to api/escape-rooms/{id}/time-slots
        $response = $this->get('api/escape-rooms/' . $escapeRoom->id . '/time-slots');

        // Assert the response status code
        $response->assertStatus(200);

        // Assert the response structure and data
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'start_time',
                    'end_time',
                ]
            ]
        ]);
    }
}
