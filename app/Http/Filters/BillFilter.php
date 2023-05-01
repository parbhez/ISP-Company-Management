<?php

namespace App\Http\Filters;
use Carbon\Carbon;

class BillFilter extends QueryFilter
{
    /**
     * customer search by news_title
     *
     * @param  String $str
     * @return Query Builder
     */
    public function month($str = '')
    {
        if (empty($str)) {
            return true;
        }
        return $this->builder->where('month', 'LIKE', '%' . $str . '%');
    }

    /**
     * customer search by details_link
     *
     * @param  String $str
     * @return Query Builder
     */
    public function year($str = '')
    {
        if (empty($str)) {
            return true;
        }
        return $this->builder->where('year', 'LIKE', '%' . $str . '%');
    }

    /**
     * customer search by summary
     *
     * @param  String $str
     * @return Query Builder
     */
    public function amount($str = '')
    {
        if (empty($str)) {
            return true;
        }
        return $this->builder->where('amount', 'LIKE', '%' . $str . '%');
    }

    /**
     * customer search by datetime
     *
     * @param  String $str
     * @return Query Builder
     */
    public function status($str = '')
    {
        if (empty($str)) {
            return true;
        }
        return $this->builder->where('status', 'LIKE', '%' . $str . '%');
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
            return $query->where('month', 'LIKE', '%' . $str . '%')
                ->orWhere('year', 'LIKE', '%' . $str . '%')
                ->orWhere('amount',  'LIKE', '%' . $str . '%')
                ->orWhere('status',  'LIKE', '%' . $str . '%');
        });
    }
}
