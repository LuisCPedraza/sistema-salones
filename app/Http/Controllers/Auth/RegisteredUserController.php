<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // ---- INICIO DE NUESTRA MODIFICACIÓN ----

        // 1. Buscamos el rol por defecto para los nuevos usuarios.
        $defaultRole = Role::where('name', 'profesor')->first();
        if (!$defaultRole) {
            // Opcional: Manejar el caso en que el rol no exista.
            // Por ahora, supondremos que siempre existe gracias a nuestro seeder.
            return back()->withErrors(['msg' => 'No se pudo asignar un rol por defecto.']);
        }

        // 2. Creamos el usuario, añadiendo el role_id.
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $defaultRole->id,
        ]);

        // ---- FIN DE NUESTRA MODIFICACIÓN ----

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
