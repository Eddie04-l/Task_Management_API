<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        $statuses = ['pending','in-progress','completed'];

        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => ['nullable', Rule::in($statuses)],
        ];
    }
}
