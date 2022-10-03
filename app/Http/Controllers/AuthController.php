<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function v_login()
    {
      return view("auth.login");
    }

    public function post_login (Request $request)
    {
      $credential = $request->only(["username", "password"]);

      if(!Auth::attempt($credential)) {
        return redirect("/auth/login")->withErrors([
          "message" => "Login gagal! pastikan username/password benar"
        ])
        ->withInput();
      }

      return redirect("/");
    }
}
