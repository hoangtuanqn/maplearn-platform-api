<?php

namespace App\Filters\Course;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class CategoryCourseSlugFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->whereHas('category', function ($q) use ($value) {
            $q->where('slug', $value);
        });
    }
}
