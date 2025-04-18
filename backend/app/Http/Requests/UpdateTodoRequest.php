<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTodoRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:255',
            'completed' => 'sometimes|required|boolean',
            'priority' => 'sometimes|required|integer|between:1,3',
        ];
    }

    public function messages() {
        return [
            'title.required' => 'Title is required.',
            'title.string' => 'Title must be a string.',
            'title.max' => 'Title cannot be longer than 255 characters.',
            'completed.required' => 'Completed status is required.',
            'completed.boolean' => 'Completed status must be a boolean.',
            'priority.required' => 'Priority is required.',
            'priority.integer' => 'Priority must be an integer.',
            'priority.between' => 'Priority must be between 1 and 3.',
        ];
    }
}
