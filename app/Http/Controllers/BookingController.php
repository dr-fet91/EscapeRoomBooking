<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\EscapeRoom;
use Exception;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            /**
             *  Get the authenticated user
             *  @var User $user 
             */
            $user = auth()->user();

            return $user->bookings()->paginate();
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request)
    {
        try {
            /**
             *  Get the authenticated user
             *  @var User $user 
             */
            $user = auth()->user();

            // Check if the requested escape room and time slot are available
            $bookingExists = Booking::where('escape_room_id', $request->escape_room_id)->where('time_slot_id', $request->time_slot_id)->exists();

            if ($bookingExists) {
                throw new Exception("This time slot is already booked for the selected escape room.", 400);
            }

            // Get the maximum number of participants for the selected escape room
            $escapeRoom = EscapeRoom::findOrFail($request->escape_room_id);
            $maxParticipants = $escapeRoom->max_participants;

            // Check if the maximum number of participants is reached
            $participantsCount = Booking::where('escape_room_id', $request->escape_room_id)
                ->where('time_slot_id', $request->time_slot_id)
                ->sum('participants_count');

            if ($participantsCount >= $maxParticipants) {
                throw new Exception("The maximum number of participants for this escape room has been reached.");
            }

            $booking = new Booking([
                'user_id' => $user->id,
                'escape_room_id' => $request->escape_room_id,
                'time_slot_id' => $request->time_slot_id,
                'discount_percent' => $request->discount_percent,
            ]);

            // Apply discount if it's the user's birthday
            if ($user->isBirthday() && !$request->discount_percent > 90) {
                // Apply 10% discount
                $booking->discount_percent += 10;
            }

            // Save the booking
            $booking->save();

            // Return a response
            return [
                'message' => 'Booking created successfully',
                'booking' => $booking
            ];
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        try {
            /**
             *  Get the authenticated user
             *  @var User $user 
             */
            $user = auth()->user();

            if ($user->cannot('delete', $booking)) throw new Exception("You are not authorized to delete this booking", 403);

            return $booking->delete();
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }
    }
}
