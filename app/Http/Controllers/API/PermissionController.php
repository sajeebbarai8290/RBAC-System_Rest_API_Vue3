<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-permission', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-permission', ['only' => ['store']]);
        $this->middleware('permission:edit-permission', ['only' => ['update']]);
        $this->middleware('permission:delete-permission', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $permissions = Permission::all();
        return response()->json($permissions);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:permissions',
        ]);

        $permission = Permission::create(['name' => $request->name, 'guard_name' => 'api']);

        return response()->json($permission, 201);
    }

    public function show(Permission $permission)
    {
        return response()->json($permission);
    }

    public function update(Request $request, Permission $permission)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name, 'guard_name' => 'api']);

        return response()->json(['message' => 'Permission deleted successfully','data'=>$permission],200);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json(null, 204);
    }
}
