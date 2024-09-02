<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-user|create-user', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-user', ['only' => ['store']]);
        $this->middleware('permission:edit-user', ['only' => ['update']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    }
    
    
    public function index()
    {
        return User::with('roles', 'permissions')->get();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'roles' => 'sometimes|array',
            'roles.*' => 'exists:roles,name', // Ensure roles exist
        ]);
    
        // Create user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);
    
        // Assign roles if provided
        if (isset($validatedData['roles'])) {
            $user->assignRole($validatedData['roles']);
        }
    
        return response()->json($user->load('roles'), 201);
    }

    public function show(User $user)
    {
        return $user->load('roles', 'permissions');
    }

    public function update(Request $request, User $user)
    {
        // Check Only Super Admin can update his own Profile
        if ($user->hasRole('Super Admin')){
            if($user->id != auth()->user()->id){
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }
        
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:8',
            'roles' => 'sometimes|array',
            'roles.*' => 'exists:roles,name', // Validate role names
        ]);
    
        if (isset($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }
    
        // Update user data
        $user->update($validatedData);
    
        // Sync roles
        if (isset($validatedData['roles'])) {
            $user->syncRoles($validatedData['roles']);
        }
    
        return response()->json($user->load('roles'));
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('Super Admin') || $user->id == auth()->user()->id) {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }
    
        // Remove all roles from the user
        $user->syncRoles([]);
    
        // Delete the user
        $user->delete();
    }

    
}
