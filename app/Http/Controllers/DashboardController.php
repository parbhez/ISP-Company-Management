<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class DashboardController extends Controller
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
        if (is_null($this->user) || !$this->user->can('dashboard.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any dashboard !');
        }

        return Inertia::render('Dashboard', [
            'totalUser' => User::count(),
            'totalRole' => Role::count(),
            'totalCustomer' => Customer::count(),
            'totalPermission' => Permission::count(),
            'totalDepositTransaction' => Transaction::where('type', 'Deposit')->sum('amount'),
            'totalWithdrawTransaction' => Transaction::where('type', 'Withdraw')->sum('amount'),
            'totalBillCollection' => Bill::where('status', 'Paid')->sum('amount'),
            'totalBillPending' => Bill::where('status', 'Unpaid')->sum('amount'),
            'totalExpense' => Expense::sum('amount'),
        ]);
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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
