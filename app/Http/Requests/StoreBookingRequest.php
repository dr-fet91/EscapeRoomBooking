<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'escape_room_id' => 'required|exists:escape_rooms,id',
            'time_slot_id' => 'required|exists:time_slots,id',
            'discount_percent' => 'nullable|numeric|min:0|max:100'
        ];
    }
}
