<?php

namespace App\Http\Requests;

use App\Admin\Models\School;
use Illuminate\Foundation\Http\FormRequest;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

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
        $rules = [
            'captcha' => 'required|captcha',
            // 'school_id' => 'required|exists:schools,id',
            // 'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('participate')]
        ];

        if ($this->seasonRequiresSchoolCode()) {
            $rules['code'] = 'required|exists:schools,code';
        }

        return $rules;
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
            'code.exists' => '學校認證碼不正確',
            'captcha.captcha' => '驗證碼檢驗未通過',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     */
    public function withValidator($validator)
    {
        if (!$this->seasonRequiresSchoolCode()) {
            return;
        }

        $validator->after(function ($validator) {
            $school = School::find($this->request->get('school_id'));

            if (!$school) {
                $validator->errors()->add('school_id', '學校不存在');

                return;
            }

            // ID 44 = 齊心基金會 for testing.
            if ($school->id != 44) {
                if (!$school->isApproved()) {
                    $validator->errors()->add('approved', '學校資料未核實，請聯絡相關老師。');
                } else {
                    if (null == $school->code || env('SCHOOL_CODE_PREFIX').$school->code != $this->request->get('code')) {
                        $validator->errors()->add('code', '學校認證碼不正確');
                    }
                }
            }
        });
    }

    /**
     * Current open season is a school competition.
     */
    private function seasonRequiresSchoolCode()
    {
        $season = season();

        return $season && $season->requiresSchoolCode();
    }
}
