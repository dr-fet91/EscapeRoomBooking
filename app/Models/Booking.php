<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    /**
     * Get the user associated with the booking.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the escape room associated with the booking.
     */
    public function escapeRoom(): BelongsTo
    {
        return $this->belongsTo(EscapeRoom::class);
    }

    /**
     * Get the time slot associated with the booking.
     */
    public function timeSlot(): BelongsTo
    {
        return $this->belongsTo(TimeSlot::class);
    }
}
