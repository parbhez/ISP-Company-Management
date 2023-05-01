<?php

namespace App\Http\Controllers;

use Artisan;
use Exception;
use App\Models\User;
// use App\Models\Role;
// use App\Models\Permission;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Filters\RoleFilter;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\Roles\RolesResource;

class RolesController extends Controller
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

    public function index(RoleFilter $filter)
    {

        if (is_null($this->user) || !$this->user->can('role.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any role !');
        }

        return Inertia::render('Roles/Index', [
            'roles' => Role::get(),
            'all_permissions' => Permission::get(),
            'permission_groups' => User::getPermissionGroups(),
        ]);
    }

    /**
     * Display the all the Roles.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function lists(RoleFilter $filter)
    {
        return RolesResource::collection(
            Role::with('permissions')->filter($filter)
                ->latest()
                ->paginate(request('limit') ?? 10)
        );
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
    public function store(RoleRequest $form)
    {
        if (is_null($this->user) || !$this->user->can('role.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any role !');
        }

        try {
            DB::beginTransaction();
            $role = Role::create($form->persist());
            $permissions = $form->input('permissions');
            if (!empty($permissions)) {
                $role->syncPermissions($permissions);
            }
            DB::commit();
            return respondSuccess(SUCCESS, new RolesResource($role), 201);
        } catch (Exception $e) {
            DB::rollback();
            return respondError('Failed to create role', $e->getMessage(), 500);
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
    public function update(RoleRequest $form, string $id)
    {

        if (is_null($this->user) || !$this->user->can('role.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any role !');
        }

        try {
            DB::beginTransaction();
            $role = Role::findById($id, 'web');
            $permissions = $form->input('permissions');
            if (!empty($permissions)) {
                $role->update($form->persist());
                $role->givePermissionTo($permissions);
                $role->syncPermissions($permissions);
            }
            DB::commit();
            return respondSuccess(UPDATE_SUCCESS, new RolesResource($role), 200);
        } catch (Exception $e) {
            DB::rollback();
            return respondError('Failed to update role', $e->getMessage(), 500);
        }
        // $role = Role::findById($id, 'web');
        // $permissions = $request->input('permissions');

        // if (!empty($permissions)) {
        //     $role->name = $request->name;
        //     $role->save();
        //     $role->syncPermissions($permissions);
        // }

        // return respondSuccess(UPDATE_SUCCESS, new RolesResource($role), 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function roleWisePermissionList()
    {
        $id = Auth::user()->id;
        $roleWisePermissionList = DB::table('model_has_roles')
        ->join('role_has_permissions','model_has_roles.role_id','=','role_has_permissions.role_id')
        ->join('permissions','role_has_permissions.permission_id','=','permissions.id')
        ->select('permissions.name','permissions.id')
        ->where('model_has_roles.model_id',$id)
        ->get();

        return response()->json(['roleWisePermissionList'=>$roleWisePermissionList],200);

    }
}
