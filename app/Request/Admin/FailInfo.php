<?php

namespace App\Request\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FailInfo extends FormRequest
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
            'reason' => 'required',
            'fail_time' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'reason' => trans('label.reason'),
            'fail_time' => trans('label.fail_time'),
        ];
    }

    public function messages()
    {
        return [
            'reason.required' => "Vui lòng chọn ':attribute'",
            'fail_time.required' => "Vui lòng nhập ':attribute'",
        ];
    }
}
