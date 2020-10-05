<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnquiryRequest;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnquiryController extends Controller
{
    public function form()
    {
        return view('enquiry');
    }

    public function store(StoreEnquiryRequest $request)
    {
        $data = $request->all();

        $data['capacity'] = '其他';

        try {
            DB::beginTransaction();

            $enquiry = Enquiry::create($data);

            DB::commit();

            return redirect()->route('enquiry.submitted');
        } catch (\Exception $exception) {
            \Log::error("Failed to store enquiry. Error: {$exception->getMessage()}");

            return back()->withInput()->withErrors(['other' => '發生未知錯誤，請稍後重試']);
        }
    }

    public function submitted(Request $request)
    {
        return view('enquiry_submitted');
    }
}
