<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'kelompok_id' => 'required',
            'description' => 'required|string|min:10|max:255',
            'waktu' => 'required|after:now',
            'ruangan_id' => 'required|exists:ruangans,id',
            'status' => 'nullable',
        ];
    }
}
