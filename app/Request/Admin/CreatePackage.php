<?php

namespace App\Request\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreatePackage extends FormRequest
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
            'parcel' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'parcel' => trans('label.parcel'),
        ];
    }

    public function messages()
    {
        return [
            'parcel.required' => "Vui lòng chọn mã vận đơn",
        ];
    }
}
