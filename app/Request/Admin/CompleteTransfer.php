<?php

namespace App\Request\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CompleteTransfer extends FormRequest
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
            'complete_receiver' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'complete_receiver' => trans('label.complete_receiver'),
        ];
    }

    public function messages()
    {
        return [
            'required' => "Vui lòng nhập ':attribute'",
        ];
    }
}
