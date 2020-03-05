<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Jobs\Registration\SendSchoolRegistrationVerifyEmail;
use Illuminate\Support\Facades\DB;
use App\Jobs\Registration\SendSchoolRegistrationConfirmEmail;

/*
  学校控制器
*/

class SchoolController extends Controller
{
    /**
     * Get company info for dashboard setting.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *                                                                  學校註冊報的名顯示
     */
    public function create()
    {
        return view(
            'home.register'
        );
    }

    /**
     * @param Request $request
     *                         學校註冊報的名
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:schools|max:255|min:2',
            'email' => 'email|unique:schools',
            'contact' => 'required|max:20|min:2',
            'teaching_subject' => 'required|max:50|min:2',
            //'fax' => ['regex:/^((\+?[0-9]{2,4}\-[0-9]{3,4}\-)|([0-9]{3,4}\-))?([0-9]{7,8})(\-[0-9]+)?$/'],
            'students' => ['regex:/^[0-9]*$/'],
            //'school' => ['regex:/^[a-zA-Z][\w]{3,14}$|^[\x{4e00}-\x{9fa5}a-z-A-Z_]{1}([\x{4e0}-\x{9fa5}]|[\x{4e00}-\x{9fa5}a-z-A-Z\d_]){3,150}$/u '],
            'phone' => ['regex:/^[1][3|4|5|6|7|8]\d{9}$|^([2|3|4|5|6|7|8|9])\d{7}$|^[6]([8|6])\d{5}$/'],
            'expected_participants' => ['regex:/^[0-9]*$/'],
        ];

        $messages = [
            'required' => ':attribute 不能為空',
            'max' => ':attribute 長度不符合要求',
            'min' => ':attribute 長度不符合要求',
            'email' => ':attribute 格式錯誤',
        ];

        $folk = [
            'email' => '電郵',
            'name' => '學校名稱',
            'contact' => '主要聯絡人姓名',
            'students' => '全校學生人數',
            'expected_participants' => '預計參賽學生人數',
            'phone' => '聯絡電話',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $folk);

        if ($validator->fails()) {
            $arr['state'] = 0;
            $arr['msg'] = $validator->errors()->first();
            echo json_encode($arr);
            exit();
        }
        //   $password=md5($password);
        $data = $request->all();

        $data['verification_token'] = str_random(64);

        $school = School::create($data);

        if ($school) {
            // Dispatch job to send email for school registration.
            dispatch(new SendSchoolRegistrationVerifyEmail($school));

            $arr['state'] = 1;
            $arr['msg'] = '多謝貴校支持「歷史在線」挑戰賽，您的申請經已收悉。';
            $arr['msg'] .= '<br>我們將以電郵確認參賽資格。麻煩請檢查負責老師1的電子郵箱 （包括收件匣、垃圾郵箱及所有資料夾），並於48小時內按啟動連結以完成啟動程序。';
            $arr['msg'] .= sprintf("<br> <br> 如有任何查詢，請<a href=\"%s\" target='_blank'>聯絡我們</a>", route('page.detail', ['slug' => '聯絡我們']));

            echo json_encode($arr);
            exit();
        } else {
            $arr['state'] = 1;
            $arr['msg'] = '發生錯誤，請稍後再試。';
            echo json_encode($arr);
            exit();
        }
    }

    /**
     * @param Request $request
     * @param $token
     *
     * @return \Illuminate\Http\RedirectResponse
     *                                           學校驗證
     */
    public function verify(Request $request)
    {
        $msg = array('title' => '錯誤', 'msg' => '驗證碼錯誤', 'status' => 0);

        if (!$request->token) {
            return redirect('/user/msg')->with($msg);
        }

        $school = School::where([
            ['verified', false],
            ['verification_token', $request->token],
        ])->first();

        if (!$school) {
            return redirect('/user/msg')->with($msg);
        }

        DB::beginTransaction();

        try {
            $school->update([
                'verified' => true,
                'verified_at' => now(),
            ]);

            DB::commit();

            dispatch(new SendSchoolRegistrationConfirmEmail($school));

            $msg = array('title' => '成功', 'msg' => '驗證成功', 'status' => 1, 'url' => '/');

            return redirect()->route('school.message')->with($msg);
        } catch (\Exception $exception) {
            DB::rollback();

            \Log::error("Failed to update school verification status. Error: {$exception->getMessage()}");
        }

        return redirect('/user/msg')->with($msg);
    }

    /**
     * 學校註冊成功提示.
     */
    public function message()
    {
        return view('home.comm.schoolMsg');
    }
}
