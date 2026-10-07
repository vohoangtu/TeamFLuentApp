<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $projectId = $this->route('project')?->id ?? $this->route('project');

        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', Rule::unique('projects')->ignore($projectId)],
            'description' => ['nullable', 'string', 'max:1500'],
            'status' => ['required', 'in:planning,in_progress,review,completed,on_hold'],
            'priority' => ['required', 'in:low,medium,high,urgent'],
            'progress' => ['required', 'integer', 'min:0', 'max:100'],
            'color' => ['nullable', 'string', 'max:100'],
            'start_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date'],
            'budget' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
