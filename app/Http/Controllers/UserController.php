<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;  // On suppose que tu as un modèle Role
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::all(); // Liste de tous les rôles
        $userRoles = $user->roles->pluck('id')->toArray(); // Roles actuels de l'utilisateur
        return view('users.edit', compact('user', 'roles', 'userRoles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'roles' => 'array', // tableau des IDs de rôles
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        // Synchroniser les rôles (attribuer / retirer)
        $user->roles()->sync($request->roles ?? []);

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé.');
    }
}
