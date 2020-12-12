<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FALaravel\Google2FA;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $google2fa = new Google2FA($request);

        $request->request->add([
            'google2fa_secret' => $google2fa->generateSecretKey()
        ]);

        $request->session()->flash('registration_data', $request->all());

        $url = $google2fa->getQRCodeUrl(
            config('app.name'),
            $request->email,
            $request->google2fa_secret
        );

        return view('google2fa.register', [
            'url' => $url,
            'secret' => $request->google2fa_secret
        ]);
    }

    public function store(Request $request)
    {
        $request->merge(session('registration_data'));

        Auth::login($user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'google2fa_secret' => $request->google2fa_secret
        ]));

        event(new Registered($user));

        return redirect(RouteServiceProvider::HOME);
    }
}
