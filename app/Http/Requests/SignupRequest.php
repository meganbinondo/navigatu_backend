<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
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
        if (request()->routeIs('signup.signup')) {
            return [
                'name'      => 'required|string|max:255',
                'email'     => 'required|string|email|unique:App\Models\User,email|max:255',
                'password'  => 'required|min:8|string|confirmed',
                'phone'  => 'nullable|string|max:255',
                'organization' => 'nullable|string|max:255',
            ];
        }
    }
}