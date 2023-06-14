<?php

namespace Tests\Unit;

use App\Http\Controllers\BookingController;
use App\Models\Booking;
use App\Models\EscapeRoom;
use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;
use Mockery;

class BookingControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexReturnsListOfBookingsForAuthenticatedUser()
    {
        // create user & bookings
        $user = User::factory()->create();
        $bookings = Booking::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        // login user
        $this->actingAs($user);

        // check index route
        $response = $this->get('/api/bookings');

        // check content & status & count of data
        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'user_id',
                    'escape_room_id',
                    'time_slot_id',
                    'discount_percent',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }


    /**
     * Test storing a new booking.
     *
     * @return void
     */
    public function testStoreBookingAndDelete()
    {
        // Create a user
        $user = User::factory()->create();

        // Create an escape room
        $escapeRoom = EscapeRoom::factory()->create();

        // Create a time slot for the escape room
        $timeSlot = TimeSlot::factory()->create([
            'escape_room_id' => $escapeRoom->id,
        ]);

        // Generate booking data
        $bookingData = [
            'escape_room_id' => $escapeRoom->id,
            'time_slot_id' => $timeSlot->id,
        ];

        // Create a new booking
        $response = $this->actingAs($user)
            ->postJson('/api/bookings', $bookingData);
        // Assert the response status
        $response->assertStatus(Response::HTTP_CREATED);

        // Assert the booking is stored in the database
        $this->assertDatabaseHas('bookings', $bookingData);

        // Get the created booking
        $booking = Booking::where($bookingData)->first();
        // Delete the booking
        $deleteResponse = $this->actingAs($user)
            ->deleteJson("/api/bookings/{$booking->id}");

        // Assert the delete response status
        $deleteResponse->assertStatus(Response::HTTP_OK);

        // Assert the booking is deleted from the database
        $this->assertDatabaseMissing('bookings', $bookingData);
    }
}
