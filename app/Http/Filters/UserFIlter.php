<?php

namespace App\Http\Filters;
use Carbon\Carbon;

class UserFilter extends QueryFilter
{

    /**
     * User search by name
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
     * User search by email
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
     * user order by column and value
     *
     * @param  String  $str
     * @return Query Builder
     */
    public function order($str = null)
    {
        if (empty($str)) {
            return true;
        }
        return $this->builder
            ->when($str == 'name', function ($q) {
                return $q->orderBy('name', request('direction') ?? 'asc');
            })
            ->when($str == 'email', function ($q) {
                return $q->orderBy('email', request('direction') ?? 'asc');
            });

    }

    /**
     * user search by random string
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
                ->orWhere('created_at',  'LIKE', '%' . $str . '%');
        });
    }
}
