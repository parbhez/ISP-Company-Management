<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
            'account_number' => 'required',
            'type' => 'required',
            'balance' => 'required',
        ];
    }

     /**
     * persist form data
     */
    public function persist(): array
    {
        return $data = [
            'name' => $this->name,
            'account_number' => $this->account_number,
            'type' => $this->type,
            'description' => $this->description,
            'balance' => $this->balance,
            'status' => 1,
        ];
    }
}
