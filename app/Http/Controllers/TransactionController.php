<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Filters\TransactionFilter;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\Transactions\TransactionsResource;

class TransactionController extends Controller
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
        if (is_null($this->user) || !$this->user->can('transaction.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any transaction !');
        }

        return Inertia::render('Transactions/ManageTransaction', [
            'all_transaction' => Transaction::get(),
            'all_accounts' => Account::get(),
        ]);
    }

        /**
     * Display the all the Accounts.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function lists(TransactionFilter $filter)
    {
        if (is_null($this->user) || !$this->user->can('transaction.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any transaction !');
        }

        return TransactionsResource::collection(
            Transaction::with('account')->filter($filter)
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
    public function store(TransactionRequest $form)
    {
        if (is_null($this->user) || !$this->user->can('transaction.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any transaction !');
        }

        $account = Account::find($form->account_id);
        $transactionType = $form->type;
        $transactionAmount = $form->amount;

        try {
            DB::beginTransaction();
            $data = Transaction::create($form->persist());

            //incrementing account balance
            if($transactionType === 'Deposit'){
                $account->balance = $account->balance + $transactionAmount;
                $account->updated_at = date('Y-m-d H:i:s');
                $account->save();
            }

            //decrementing account balance
            if($transactionType === 'Withdraw'){
                $account->balance = $account->balance - $transactionAmount;
                $account->updated_at = date('Y-m-d H:i:s');
                $account->save();
            }
            DB::commit();
            return respondSuccess(SUCCESS, new TransactionsResource($data), 201);
        } catch (Exception $e) {
            DB::rollBack();
            return respondError('Failed to create transaction', $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
