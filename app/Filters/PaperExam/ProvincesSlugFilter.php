<?php

namespace App\Filters\PaperExam;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class ProvincesSlugFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $provinceIds = is_array($value) ? $value : explode(',', $value);

        $query->whereIn('province', $provinceIds);
    }
}
