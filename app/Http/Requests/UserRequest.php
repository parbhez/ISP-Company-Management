<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $id = $this->request->get('id') ?? null;
        return [
            'name' => 'required|min:2',
            'email' => 'required|min:2|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
        ];
    }

    /**
     * persist form data
     */
    public function persist(): array
    {
        return $data = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ];
    }
}
