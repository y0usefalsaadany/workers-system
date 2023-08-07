<?php

namespace App\Filters;

use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;


class PostFilter
{
    public function filter()
    {
        return [
            'content',
            'price',
            'worker.name',
            AllowedFilter::callback('item', function (Builder $query, $value) {
                $query->where('price', 'like', "%{$value}%")
                    ->orWhere('content', 'like', "%{$value}%")
                    ->orWhereHas('worker', function (Builder $query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
            })
        ];
    }
}
