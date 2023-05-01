<?php

namespace App\Http\Filters;
use Carbon\Carbon;

class ExpenseFilter extends QueryFilter
{
    /**
     * customer search by news_title
     *
     * @param  String $str
     * @return Query Builder
     */
    public function name($str = '')
    {
        if (empty($str)) {
            return true;
        }
        return $this->builder->where('name', 'LIKE', '%' . $str . '%');
    }

    /**
     * customer search by details_link
     *
     * @param  String $str
     * @return Query Builder
     */
    public function date($str = '')
    {
        if (empty($str)) {
            return true;
        }
        return $this->builder->where('date', 'LIKE', '%' . $str . '%');
    }

    /**
     * Customer search by random string
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
                ->orWhere('date', 'LIKE', '%' . $str . '%')
                ->orWhere('amount',  'LIKE', '%' . $str . '%')
                ->orWhere('description',  'LIKE', '%' . $str . '%');
        });
    }
}
