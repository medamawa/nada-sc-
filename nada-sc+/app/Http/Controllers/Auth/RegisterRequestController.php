<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccessKey;

class RegisterRequestController extends Controller
{
    public function index()
    {
        return view('auth.registerRequest', ['msg' => 'Fill in the blanks']);
    }

    public function post(Request $request, AccessKey $accessKey)
    {
        $request->validate([
            'student_code' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // 片方ずつしか判定できないので修正する
        if (!$accessKey->codeIsOk($request->code)) {
            return view('auth.registerRequest', ['msg' => 'invalid code']);
        }

        if (!$accessKey->passIsOk($request->code, $request->pass)) {
            return view('auth.registerRequest', ['msg' => 'invalid pass']);
        }

        $data = $accessKey->getData($request->student_code);

        return view('auth.register', $data);
    }
}
