<?php

namespace App\Interfaces;

use App\Models\Booking;
use App\Models\User;

interface BookingRepositoryInterface
{
    public function getUserBookings($user);

    public function checkBookingExists($escapeRoomId, $userId);

    public function checkValidTimeSlot($escapeRoomId, $userId);

    public function checkMaxParticipantsReached($escapeRoomId);

    public function createBooking($data);

    public function deleteBooking(Booking $booking);
}
