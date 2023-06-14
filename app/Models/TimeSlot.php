<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimeSlot extends Model
{
    use HasFactory;

    /**
     * Get the escape associated with the TimeSlot.
     */
    public function escapeRoom(): BelongsTo
    {
        return $this->belongsTo(EscapeRoom::class);
    }
}
