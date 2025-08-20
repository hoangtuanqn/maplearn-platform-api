<?php

namespace App\Filters\PaperExam;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class DifficultiesSlugFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $difficultyIds = is_array($value) ? $value : explode(',', $value);
        $query->whereIn('difficulty', $difficultyIds);
    }
}
