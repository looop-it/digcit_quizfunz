<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;
use App\Admin\Models\School;

class ValidateSchoolCode extends FormRequest
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
            // 'school_id' => 'required|exists:schools,id',
            // 'code' => 'required|exists:schools,code',
            'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('participate')]
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'school_id.required' => '請選擇學校',
            'school_id.exists' => '學校不存在',
            'code.required' => '請輸入學校認證碼',
            'code.exists' => '學校認證碼不正確'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     */
    // public function withValidator($validator)
    // {
    //     $validator->after(function ($validator) {
    //         $school = School::find($this->request->get('school_id'));

    //         // ID 44 = 齊心基金會 for testing.
    //         if ($school->id != 44) {
    //             if (!$school->isApproved()) {
    //                 $validator->errors()->add('approved', '學校資料未核實，請聯絡相關老師。');
    //             } else {
    //                 // if ($school->code != $this->request->get('code')) {
    //                 //     $validator->errors()->add('code', '學校認證碼不正確');
    //                 // }
    //             }
    //         }
    //     });
    // }
}
