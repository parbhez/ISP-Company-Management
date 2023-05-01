<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
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
            'name' => 'required|unique:packages,name,' . $id,
            'monthly_fee' => 'required',
        ];
    }

    /**
     * persist form data
     */
    public function persist(): array
    {
        return $data = [
            'name' => $this->name,
            'monthly_fee' => $this->monthly_fee,
            'description' => $this->description,
            'status' => 1,
        ];
    }
}
