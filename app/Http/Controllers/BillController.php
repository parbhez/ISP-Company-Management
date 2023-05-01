<?php

namespace App\Http\Controllers;

use App\Http\Filters\BillFilter;
use App\Http\Requests\BillRequest;
use App\Http\Resources\Bills\BillResource;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\Package;
use Exception;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BillController extends Controller
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
        if (is_null($this->user) || !$this->user->can('bill.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any bill !');
        }

        return Inertia::render('Bills/ManageBill', [
            'all_customers' => Customer::get(),
            'all_bills' => Bill::get(),
        ]);
    }

    /**
     * Display the all the Customers.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function lists(BillFilter $filter)
    {
        return BillResource::collection(
            Bill::with('customer')->filter($filter)
                ->latest()
                ->paginate(request('limit') ?? 10)
        );
    }

     /**
     * Display the customer wise bill amount.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function customerwisebillAmount($customer_id)
    {
        $package_id = Customer::select('package_id')->find($customer_id);
        return Package::select('monthly_fee')->find($package_id);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BillRequest $form)
    {
        if (is_null($this->user) || !$this->user->can('bill.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any bill !');
        }

        try {
            $data = Bill::create($form->persist());
            return respondSuccess(SUCCESS, new BillResource($data), 201);
        } catch (Exception $e) {
            return respondError('Failed to create bill', $e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BillRequest $form, $id)
    {
        if (is_null($this->user) || !$this->user->can('bill.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any bill !');
        }

        try {
            $bill = Bill::find($id);
            $bill->update($form->persist());
            return respondSuccess(SUCCESS, new BillResource($bill), 200);
        } catch (Exception $e) {
            return respondError('Failed to update bill', $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill $bill)
    {
        //
    }
}
