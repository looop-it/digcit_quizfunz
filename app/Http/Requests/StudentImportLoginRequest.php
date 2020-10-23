<?php

namespace App\Http\Requests;

use App\Models\SchoolRegistration;
use Illuminate\Foundation\Http\FormRequest;

class StudentImportLoginRequest extends FormRequest
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
            'email' => 'required|exists:school_registrations,email',
            'token' => 'required|exists:schools,code'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => '請輸入電郵地址',
            'email.exists' => '電郵地址未登記',
            'token.required' => '請輸入驗證碼',
            'token.exists' => '驗證碼不正確'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $registration = SchoolRegistration::where('email', $this->email)->first();

            if (!$registration->verified) {
                $validator->errors()->add('email', '電郵地址未驗證，請檢查郵箱');
            }

            if (!$registration->approved) {
                $validator->errors()->add('email', '登記未完成審核');
            }

            if ($registration->school->code != $this->token) {
                $validator->errors()->add('token', '驗證碼和電郵地址不匹配');
            }
        });
    }
}
