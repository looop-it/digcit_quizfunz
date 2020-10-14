<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolRegistrationRequest extends FormRequest
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
            'school_id' => 'required|exists:schools,id',
            'address' => 'required',
            'name' => 'required',
            'subject' => 'required',
            'email' => 'required|email|unique:school_registrations',
            'phone' => 'required|digits:8'
        ];
    }

    public function messages()
    {
        return [
            'school_id.required' => '請選擇學校',
            'school_id.exists' => '學校不存在，請聯絡我們',
            'address.required' => '請輸入學校地址',
            'name.required' => '請輸入姓名',
            'subject.required' => '請輸入負責科目',
            'email.required' => '請輸入聯絡電郵',
            'email.email' => '請輸入正確格式的電郵地址',
            'email.unique' => '此電郵地址已登記',
            'phone.required' => '請輸入聯絡電話',
            'phone.digits' => '請輸入8位數字電話',
        ];
    }
}
