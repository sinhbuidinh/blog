<?php

namespace App\Request\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateGuest extends FormRequest
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
            'representative' => 'required',
            'represent_tel'  => 'required',
            'company_name'   => 'required',
            'tel'            => 'required',
            'tax_code'       => 'required',
            'tax_address'    => 'required',
            'province'       => 'required',
            'district'       => 'required',
            'ward'           => 'required',
            'address'        => 'required',
        ];
        if (!empty($this->account_apply) ) {
            $rules['account_apply'] = Rule::unique('guests', 'account_apply')->where(function ($query) {
                return $query->whereNull('deleted_at');
            })->ignore($this->id);
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'representative' => trans('label.representative'),
            'represent_tel'  => trans('label.represent_tel'),
            'company_name'   => trans('label.company_name'),
            'tel'            => trans('label.tel'),
            'tax_code'       => trans('label.tax_code'),
            'tax_address'    => trans('label.tax_address'),
            'province'       => trans('label.provincial'),
            'district'       => trans('label.district'),
            'ward'           => trans('label.ward'),
            'address'        => trans('label.address'),
            'account_apply'  => trans('label.account_apply'),
        ];
    }

    public function messages()
    {
        return [
            'required' => "Bắt buộc nhập",
            'account_apply.unique' => "Tài khoản đã đc sử dụng",
        ];
    }
}
