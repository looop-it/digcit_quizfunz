<?php

namespace App\Http\Controllers;

use App\Facades\PaperManager;
use App\Models\School;
use App\Models\Season;
use App\Http\Requests\StoreParticipantInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\ValidateSchoolCode;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function choose()
    {
        $seasons = openSeasons();

        if ($seasons->isEmpty()) {
            return redirect()->route('competition.error')->with('message', '現時沒有開放的比賽，請密切留意最新消息。');
        }

        if ($seasons->count() === 1) {
            session(['competition_season_id' => $seasons->first()->id]);

            return redirect()->route('participant.participate');
        }

        return view('home.participation.choose', compact('seasons'));
    }

    public function selectSeason(Request $request)
    {
        $season = Season::open()->where('id', $request->input('season_id'))->first();

        if (!$season) {
            return redirect()->route('competition.choose')->withErrors(['請選擇目前開放的比賽。']);
        }

        session(['competition_season_id' => $season->id]);

        return redirect()->route('participant.participate');
    }

    public function participate(Request $request)
    {
        if (openSeasons()->count() > 1 && !session('competition_season_id')) {
            return redirect()->route('competition.choose');
        }

        $syncUserInfo = $request->session()->pull('supplementParticipantInfo');

        if ($syncUserInfo) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $schools = School::approved()->ofType('secondary')->select(['name as text', 'id'])->orderBy('id', 'asc')->get();

        if ($participant = $user->participant) {
            return view('home.participation.validation', compact('schools', 'participant'));
        }

        // return view('home.participation.create', compact('schools'));

        session([
            'supplementParticipantInfo' => true,
            'redirectUrl' => route('participant.participate')
        ]);

        return view('home.participation.missing_info');
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
        $paper = PaperManager::assignPaper($user);

        Cache::forever("user:{$user->id}:participate", str_random(32));

        return redirect()->route('competition.start');
    }
}
