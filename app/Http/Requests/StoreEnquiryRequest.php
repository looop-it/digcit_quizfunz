<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnquiryRequest extends FormRequest
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
            'name' => 'required',
            'school_name' => 'required',
            'tel' => 'required|digits:8',
            'email' => 'required|email',
            'enquiry' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '請輸入姓名',
            'school_name.required' => '請輸入學校名稱',
            'tel.required' => '請輸入聯絡電話',
            'tel.digits' => '請輸入8位數字的電話號碼',
            'email.email' => '請輸入正確格式的電郵地址',
            'enquiry.required' => '請輸入查詢內容'
        ];
    }
}
