<?php

namespace App\Http\Filters;
use Carbon\Carbon;

class AccountFilter extends QueryFilter
{
    /**
     * Accounts search by random string
     *
     * @param  String $str
     * @return Query Builder
     */
    public function q($str = '')
    {
        if (empty($str)) {
            return true;
        }
        return $this->builder->where(function ($query) use ($str) {
            return $query->where('name', 'LIKE', '%' . $str . '%')
                ->orWhere('account_number', 'LIKE', '%' . $str . '%')
                ->orWhere('type',  'LIKE', '%' . $str . '%')
                ->orWhere('balance',  'LIKE', '%' . $str . '%');
        });
    }
}
