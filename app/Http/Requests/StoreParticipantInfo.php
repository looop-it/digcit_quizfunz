<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;
use App\Models\School;
use App\Rules\SpecialChars;

class StoreParticipantInfo extends FormRequest
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
            'name' => ['required', new SpecialChars()],
            'school_id' => 'required|exists:membership.schools,id',
            'grade' => 'required',
            'class' => 'required',
            // 'code' => 'required|exists:schools,code',
            // 'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('participate')]
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
            'name.required' => '請輸入真實姓名',
            'school_id.required' => '請選擇學校',
            'school_id.exists' => '學校不存在',
            'grade.required' => '請輸入年級',
            'class.required' => '請輸入班別',
            // 'code.required' => '請輸入學校認證碼',
            // 'code.exists' => '學校認證碼不正確',
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

    //         if ($school->code != $this->request->get('code')) {
    //             $validator->errors()->add('code', '學校認證碼不正確');
    //         }
    //     });
    // }
}
