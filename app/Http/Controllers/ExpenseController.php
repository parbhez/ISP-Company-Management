<?php

namespace App\Http\Controllers;

use App\Http\Filters\ExpenseFilter;
use App\Http\Requests\ExpenseRequest;
use App\Http\Resources\Expenses\ExpensesResource;
use App\Models\Expense;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ExpenseController extends Controller
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
        if (is_null($this->user) || !$this->user->can('expense.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any expense !');
        }

        return Inertia::render('Expenses/ManageExpense', [
            'all_expenses' => Expense::get(),
        ]);
    }


    /**
     * Display the all the Customers.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function lists(ExpenseFilter $filter)
    {
        if (is_null($this->user) || !$this->user->can('expense.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any expense !');
        }

        return ExpensesResource::collection(
            Expense::filter($filter)
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
    public function store(ExpenseRequest $form)
    {
        if (is_null($this->user) || !$this->user->can('expense.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any expense !');
        }

        try {
            $data = Expense::create($form->persist());
            return respondSuccess(SUCCESS, new ExpensesResource($data), 201);
        } catch (Exception $e) {
            return respondError('Failed to create expense', $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpenseRequest $form, $id)
    {
        if (is_null($this->user) || !$this->user->can('expense.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any expense !');
        }

        try {
            $expense = Expense::find($id);
            $expense->update($form->persist());
            return respondSuccess(SUCCESS, new ExpensesResource($expense), 200);
        } catch (Exception $e) {
            return respondError('Failed to update expense', $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        //
    }
}
