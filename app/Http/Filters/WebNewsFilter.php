<?php

namespace App\Http\Filters;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;

class WebNewsFilter extends QueryFilter
{

    protected $filterstartdate;

    /**
     * WebNews search by start datetime
     *
     * @param  String $str
     * @return Query Builder
     */
    public function startdate($date = '')
    {
        if (empty($date)) {
            return true;
        }
        $this->filterstartdate = $date;
       //dd(Carbon::now()->toDateTimeString());
        return $this->builder->whereBetween('datetime', [Carbon::parse($date)->startOfDay(), Carbon::now()->toDateTimeString()]);
    }

     /**
     * WebNews search by start enddatetime
     *
     * @param  String $str
     * @return Query Builder
     */
    public function enddate($date = '')
    {
        if (empty($date)) {
            return true;
        }
        //dd($this->filterstartdate);
       //dd(Carbon::now()->toDateTimeString());
       if(empty($this->filterstartdate)){
        $this->filterstartdate = Carbon::now()->toDateTimeString();
       }

        return $this->builder->whereBetween('datetime', [$this->filterstartdate, Carbon::parse($date)->endOfDay()]);
    }



    /**
     * WebNews search by agency
     *
     * @param  String $agency
     * @return Query Builder
     */

    public function agency($agency = '')
    {
        if (empty($agency)) {
            return true;
        }

        $this->builder->when($agency == 'all', function ($q) {
            return $q;
        })
            ->when($agency != 'all', function ($q) use ($agency) {
                return $q->where('agency', $agency);
            });
    }

    /**
     * WebNews search by Category
     *
     * @param  String $category
     * @return Query Builder
     */
    public function category($category = '')
    {
        if (empty($category)) {
            return true;
        }

        $this->builder->when($category == 'all', function ($q) {
            return $q;
        })
            ->when($category != 'all', function ($q) use ($category) {
                //dd($category);
                return $q->whereHas('category', function ($q2) use ($category) {
                    return $q2->where('categories.category_name', $category);
                });
            });
    }

    /**
     * WebNews search by Sentiment
     *
     * @param  String $sentiment
     * @return Query Builder
     */
    public function sentiment($sentiment = '')
    {
        if (empty($sentiment)) {
            return true;
        }

        $this->builder->when($sentiment == 'all', function ($q) {
            return $q;
        })
            ->when($sentiment != 'all', function ($q) use ($sentiment) {
                return $q->where('sentiment', 'LIKE', '%' . $sentiment . '%');
            });
    }


    /**
     * WebNews search by news_title
     *
     * @param  String $str
     * @return Query Builder
     */
    public function news_title($str = '')
    {
        if (empty($str)) {
            return true;
        }
        return $this->builder->where('news_title', 'LIKE', '%' . $str . '%');
    }

    /**
     * WebNews search by details_link
     *
     * @param  String $str
     * @return Query Builder
     */
    public function details_link($str = '')
    {
        if (empty($str)) {
            return true;
        }
        return $this->builder->where('details_link', 'LIKE', '%' . $str . '%');
    }

    /**
     * WebNews search by summary
     *
     * @param  String $str
     * @return Query Builder
     */
    public function summary($str = '')
    {
        if (empty($str)) {
            return true;
        }
        return $this->builder->where('summary', 'LIKE', '%' . $str . '%');
    }



    /**
     * WebNews search by datetime
     *
     * @param  String $str
     * @return Query Builder
     */
    public function datetime($str = '')
    {
        if (empty($str)) {
            return true;
        }
        return $this->builder->where('datetime', 'LIKE', '%' . $str . '%');
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
        return $this->builder
            ->when($str == 'agency', function ($q) {
                return $q->orderBy('agency', request('direction') ?? 'asc');
            })
            ->when($str == 'news_title', function ($q) {
                return $q->orderBy('news_title', request('direction') ?? 'asc');
            })
            ->when($str == 'sentiment', function ($q) {
                return $q->orderBy('sentiment', request('direction') ?? 'asc');
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
        return $this->builder->where(function ($query) use ($str) {
            return $query->where('agency', 'LIKE', '%' . $str . '%')
                ->orWhere('news_title', 'LIKE', '%' . $str . '%')
                ->orWhere('details_link',  'LIKE', '%' . $str . '%')
                ->orWhere('summary',  'LIKE', '%' . $str . '%')
                ->orWhere('sentiment',  'LIKE', '%' . $str . '%')
                ->orWhere('datetime',  'LIKE', '%' . $str . '%')
                ->orWhere('details_content',  'LIKE', '%' . $str . '%');
        });
    }
}
