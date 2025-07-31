<?php

namespace App\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class GradeLevelSlugFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->whereHas('gradeLevel', function ($q) use ($value) {
            $q->where('slug', $value);
        });

    }
}
