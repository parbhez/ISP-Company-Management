<?php

namespace App\Http\Filters;
use Carbon\Carbon;

class PackageFilter extends QueryFilter
{

    /**
     * Permission search by name
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
     * Permission search by group_name
     *
     * @param  String $str
     * @return Query Builder
     */
    public function monthly_fee($str = '')
    {
        if (empty($str)) {
            return true;
        }
        return $this->builder->where('monthly_fee', 'LIKE', '%' . $str . '%');
    }


    /**
     * Permission order by column and value
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
            ->when($str == 'monthly_fee', function ($q) {
                return $q->orderBy('monthly_fee', request('direction') ?? 'asc');
            })
            ->when($str == 'name', function ($q) {
                return $q->orderBy('name', request('direction') ?? 'asc');
            });

    }

    /**
     * Permission search by random string
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
                ->orWhere('monthly_fee',  'LIKE', '%' . $str . '%');
        });
    }
}
