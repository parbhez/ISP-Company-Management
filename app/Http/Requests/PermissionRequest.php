<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
            'group_name' => 'required|min:2',
            'name' => 'required|min:2|unique:permissions,name,' . $id,
        ];
    }

     /**
     * persist form data
     */
    public function persist(): array
    {
        return $data = [
            'name' => $this->name,
            'group_name' => $this->group_name,
            'guard_name' => 'web',
        ];
    }
}
