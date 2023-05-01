<?php

namespace App\Http\Controllers;

use App\Http\Filters\PackageFilter;
use App\Http\Requests\PackageRequest;
use App\Http\Resources\Packages\PackageResource;
use App\Models\Package;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
class PackageController extends Controller
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
        if (is_null($this->user) || !$this->user->can('package.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any package !');
        }

        return Inertia::render('Packages/ManagePackage', [
            'all_packages' => Package::get(),
        ]);
    }

    /**
     * Display the all the Roles.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function lists(PackageFilter $filter)
    {
        if (is_null($this->user) || !$this->user->can('package.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any package !');
        }

        return PackageResource::collection(
            Package::filter($filter)
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
    public function store(PackageRequest $form)
    {
        if (is_null($this->user) || !$this->user->can('package.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any package !');
        }

        try {
            $data = Package::create($form->persist());
            return respondSuccess(SUCCESS, new PackageResource($data), 201);
        } catch (Exception $e) {
            return respondError('Failed to create package', $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PackageRequest $form, string $id)
    {
        if (is_null($this->user) || !$this->user->can('package.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any package !');
        }

        try {
            $package = Package::find($id);
            $package->update($form->persist());
            return respondSuccess(SUCCESS, new PackageResource($package), 200);
        } catch (Exception $e) {
            return respondError('Failed to update permission', $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        //
    }
}
