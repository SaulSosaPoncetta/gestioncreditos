<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Administrador;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        if (Auth::guard('persona')->check()) {
            return redirect()->route('panel.index');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'correo_electronico' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        if (Auth::guard('persona')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('panel.index'));
        }

        return back()
            ->withErrors(['correo_electronico' => 'Credenciales incorrectas.'])
            ->onlyInput('correo_electronico');
    }

    public function logout(Request $request)
    {
        $guard = Auth::guard('admin')->check() ? 'admin' : 'persona';

        Auth::guard($guard)->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['correo_electronico' => ['required', 'email']]);

        $email = $request->correo_electronico;
        $esAdmin = Administrador::where('correo_electronico', $email)->exists();
        $esPersona = Persona::where('correo_electronico', $email)->exists();

        if (!$esAdmin && !$esPersona) {
            return back()->withErrors(['correo_electronico' => 'El correo no está registrado.']);
        }

        $broker = $esAdmin ? 'administradores' : 'personas';

        $status = Password::broker($broker)->sendResetLink([
            'correo_electronico' => $email,
        ]);

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Te enviamos un correo con las instrucciones.')
            : back()->withErrors(['correo_electronico' => __($status)]);
    }

    public function showResetPasswordForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'correo_electronico' => $request->correo_electronico,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'correo_electronico' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $email = $request->correo_electronico;
        $esAdmin = Administrador::where('correo_electronico', $email)->exists();
        $broker = $esAdmin ? 'administradores' : 'personas';

        $status = Password::broker($broker)->reset(
            $request->only('correo_electronico', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['contrasenia' => $password])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Contraseña actualizada correctamente.')
            : back()->withErrors(['correo_electronico' => __($status)]);
    }
}