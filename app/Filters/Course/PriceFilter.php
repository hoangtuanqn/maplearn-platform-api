<?php

namespace App\Filters\Course;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\Filters\Filter;

class PriceFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        // Bổ sung tính final_price ở SQL
        $query->addSelect(DB::raw("
        LEAST(
            price,
            COALESCE(
                (
                    SELECT MIN(
                        CASE
                            WHEN type = 'percentage' THEN price * (1 - value / 100)
                            ELSE GREATEST(0, price - value)
                        END
                    )
                    FROM course_discounts
                    WHERE course_id = courses.id
                      AND is_active = 1
                      AND (start_date IS NULL OR start_date <= NOW())
                      AND (end_date IS NULL OR end_date >= NOW())
                      AND (usage_limit = 0 OR usage_count < usage_limit)
                ),
                price
            )
        ) AS final_price
    "));

        switch ($value) {
            case 'free':
                $query->having('final_price', 0);
                break;

            case 'under-500k':
                $query->having('final_price', '<', 500000);
                break;

            case '500k-1m':
                $query->having('final_price', '>=', 500000)
                    ->having('final_price', '<=', 1000000);
                break;

            case '1m-2m':
                $query->having('final_price', '>=', 1000000)
                    ->having('final_price', '<=', 2000000);
                break;

            case 'above-2m':
                $query->having('final_price', '>', 2000000);
                break;

            case 'asc':
                $query->orderBy('final_price', 'asc');
                break;

            case 'desc':
                $query->orderBy('final_price', 'desc');
                break;
        }

        return $query;
    }
}
