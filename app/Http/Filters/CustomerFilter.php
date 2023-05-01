<?php

namespace App\Http\Filters;
use Carbon\Carbon;

class CustomerFilter extends QueryFilter
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
    public function email($str = '')
    {
        if (empty($str)) {
            return true;
        }
        return $this->builder->where('email', 'LIKE', '%' . $str . '%');
    }

    /**
     * customer search by summary
     *
     * @param  String $str
     * @return Query Builder
     */
    public function phone($str = '')
    {
        if (empty($str)) {
            return true;
        }
        return $this->builder->where('phone', 'LIKE', '%' . $str . '%');
    }



    /**
     * customer search by datetime
     *
     * @param  String $str
     * @return Query Builder
     */
    public function address($str = '')
    {
        if (empty($str)) {
            return true;
        }
        return $this->builder->where('address', 'LIKE', '%' . $str . '%');
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
                ->orWhere('email', 'LIKE', '%' . $str . '%')
                ->orWhere('phone',  'LIKE', '%' . $str . '%')
                ->orWhere('address',  'LIKE', '%' . $str . '%');
        });
    }
}
