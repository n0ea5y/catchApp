<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Jenssegers\Agent\Agent;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {

        $agent = new Agent();

        // デバイスの判定
        $isMobile = $agent->isMobile();
        $isDesktop = $agent->isDesktop();

        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
            'isMobile' => $isMobile,
            'isDesktop' => $isDesktop,
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
                    // セッションを再生成
        $request->session()->regenerate();
        $request->session()->regenerate();

        // デバイスの判定
        $agent = new Agent();
        $isMobile = $agent->isMobile();

        // return redirect()->route('dashboard');

                // デバイスに応じてリダイレクト先を決定
        if ($isMobile) {
            return redirect()->route('sp.dashboard');
        } else {
            return redirect()->route('dashboard');
        }

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
