<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'name' => 'required',
            'package_id' => 'required',
            'email' => 'required|unique:customers,email,' . $id,
            'phone' => 'required|unique:customers,phone,' . $id,
        ];
    }

    /**
     * persist form data
     */
    public function persist(): array
    {
        return $data = [
            'name' => $this->name,
            'package_id' => $this->package_id,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'status' => 1,
        ];
    }
}
