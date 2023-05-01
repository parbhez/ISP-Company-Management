<?php

namespace App\Http\Controllers;

use App\Http\Filters\AccountFilter;
use App\Http\Requests\AccountRequest;
use App\Http\Resources\Accounts\AccountResource;
use App\Models\Account;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AccountController extends Controller
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

        if (is_null($this->user) || !$this->user->can('account.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any account !');
        }

        $prefix = 'Acc';
        $idLength = 8;
        $account = Account::orderBy('id', 'desc')->first('account_number');
        $account_number = $account->account_number;
        $presentAccountNumber = sprintf('%08d', $account_number + 1);

        // echo $prefix."-".sprintf('%08d', $presentAccountNumber + 1);
        // echo "<pre>";
        // echo $prefix . "-". str_repeat("0", $idLength - strlen($presentAccountNumber)).($presentAccountNumber+1);

        return Inertia::render('Accounts/ManageAccount', [
            'all_accounts' => Account::get(),
            'presentAccountNumber' => $presentAccountNumber,
        ]);
    }

    /**
     * Display the all the Accounts.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function lists(AccountFilter $filter)
    {
        if (is_null($this->user) || !$this->user->can('account.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any account !');
        }

        return AccountResource::collection(
            Account::filter($filter)
                ->latest()
                ->paginate(request('limit') ?? 10)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountRequest $form)
    {
        if (is_null($this->user) || !$this->user->can('account.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any account !');
        }

        try {
            $data = Account::create($form->persist());
            return respondSuccess(SUCCESS, new AccountResource($data), 201);
        } catch (Exception $e) {
            return respondError('Failed to create account', $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AccountRequest $form, $id)
    {
        if (is_null($this->user) || !$this->user->can('account.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any account !');
        }

        try {
            $account = Account::find($id);
            $account->update($form->persist());
            return respondSuccess(SUCCESS, new AccountResource($account), 200);
        } catch (Exception $e) {
            return respondError('Failed to update account', $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        //
    }
}
