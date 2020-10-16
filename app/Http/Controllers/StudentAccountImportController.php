<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentImportLoginRequest;
use App\Imports\UserImport;
use App\Jobs\ImportStudentList;
use App\Models\SchoolRegistration;
use App\Models\StudentListImportLog;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StudentAccountImportController extends Controller
{
    public function index(Request $request)
    {
        // Login
        if (session()->has($this->getSessionName())) {
            $session = $this->decryptSession();

            if ($session['email']) {
                $registration = SchoolRegistration::with(['school', 'importLogs' => function ($query) {
                    $query->orderBy('id', 'desc');
                }])->where('email', $session['email'])->first();

                return view('school.import.form', compact('registration'));
            }
        }

        $data = null;

        if ($request->has('token')) {
            $data = json_decode(decrypt($request->token), true);
        }

        return view('school.import.index', compact('data'));
    }

    /**
     * Undocumented function
     *
     * @param StudentImportLoginRequest $request
     * @return void
     */
    public function login(StudentImportLoginRequest $request)
    {
        $request->session()->regenerate();

        session([
            $this->getSessionName() => $this->encryptSession($request->email)
        ]);

        return redirect()->route('student_account_import.index');
    }

    public function import(Request $request)
    {
        return view('school.import.import');
    }

    public function store(Request $request)
    {
        try {
            $file = $request->file('file')->store('student_import_list');

            $registration = SchoolRegistration::find($request->school_registration_id);

            if ($registration) {
                StudentListImportLog::create([
                    'school_registration_id' => $registration->id,
                    'file_name' => $file
                ]);
    
                dispatch(new ImportStudentList($registration));
    
                return response()->json([
                    'status' => 'success',
                    'import_status' => 'processing'
                ], 200);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'failed',
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    private function getSessionName()
    {
        return 'student_import_login_' . sha1(static::class);
    }

    private function encryptSession(string $email)
    {
        return encrypt(json_encode([
            'email' => $email,
            'hash' => sha1(static::class)
        ]));
    }

    private function decryptSession()
    {
        return json_decode(decrypt(session($this->getSessionName())), true);
    }

    public function logout(Request $request)
    {
        $request->session()->forget($this->getSessionName());

        return redirect()->route('student_account_import.index');
    }
}
