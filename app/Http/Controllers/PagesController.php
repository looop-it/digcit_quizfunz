<?php

namespace App\Http\Controllers;

use App\Models\Inquire;
use App\Repositories\GlobalRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    /**
     * Get company info for dashboard setting.
     */
    public function __construct(GlobalRepository $GlobalRepository)
    {
        parent::__construct();

        $this->GlobalRepository = $GlobalRepository;
    }

    /**
     * @param string $slug
     *
     * @return \Illuminate\Http\Response
     *                                   單頁面
     */
    public function index($slug = '')
    {
        if ($slug == '') {
            $page = $this->GlobalRepository->getpage_one();
        } else {
            $page = $this->GlobalRepository->getInfo_one($slug);
        }

        return view(
            'home.about',
            compact(
                'page',
                'slug'
            )
        );
    }

    public function enquiry(Request $request)
    {
        $reles = [
            'name' => 'required|max:255',
            'school_name' => 'required|max:255',
            // 'capacity' => 'required|max:255',
            'email' => 'email',
            'tel' => ['regex:/^[1][3|4|5|6|7|8]\d{9}$|^([2|3|4|5|6|7|8|9])\d{7}$|^[6]([8|6])\d{5}$/'],
            'enquiry' => 'required',
            'captcha' => 'required|captcha',
        ];

        $messages = [
            'required' => ':attribute 不能為空',
            'max' => ':attribute 長度不符合要求',
            'min' => ':attribute 長度不符合要求',
            'captcha' => ':attribute錯誤',
            'email' => ':attribute 格式錯誤',
        ];

        $folk = [
            'email' => '電郵',
            'tel' => '電話',
            // 'capacity'=>'身份',
            'captcha' => '驗證碼',
        ];

        $validator = Validator::make($request->all(), $reles, $messages, $folk);

        if ($validator->fails()) {
            $arr['state'] = 0;
            $arr['msg'] = $validator->errors()->first();
            echo json_encode($arr);
            exit();
        }

        $data = $request->all();
        $data['capacity'] = '其它';

        $bool = Inquire::create($data);

        if ($bool == true) {
            $arr['state'] = 1;
            $arr['msg'] = '多謝您的意見或查詢，我們會盡快回覆。';
            echo json_encode($arr);
            exit();
        } else {
            $arr['state'] = 0;
            $arr['msg'] = '發生錯誤，請稍後再試。';
            echo json_encode($arr);
            exit();
        }
    }
}
