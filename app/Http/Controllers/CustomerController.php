<?php

namespace App\Http\Controllers;

use App\Http\Filters\CustomerFilter;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\Customers\CustomerResource;
use App\Models\Customer;
use App\Models\Package;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CustomerController extends Controller
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
        if (is_null($this->user) || !$this->user->can('customer.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any customer !');
        }

        return Inertia::render('Customers/ManageCustomer', [
            'all_customers' => Customer::get(),
            'all_packages' => Package::get(),
        ]);
    }

    /**
     * Display the all the Customers.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function lists(CustomerFilter $filter)
    {
        if (is_null($this->user) || !$this->user->can('customer.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any customer !');
        }

        return CustomerResource::collection(
            Customer::with('package')->filter($filter)
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
    public function store(CustomerRequest $form)
    {
        if (is_null($this->user) || !$this->user->can('customer.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any customer !');
        }

        try {
            $data = Customer::create($form->persist());
            return respondSuccess(SUCCESS, new CustomerResource($data), 201);
        } catch (Exception $e) {
            return respondError('Failed to create customer', $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $form, $id)
    {
        if (is_null($this->user) || !$this->user->can('customer.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any customer !');
        }

        try {
            $customer = Customer::find($id);
            $customer->update($form->persist());
            return respondSuccess(SUCCESS, new CustomerResource($customer), 200);
        } catch (Exception $e) {
            return respondError('Failed to update customer', $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
