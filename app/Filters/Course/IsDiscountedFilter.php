<?php

namespace App\Filters\Course;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class IsDiscountedFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property): void
    {
        // Chỉ lọc nếu value là true (tức là người dùng muốn tìm các khóa học đang có discount)
        if (filter_var($value, FILTER_VALIDATE_BOOLEAN)) {
            $query->whereHas('courseDiscounts', function ($q) {
                // dd($q->select('usage_count')->where('id', 1)->get());
                $now = now();
                $q->where('is_active', true)
                    ->where(function ($query) use ($now) {
                        $query->whereNull('start_date')->orWhere('start_date', '<=', $now);
                    })
                    ->where(function ($query) use ($now) {
                        $query->whereNull('end_date')->orWhere('end_date', '>=', $now);
                    })
                    ->where(function ($query) {
                        $query->whereColumn('usage_count', '<', 'usage_limit') // ✅ fix đúng
                            ->orWhere('usage_limit', '=', 0);
                    });
            });
        }
    }
}
