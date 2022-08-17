<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    public function login()
    {
        if (auth()->guard('admin')->user()) {
            return redirect()->route('admin.home');
        }
        return Inertia::render('Dashboard/Admin/Auth/Login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function loginPost(Request $request)
    {

        $credentials = $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);


//        if (Auth::guard('admin')->attempt($request->only(['email', 'password']))) {
//            return Inertia::location(route('admin.home'));
//
//        }

//        dd($credentials);

        if (Auth::guard('admin')->attempt($credentials, $remember = true)) {
            $request->session()->regenerate();

            return Inertia::location(route('admin.home'));
        }

        return back()->withErrors(['email' => __("trans.wrong data provided !")]);

    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return Inertia::location(route('admin.login'));
    }

}
