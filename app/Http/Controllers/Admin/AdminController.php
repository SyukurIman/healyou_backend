<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public $data = [
        "parent" => "admin",
    ];
    public function home_admin(){
        $this->data['position'] = "home";
        return view("admin.dashboard", $this->data);
    }
    public function admin_login_view(){
        return view("admin.auth.login");
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        if (Auth::user()->is_admin == '1'){
            return redirect()->intended('/admin/home');
        }

        $this->destroy($request);

        // return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
