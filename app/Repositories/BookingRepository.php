<?php

namespace App\Repositories;

use App\Interfaces\BookingRepositoryInterface;
use App\Models\Booking;
use App\Models\EscapeRoom;
use App\Models\TimeSlot;
use App\Models\User;
use Exception;

class BookingRepository implements BookingRepositoryInterface
{
    public function getUserBookings($user)
    {
        return $user->bookings()->paginate();
    }

    /**
     * Check if a booking exists for the specified escape room and user.
     *
     * @param int $escapeRoomId
     * @param int $userId
     * @return bool
     */
    public function checkBookingExists($escapeRoomId, $userId)
    {
        return Booking::where('escape_room_id', $escapeRoomId)->where('user_id', $userId)->exists();
    }

    /**
     * Check if a time slot is valid for the specified escape room.
     *
     * @param int $timeSlotId
     * @param int $escapeRoomId
     * @return bool
     */
    public function checkValidTimeSlot($timeSlotId, $escapeRoomId)
    {
        return TimeSlot::where('id', $timeSlotId)->where('escape_room_id', $escapeRoomId)->exists();
    }

    /**
     * Check if the maximum number of participants is reached for the specified escape room.
     *
     * @param int $escapeRoomId
     * @return bool
     */
    public function checkMaxParticipantsReached($escapeRoomId)
    {
        // Get the maximum number of participants for the selected escape room
        $escapeRoom = EscapeRoom::findOrFail($escapeRoomId);
        $maxParticipants = $escapeRoom->max_participants;

        // Check if the maximum number of participants is reached
        $participantsCount = Booking::where('escape_room_id', $escapeRoomId)->count();

        return $participantsCount >= $maxParticipants;
    }

    /**
     * Create a new booking.
     *
     * @param array $data
     * @return Booking
     * @throws Exception
     */
    public function createBooking($data)
    {
        $booking = new Booking([
            'user_id' => $data['user_id'],
            'escape_room_id' => $data['escape_room_id'],
            'time_slot_id' => $data['time_slot_id'],
            'discount_percent' => $data['discount_percent'],
        ]);

        // Apply 10% discount if it's the user's birthday
        $user = $booking->user;
        if ($user->isBirthday() && $data['discount_percent'] < 90) {
            $booking->discount_percent += 10;
        }

        $booking->save();

        return $booking;
    }

    /**
     * Delete a booking.
     *
     * @param int $bookingId
     * @return bool
     * @throws Exception
     */
    public function deleteBooking($booking)
    {
        /**
         *  Get the authenticated user
         *  @var User $user 
         */
        $user = auth()->user();

        if ($user->cannot('delete', $booking)) {
            throw new Exception("You are not authorized to delete this booking", 403);
        }

        return $booking->delete();
    }
}
