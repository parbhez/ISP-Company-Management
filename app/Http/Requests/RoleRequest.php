<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'name' => 'required|min:2|unique:roles,name,' . $id,
        ];
    }

    /**
     * persist form data
     */
    public function persist(): array
    {
        return $data = [
            'guard_name' => 'web',
            'name' => $this->name,
        ];
    }
}
