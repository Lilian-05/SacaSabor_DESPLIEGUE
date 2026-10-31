<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $login = $credentials['login'];
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        if (Auth::attempt([$field => $login, 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirectSegunRol(Auth::user());
        }

        return back()->withErrors([
            'login' => 'El correo/usuario o la contraseña no coinciden.',
        ])->onlyInput('login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users', 'required_without:name'],
            'name' => ['nullable', 'string', 'max:255', 'unique:users', 'regex:/^[\w\s\.\-áéíóúÁÉÍÓÚñÑ]+$/', 'required_without:email'],
            'password' => ['required', 'string', 'min:6'],
            'rol' => ['required', 'in:cliente,propietario'],
        ]);

        $email = $data['email'] ?? null;
        $name = $data['name'] ?? null;
        if (! $name) {
            $name = $this->nombreDesdeEmail($email);
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $data['password'],
            'rol' => $data['rol'],
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    protected function nombreDesdeEmail(string $email): string
    {
        $base = preg_replace('/[^A-Za-z0-9._\- ]/', '', explode('@', $email)[0]);
        $base = trim($base) !== '' ? trim($base) : 'usuario';

        $name = $base;
        $i = 1;
        while (User::where('name', $name)->exists()) {
            $name = $base . $i;
            $i++;
        }

        return $name;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    protected function redirectSegunRol($user)
    {
        if ($user->esAdministrador()) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->esPropietario()) {
            return redirect()->route('propietario.dashboard');
        }
        return redirect()->route('home');
    }
}
