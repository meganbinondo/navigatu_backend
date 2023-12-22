<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'event_name'    => 'required|string|max:50',
            'area'          => 'required|string|max:50',
            'event_date'    => 'required|date|date_format:Y-m-d|after_or_equal:today',
            'start_time'    => 'required|',
            'end_time'      => 'required|',
            'status'        => 'string|nullable',
        ];
    }
}