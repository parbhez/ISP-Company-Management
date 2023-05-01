<?php

namespace App\Http\Filters;

class RoleFilter extends QueryFilter
{
    /**
     * Category search by Category name
     *
     * @param  String $str
     * @return Query Builder
     */
    public function name($str = '')
    {
        if (empty($str)) {
            return true;
        }
        return $this->builder->where('name', 'LIKE', '%'. $str . '%');
    }


    /**
     * Affiliate user order by column and value
     *
     * @param  String  $str
     * @return Query Builder
     */
    public function order($str = null)
    {
        if (empty($str)) {
            return true;
        }
        return $this->builder->when($str == 'name', function($q) {
                return $q->orderBy('name', request('direction') ?? 'asc');
            });
    }

    /**
     * Affiliate user search by random string
     *
     * @param  String $str
     * @return Query Builder
     */
    public function q($str = '')
    {
        if (empty($str)) {
            return true;
        }
        return $this->builder->where( function($query) use ($str) {
            return $query->where('name', 'LIKE', '%'. $str . '%');
        });

    }
}
