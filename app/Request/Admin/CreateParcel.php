<?php

namespace App\Request\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateParcel extends FormRequest
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
        $rules = [
            'guest_id'         => 'required',
            'province'         => 'required',
            'district'         => 'required',
            'ward'             => 'required',
            'address'          => 'required',
            'type'             => 'required',
            'weight'           => 'required',
            'real_weight'      => 'required',
            'type_transfer'    => 'required',
            'time_receive'     => 'required',
            'price'            => 'required',
            'vat'              => 'required',
            'price_vat'        => 'required',
            'support_gas_rate' => 'required',
            'support_gas'      => 'required',
            'total'            => 'required',
        ];
        if (!empty($request->bill_code)) {
            $rules['bill_code'] = 'unique:parcels,bill_code,'.$this->id;
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'required' => "Bắt buộc nhập",
            'bill_code.unique' => 'Mã hóa đơn không được trùng',
        ];
    }
}
