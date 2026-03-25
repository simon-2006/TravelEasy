<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManageDashboard() ?? false;
    }

    /**
     * @return array<string, array<int, \Illuminate\Contracts\Validation\ValidationRule|string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('users', 'name')],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', Rule::in(User::ROLES)],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.unique' => 'Probeer een ander gebruiksnaam toe toevoegen.',
        ];
    }
}
