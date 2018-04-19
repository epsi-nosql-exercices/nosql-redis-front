<?php
/**
 * Created by PhpStorm.
 * User: Poulet
 * Date: 19/04/2018
 * Time: 23:12
 */

namespace App\Helper;

use Illuminate\Pagination\Paginator as LaravelPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class Paginator
{

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (LaravelPaginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}