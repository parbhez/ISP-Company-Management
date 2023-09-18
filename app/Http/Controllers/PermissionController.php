<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Http\Filters\PermissionFilter;
use App\Http\Requests\PermissionRequest;
// use Spatie\Permission\Models\Permission;
use App\Http\Resources\Permissions\PermissionsResource;

class PermissionController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('permission.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any permission !');
        }

        return Inertia::render('Permissions/ManagePermission', [
            'all_permissions' => Permission::get(),
        ]);
    }

    /**
     * Display the all the Roles.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function lists(PermissionFilter $filter)
    {
        if (is_null($this->user) || !$this->user->can('permission.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any permission !');
        }


        return PermissionsResource::collection(
            Permission::filter($filter)
                ->latest()
                ->paginate(request('limit') ?? 10)
        );

        // return PermissionsResource::collection(
        //     Permission::latest()
        //         ->paginate(request('limit') ?? 10)
        // );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $form)
    {

        if (is_null($this->user) || !$this->user->can('permission.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any permission !');
        }


        try {
            $data = Permission::create($form->persist());
            return respondSuccess(SUCCESS, new PermissionsResource($data), 201);
        } catch (Exception $e) {
            return respondError('Failed to create permission', $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionRequest $form, string $id)
    {
        if (is_null($this->user) || !$this->user->can('permission.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any permission !');
        }

        try {
            $permission = Permission::find($id);
            $permission->update($form->persist());
            return respondSuccess(SUCCESS, new PermissionsResource($permission), 200);
        } catch (Exception $e) {
            return respondError('Failed to update permission', $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
