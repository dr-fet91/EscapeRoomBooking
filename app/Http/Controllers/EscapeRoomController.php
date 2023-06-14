<?php

namespace App\Http\Controllers;

use App\Models\EscapeRoom;
use App\Http\Requests\StoreEscapeRoomRequest;
use App\Http\Requests\UpdateEscapeRoomRequest;

class EscapeRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return EscapeRoom::paginate();
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
    public function store(StoreEscapeRoomRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EscapeRoom $escapeRoom)
    {
        try {
            return $escapeRoom;
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }
    }

    /**
     * Get all time slots for a specific escape room.
     *
     * @param  EscapeRoom  $escapeRoom
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTimeSlotsByEscapeRoom(EscapeRoom $escapeRoom)
    {
        try {
            return $escapeRoom->timeSlots()->paginate();
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EscapeRoom $escapeRoom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEscapeRoomRequest $request, EscapeRoom $escapeRoom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EscapeRoom $escapeRoom)
    {
        //
    }
}
