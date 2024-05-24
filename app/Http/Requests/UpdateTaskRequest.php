<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
        $task = $this->route('task');
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|min:10',
            'assigned_user_id' => 'required|exists:users,id',
            'scheduledFinishDate' => 'required|date|before_or_equal:' . $task->plan->scheduledFinishDate,
            'slug' => 'unique'
        ];
    }
}
