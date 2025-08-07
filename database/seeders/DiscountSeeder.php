<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DiscountSeeder extends Seeder
{
    /**
     * Giảm giá vào khóa học thông qua mã giảm giá
     */

    //    Key	Kiểu dữ liệu	Ý nghĩa / Dùng để làm gì	Ví dụ giá trị
    // grade	array of int	Chỉ áp dụng cho học sinh lớp mấy	[10, 11, 12]
    // subject_id	array of int	Chỉ áp dụng cho các môn học cụ thể	[1, 3] (Toán, Lý)
    // category_id	array of int	Chỉ áp dụng cho khóa học thuộc danh mục cụ thể	[5]
    // first_order	boolean	Chỉ áp dụng cho đơn hàng đầu tiên	true
    // combo_courses	array of int	Áp dụng khi người dùng mua chung các khóa học này	[1, 2, 3]
    // min_total_price	number	Tổng giá đơn hàng tối thiểu để áp dụng	500000
    // user_level	string hoặc array	Dành cho người dùng có cấp độ cụ thể	"vip" hoặc ["vip","pro"]
    // referral_user	boolean	Chỉ áp dụng nếu người dùng được giới thiệu (ref link, mã mời)	true
    // max_usage_per_cart	int	Mã này chỉ dùng tối đa N lần trong 1 đơn (cho multi-course checkout)	1
    // course_ids	array of int	Chỉ áp dụng cho các khóa học cụ thể	[1, 4, 7]
    public function run(): void
    {
        $keys = [
            'grade' => fn() => Arr::random([[10], [11, 12], [12]]),
            'subject_id' => fn() => Arr::random([[1], [2, 3], [1, 2, 4]]),
            'category_id' => fn() => Arr::random([[5], [1, 2], [3]]),
            'first_order' => fn() => true,
            'combo_courses' => fn() => Arr::random([[1, 2, 3], [5, 6], [10, 11, 12]]),
            'min_total_price' => fn() => Arr::random([200000, 300000, 500000]),
            'user_level' => fn() => Arr::random(["vip", ["vip", "pro"], "pro"]),
            'referral_user' => fn() => true,
            'max_usage_per_cart' => fn() => rand(1, 3),
            'course_ids' => fn() => Arr::random([[1], [3, 5], [7, 8, 9]]),
        ];

        for ($i = 0; $i < 10; $i++) {
            $type = Arr::random(['percentage', 'fixed']);

            // Random số lượng điều kiện (1–4 keys)
            $selectedKeys = Arr::random(array_keys($keys), rand(1, 4));
            $conditions = [];

            foreach ($selectedKeys as $key) {
                $conditions[$key] = $keys[$key]();
            }

            $discount = [
                'code' => strtoupper(Str::random(10)),
                'type' => $type,
                'value' => $type === 'percentage' ? rand(5, 50) : rand(100, 300) * 1000,
                'start_date' => now()->subDays(rand(0, 5)),
                'end_date' => now()->addDays(rand(5, 30)),
                'usage_limit' => rand(20, 100),
                'user_limit' => rand(1, 5),
                'conditions' => json_encode($conditions),
                'stackable' => Arr::random([true, false]),
                'visibility' => Arr::random(['public', 'private']),
                'is_active' => true,
            ];

            Discount::create($discount);
        }
    }
}
