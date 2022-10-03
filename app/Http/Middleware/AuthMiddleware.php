<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next, string $type)
  {

    $user = auth()->check();
    if ($type === "in" && !$user) {
      return redirect("/auth/login")->with([
        "message" => "Anda belum login"
      ]);
    } else if ($type === "out" && $user) {
      return redirect("/");
    }

    return $next($request);
  }
}
