<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        if ($user->esAdministrador()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->esPropietario()) {
            return redirect()->route('propietario.dashboard');
        }

        return redirect()->route('home');
    }
}
