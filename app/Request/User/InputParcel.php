<?php

namespace App\Request\User;

use Illuminate\Foundation\Http\FormRequest;

class InputParcel extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'province'         => 'required',
            'district'         => 'required',
            'ward'             => 'required',
            'address'          => 'required',
            'type'             => 'required',
            'weight'           => 'required',
            'real_weight'      => 'required',
            'type_transfer'    => 'required',
            'price'            => 'required',
            'vat'              => 'required',
            'price_vat'        => 'required',
            'support_gas_rate' => 'required',
            'support_gas'      => 'required',
            'total'            => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required'          => "Bắt buộc nhập",
            'province.required' => "Bắt buộc chọn",
            'district.required' => "Bắt buộc chọn",
            'ward.required'     => "Bắt buộc chọn",
            'bill_code.unique'  => 'Mã hóa đơn này đã được dùng',
        ];
    }
}
