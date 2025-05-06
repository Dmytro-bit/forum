<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreThreadRequest extends FormRequest
{
    /**
     * Allow any authenticated user to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for creating a thread.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:150',
            'body'  => 'required|string',
        ];
    }
}
