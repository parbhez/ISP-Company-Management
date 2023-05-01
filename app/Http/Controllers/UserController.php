<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Filters\UserFilter;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Users\UsersResource;

class UserController extends Controller
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
        if (is_null($this->user) || !$this->user->can('user.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any user !');
        }

        return Inertia::render('Users/ManageUser', [
            'all_users' => User::get(),
            'all_roles' => Role::get(),
        ]);
    }

     /**
     * Display the all the Roles.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function lists(UserFilter $filter)
    {
        if (is_null($this->user) || !$this->user->can('user.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any user !');
        }

        return UsersResource::collection(
            User::filter($filter)
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
    public function store(UserRequest $form)
    {
        if (is_null($this->user) || !$this->user->can('user.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any user !');
        }

        try {
            DB::beginTransaction();
            $user = User::create($form->persist());
            $roles = $form->input('roles');
            if (!empty($roles)) {
                $user->assignRole($roles);
            }
            DB::commit();
            return respondSuccess(SUCCESS, new UsersResource($user), 201);
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
    public function update(UserRequest $form, $id)
    {
        if (is_null($this->user) || !$this->user->can('user.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any user !');
        }

        try {
            DB::beginTransaction();
            $user = User::find($id);
            $user->update($form->persist());
            $user->roles()->detach();
            $roles = $form->input('roles');

            if (!empty($roles)) {
                $user->assignRole($roles);
            }
            DB::commit();
            return respondSuccess(UPDATE_SUCCESS, new UsersResource($user), 200);
        } catch (Exception $e) {
            DB::rollback();
            return respondError('Failed to update user', $e->getMessage(), 500);
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
