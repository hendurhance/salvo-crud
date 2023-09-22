<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Store a new user role.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'role' => ['required', 'string', 'max:255', 'unique:roles,name'],
        ]);

        // If user has permission to create role
        if (!auth()->user()->can('create role')) {
            abort(403);
        }

        Role::create([
            'name' => $request->role,
            'guard_name' => 'web',
        ]);

        return redirect()->route('profile.edit')
            ->with('status', 'role-created');
    }
}
