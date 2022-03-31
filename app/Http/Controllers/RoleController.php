<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Http\Resources\SingleRoleResource;
use App\Models\permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();

        return response()->json([
            'data' => [
                'roles' => RoleResource::collection($roles)
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewRoleRequest $request)
    {

        /**
         * @var Role $role
         */
        $role = Role::query()->create([
            'title' => $request->get('title')
        ]);

        if ($request->filled('permissions')) {

            $permissions = permission::query()
                ->whereIn('title', $request->get('permissions'))->get();

            $role->permissions()->attach($permissions);

        }

        return response()->json([
            'data' => [
                'role' => new SingleRoleResource($role)
            ]
        ])->setStatusCode(201);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return response()->json([
            'data' => new SingleRoleResource($role)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {

        $roleExists = Role::query()
            ->where('title', $request->get('title'))
            ->where('id', '!=', $role->id)
            ->exists();

        if ($roleExists) {
            return response()->json([
                'data' => [
                    'message' => 'title already been taken'
                ]
            ])->setStatusCode(400);
        }

        $role->update([
            'title' => $request->get('title', $role->title)
        ]);

        $permissions = permission::query()
            ->whereIn('title', $request->get('permissions'))
            ->get();

        $role->permissions()->sync($permissions);

        return response()->json([
            'data' => [
                'role' => new SingleRoleResource($role)
            ]
        ])->setStatusCode(200);
    }

    /**
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse|object
     */

    public function destroy(Role $role)
    {
        $RoleHasUsers = $role->users()->count();

        if ($RoleHasUsers) {
            return response()->json([
                'data' => [
                    'message' => 'role has many users'
                ]
            ])->setStatusCode(400);
        }

        $role->permissions()->detach();

        $role->delete();

        return response()->json([
           'data' => [
               'messsaga' => 'role successfully deleted'
           ]
        ])->setStatusCode(200);
    }
}
