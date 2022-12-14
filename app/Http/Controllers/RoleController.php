<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use App\Models\Role;
use App\Models\User;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::with('permissions')->limitPaginate();
        return $this->setStatusCode(200)
                    ->setMessage("Roles Fetch Successfully")
                    ->setResourceName('roles')
                    ->responseWithCollection($roles);
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('role.create')) {
            return $this->responseWithNotAllowed();
        }

        $this->validate($request, [
            'name' => 'required|min:4',
        ]);
        try {
            $role = Role::create(['name' => $request->name]);
            return $this->setStatusCode(200)
                        ->setMessage("Role Created Successfully")
                        ->setResourceName('role')
                        ->responseWithItem($role);
        } catch (RoleAlreadyExists $exception) {
            return $this->setStatusCode(400)
                        ->setMessage("Role Already Exists")
                        ->responseWithError();
        } catch (\Exception $exception) {
            return $this->setStatusCode(500)
                        ->setMessage($exception->getMessage())
                        ->responseWithError();
        }

    }

    public function show($id)
    {
        $role = Role::with('permissions')
                    ->find($id);
        return $this->setStatusCode(200)
                    ->setMessage("Role Fetch Successfully")
                    ->setResourceName('role')
                    ->responseWithCollection($role);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function permissions()
    {
        $permissions = Permission::limitPaginate();
        return $this->setStatusCode(200)
                    ->setMessage("Permission Fetch Successfully")
                    ->setResourceName('permissions')
                    ->responseWithCollection($permissions);
    }

    public function assignPermission(Request $request)
    {

        if (!auth()->user()->can('permission.assign')) {
            return $this->responseWithNotAllowed();
        }
        $this->validate($request, [
            'role'          => 'required',
            'permissions'   => 'required',
        ]);

        $role = Role::find($request->role);
        $permissions = Permission::whereIn('id', $request->permissions)->get();


        $role->givePermissionTo($permissions);
        return $this->setStatusCode(200)
                    ->responseWithSuccess();
    }

    public function removePermission(Request $request)
    {
        if (!auth()->user()->can('permission.remove')) {
            return $this->responseWithNotAllowed();
        }

        $this->validate($request, [
            'role'          => 'required',
            'permissions'   => 'required',
        ]);

        $role = Role::find($request->role);
        $permissions = Permission::whereIn('id', $request->permissions)->get();

        $role->revokePermissionTo($permissions);
        return $this->setStatusCode(200)
                    ->responseWithSuccess();
    }

    public function assignRole(Request $request)
    {
        if (!auth()->user()->can('role.assign')) {
            return $this->responseWithNotAllowed();
        }

        $this->validate($request, [
            'user' => 'required',
            'role' => 'required',
        ]);

        $user = User::find($request->user);
        $role = Role::find($request->role);

        $user->assignRole($role);
        return $this->setStatusCode(200)
                    ->responseWithSuccess();
    }
}
