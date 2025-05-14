<?php

namespace App\Http\Requests\Task;

use App\Models\Status;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
        $rules = [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            // 'status_id'   => ['required', 'exists:statuses,id'],
            'priority'    => ['required', 'in:low,medium,high'],
        ];

        if ($this->user()->isAdmin()) {
            $rules['user_id'] = ['required','exists:users,id'];
        }

        return $rules;
    }
}
