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
        // dd(request()->all());
        return [
            'guest_id'            => 'required',
            'province'            => 'required',
            'district'            => 'required',
            'ward'                => 'required',
            'address'             => 'required',
            'parcel_type'         => 'required',
            'weight'              => 'required',
            'real_weight'         => 'required',
            'type_transfer'       => 'required',
            'time_input'          => 'required',
            'services'            => 'required',
            'price'               => 'required',
            'vat'                 => 'required',
            'price_vat'           => 'required',
            'support_gas_rate'    => 'required',
            'support_gas'         => 'required',
            'support_remote_rate' => 'required',
            'support_remote'      => 'required',
            'total'               => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => "Bắt buộc nhập",
        ];
    }
}
