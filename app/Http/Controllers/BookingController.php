<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Http\Requests\StoreBookingRequest;
use App\Interfaces\BookingRepositoryInterface;
use Exception;
use Illuminate\Http\Response;

class BookingController extends Controller
{
    public function __construct(public BookingRepositoryInterface $bookingRepository)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = auth()->user();

            $bookings = $this->bookingRepository->getUserBookings($user);

            return $bookings;
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request)
    {
        try {
            $user = auth()->user();

            // Check if the requested escape room and user are available
            if ($this->bookingRepository->checkBookingExists($request->escape_room_id, $user->id)) {
                throw new Exception("You cannot have more than one booking per escape room");
            }

            // check correct timeSlot
            if (!$this->bookingRepository->checkValidTimeSlot($request->time_slot_id, $request->escape_room_id)) {
                throw new Exception("No valid time slot and escape room entered", 400);
            }

            //Check if the maximum number of participants is reached
            if ($this->bookingRepository->checkMaxParticipantsReached($request->escape_room_id)) {
                throw new Exception("The maximum number of participants for this escape room has been reached.");
            }

            $booking = $this->bookingRepository->createBooking([
                'user_id' => $user->id,
                'escape_room_id' => $request->escape_room_id,
                'time_slot_id' => $request->time_slot_id,
                'discount_percent' => $request->discount_percent,
            ]);
            if ($booking) {
                return response([
                    'message' => 'Booking created successfully',
                    'booking' => $booking
                ], Response::HTTP_CREATED);
            }
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        try {
            return $this->bookingRepository->deleteBooking($booking);
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }
    }
}
