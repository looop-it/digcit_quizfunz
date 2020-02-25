<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\School;

class ValidController extends Controller
{
    public function validSchool(Request $request)
    {
        $value = $request->input('param');
        $name = $request->input('name');
        
        if ($name=='school') {
            $name='name';
        }

        if (School::where($name, $value)->first()) {
            $data['info']='已存在';

            $data['status']='n';

            return $data;
        } else {
            $data['info']='succsess';

            $data['status']='y';


            return $data;
        }
    }
}
