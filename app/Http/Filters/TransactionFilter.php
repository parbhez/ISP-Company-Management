<?php

namespace App\Http\Filters;
use Carbon\Carbon;

class TransactionFilter extends QueryFilter
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
            return $query->where('date', 'LIKE', '%' . $str . '%')
                ->orWhere('type', 'LIKE', '%' . $str . '%')
                ->orWhere('description',  'LIKE', '%' . $str . '%')
                ->orWhere('amount',  'LIKE', '%' . $str . '%');
        });
    }
}
