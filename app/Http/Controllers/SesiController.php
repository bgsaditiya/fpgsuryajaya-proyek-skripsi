<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use PhpParser\Node\Stmt\Echo_;

class SesiController extends Controller
{
    //
    function index()
    {
        return view('login.index');
    }

    function login(Request $request)
    {
        $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);

        $infologin = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($infologin)) {
            return redirect()->intended('/data');
        } else {
            // return redirect('')->withErrors('Username dan Password yang dimasukkan tidak sesuai.');
            return redirect()->back()->withErrors('Username atau Password yang dimasukkan salah!');
        }

        // return back()->withErrors([
        //     'username' => 'Email yang dimasukkan salah',
        //     'password' => 'Password wajib diisi!'
        // ]);
    }

    function logout()
    {
        Auth::logout();
        // request()->session()->invalidate();
        // request()->session()->regenerateToken();
        return redirect('/');
    }
}