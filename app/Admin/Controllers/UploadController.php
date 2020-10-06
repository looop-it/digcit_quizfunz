<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image;

class UploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        $field = 'upload';
        $user = Admin::user();

        $upload_success = false;

        $upload_success_result = [
            'url' => '',
        ];

        $upload_fail_result = [
            'error' => [
                'message' => '',
            ],
        ];

        $validator = Validator::make($request->all(), [
            $field => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($validator->fails()) {
            $upload_fail_result['error']['message'] = $validator->errors()->first('upload');
        } else {
            $image = $request->file($field);
            $image_name = $user->id.'_'.Carbon::now()->format('Ymd_His').'_'.Str::random(6);
            $dir = 'articles/'.date('Ymd', time()).'/';
            $extension = $image->getClientOriginalExtension();

            $intervention = null;
            // Keep gif, other convert to jpg
            if ($extension != 'gif') {
                $extension = 'jpg';
                $intervention = Image::make($image)->resize(1000, null, function (Constraint $constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode('jpg', 85);

                if (Storage::put($dir.$image_name.'.'.$extension, (string) $intervention)) {
                    $upload_success = true;
                    // $upload_result['url'] = env('CDN_URL') . '/' . $dir . $image_name . '.' . $extension;
                    $upload_success_result['url'] = config('app.cdn_url').'/'.$dir.$image_name.'.'.$extension;
                } else {
                    $upload_fail_result['error']['message'] = 'Server store error!';
                }
            } else {
                // $url = $image->storeAs($dir, $image_name.'.'.$extension, 'oss');
                if (Storage::putFileAs($dir, $image, $image_name.'.'.$extension)) {
                    $upload_success = true;
                    $upload_success_result['url'] = config('app.cdn_url').'/'.$dir.$image_name.'.'.$extension;
                } else {
                    $upload_fail_result['error']['message'] = 'Server store error!';
                }
            }
        }

        return $upload_success ? $upload_success_result : $upload_fail_result;
    }
}
