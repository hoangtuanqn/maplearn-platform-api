<?php

namespace App\Filters\Invoice;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class SearchFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        if ($value !== null && $value !== '') {
            $query->whereHas('user', function ($q) use ($value) {
                $q->where('full_name', 'like', '%' . $value . '%')
                    ->orWhere('username', 'like', '%' . $value . '%')
                    ->orWhere('email', 'like', '%' . $value . '%');
            });
            // theo mã giao dịch
            $query->orWhere('transaction_code', 'like', '%' . $value . '%');
        }
    }
}
