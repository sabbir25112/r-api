<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use App\Models\Role;
use App\Models\User;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::with('permissions')->limitPaginate();
        return $this->setStatusCode(200)
            ->setMessage("Roles Fetch Successfully")
            ->setResourceName('roles')
            ->responseWithCollection($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        $this->validate($request, [
            'role' => 'required',
            'permissions' => 'required',
        ]);

        $role = Role::find($request->role);
        $permissions = Permission::whereIn('id', $request->permissions)
            ->get();

        $role->givePermissionTo($permissions);
        return $this->setStatusCode(200)
            ->responseWithSuccess();
    }

    public function assignRole(Request $request)
    {
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
