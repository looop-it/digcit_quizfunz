<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Http\Requests\StoreParticipantInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\ValidateSchoolCode;

class ParticipantController extends Controller
{
    public function participate()
    {
        $user = Auth::user();

        $schools = School::approved()->ofType('secondary')->select(['name as text', 'id'])->orderBy('id', 'asc')->get();

        if ($participant = $user->participant) {
            return view('home.participation.validation', compact('schools', 'participant'));
        }

        return view('home.participation.create', compact('schools'));
    }

    public function store(StoreParticipantInfo $request)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();

            $user->participant()->create([
                'name' => $request->name,
                'school_id' => $request->school_id,
                'grade' => $request->grade,
                'class' => $request->class,
            ]);

            DB::commit();

            return $this->redirectTo();
        } catch (\Exception $exception) {
            DB::rollback();

            \Log::error('Failed to create participant record. Error'.$exception->getMessage());
        }

        return redirect()->back()->withInput()->withErrors(['發生錯誤，請重試。']);
    }

    public function validateCode(ValidateSchoolCode $request)
    {
        return $this->redirectTo();
    }

    private function redirectTo()
    {
        $user = Auth::user();

        Cache::forever("user:{$user->id}:participate", str_random(32));

        return redirect()->route('competition.start');
    }
}
