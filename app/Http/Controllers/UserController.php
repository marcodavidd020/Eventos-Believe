<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\CountPage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $countPages = CountPage::first();

        CountPage::where('id', $countPages->id)
            ->update([
                'users' => $countPages->users + 1
            ]);

        $countPages = CountPage::first();

        $users = User::all();
        $roles = Role::all();
        return view('admin.user.index', compact('users', 'roles', 'countPages'));
    }

    public function store(Request $request)
    {
        // Reglas de validación
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|numeric|digits_between:7,15',
            'genero' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'rol_id' => 'required|exists:roles,id',
        ]);

        User::create([
            'name' => $request->nombre,
            'last_name' => $request->apellido,
            'phone' => $request->telefono,
            'gender' => $request->genero,
            'role_id' => $request->rol_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente');
    }

    public function update(Request $request, User $user)
    {
        // Reglas de validación
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|numeric|digits_between:7,15',
            'genero' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'rol_id' => 'required|exists:roles,id',
        ]);

        // Preparación de datos para actualización
        $data = [
            'name' => $request->nombre,
            'last_name' => $request->apellido,
            'phone' => $request->telefono,
            'gender' => $request->genero,
            'role_id' => $request->rol_id,
            'email' => $request->email,
        ];

        // Verificar y actualizar la contraseña si se proporcionó una nueva
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);
        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente');
    }

    public function updateStyle(Request $request)
    {
        $request->validate([
            'style' => 'required|in:young,adult,senior',
        ]);

        $user = Auth::user();
        $user->style = $request->style;
        $user->save();

        return redirect()->back()->with('success', 'Estilo actualizado correctamente.');
    }
}
