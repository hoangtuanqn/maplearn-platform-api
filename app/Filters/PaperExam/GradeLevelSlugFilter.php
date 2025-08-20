<?php

namespace App\Filters\PaperExam;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class GradeLevelSlugFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $teacherIds = is_array($value) ? $value : explode(',', $value);
        $query->whereHas('gradeLevel', function ($q) use ($teacherIds) {
            $q->whereIn('slug', $teacherIds);
        });
    }
}
