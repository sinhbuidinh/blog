<?php

namespace App\Request\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateForward extends FormRequest
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
            'parcel'       => 'required',
            'province'     => 'required',
            'district'     => 'required',
            'ward'         => 'required',
            'address'      => 'required',
            'forward_name' => 'required',
            'forward_tel'  => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'parcel'       => trans('label.parcel'),
            'province'     => trans('label.provincial'),
            'district'     => trans('label.district'),
            'ward'         => trans('label.ward'),
            'address'      => trans('label.address'),
            'forward_name' => trans('label.forward_name'),
            'forward_tel'  => trans('label.forward_tel'),
        ];
    }

    public function messages()
    {
        return [
            'required' => "Vui lòng chọn :attribute",
        ];
    }
}
