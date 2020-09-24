<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentImportLoginRequest;
use App\Imports\UserImport;
use App\Models\SchoolRegistration;
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
                $registration = SchoolRegistration::with('school')->where('email', $session['email'])->first();

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
        $import = new UserImport($request->school_id);
        $import->import($request->file);

        return response()->json([
            'status' => 'success',
            'total_count' => $import->getTotalCount(),
            'imported_count' => $import->getImportedCount(),
            'failed_count' => $import->getFailedCount()
        ], 200);
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
