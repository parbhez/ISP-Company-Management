<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillRequest extends FormRequest
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
            'customer_id' => 'required',
            'month' => 'required',
            'customer_id' => 'required',
            'amount' => 'required|',
            'year' => 'required',
        ];
    }

     /**
     * persist form data
     */
    public function persist(): array
    {
        return $data = [
            'customer_id' => $this->customer_id,
            'month' => $this->month,
            'year' => $this->year,
            'amount' => $this->amount,
            'status' => $this->status,
        ];
    }
}
