<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = [
            [
                'name' => "Thầy Vũ Ngọc Anh",
                'image' => "https://mapstudy.sgp1.digitaloceanspaces.com/teacher/64b229b5d0a652b97e5ab22d/thay-vu-ngoc-anh-1719903957239.png",
            ],
            [
                'name' => "Thầy Nguyễn Anh Phong",
                'image' => "https://mapstudy.sgp1.digitaloceanspaces.com/teacher/ssje00d001mj/thay-phong-1719904088246.png",
            ],
            [
                'name' => "Thầy Nguyễn Chí Nhân",
                'image' => "https://mapstudy.sgp1.digitaloceanspaces.com/teacher/64b22c56d0a652b97e5ab25a/thay-nguyen-chi-nhan-1719904691156.png",
            ],
            [
                'name' => "Thầy Lam Trường",
                'image' => "https://mapstudy.sgp1.digitaloceanspaces.com/teacher/64b22ae2d0a652b97e5ab23f/thay-pham-ngoc-lam-truong-1719904662328.png",
            ],
            [
                'name' => "Thầy Thành Nam",
                'image' => "https://mapstudy.sgp1.digitaloceanspaces.com/teacher/yfmex9703azb/nguyen-thanh-nam-1731156203997.png",
            ],
            [
                'name' => "Thầy Nguyễn Phụ Hoàng Lân",
                'image' => "https://mapstudy.sgp1.digitaloceanspaces.com/teacher/ssjd7mc001j2/thay-lan-1719904579214.png",
            ],
            [
                'name' => "Thầy Đinh Hoàng Tùng",
                'image' => "https://mapstudy.sgp1.digitaloceanspaces.com/teacher/ssjep5c001pi/thay-tung-1719904541522.png",
            ],
            [
                'name' => "Cô Nguyễn Thị Thanh Thủy",
                'image' => "https://mapstudy.sgp1.digitaloceanspaces.com/teacher/ssjc7vu001gz/co-thuy---gv-mon-ngu-van-1719904650486.png",
            ],
            [
                'name' => "Thầy Vũ Trọng Đạt",
                'image' => "https://mapstudy.sgp1.digitaloceanspaces.com/teacher/64b22b96d0a652b97e5ab246/thay-nguyen-trong-dat-1719904677740.png",
            ],
            [
                'name' => "Thầy Phạm Minh Kiên",
                'image' => "https://mapstudy.sgp1.digitaloceanspaces.com/teacher/64b263141c19c4e72029f3e6/thay-pham-minh-kien-1718876072336.png",
            ],
            [
                'name' => "Thầy Đăng Tiến Nghĩa",
                'image' => "https://mapstudy.sgp1.digitaloceanspaces.com/teacher/6500812d4490d64f5f4aba61/thay-dang-tien-nghia-1730720187137.jpg",
            ],
            [
                'name' => "Thầy Đặng Tấn Hùng",
                'image' => "https://mapstudy.sgp1.digitaloceanspaces.com/teacher/3icn9d0006nq/thay-hung-1742205106984.jpg",
            ],
            [
                'name' => "Cô Nguyễn Thị Thu Thảo",
                'image' => "https://mapstudy.sgp1.digitaloceanspaces.com/teacher/3icohhn007gz/co-hien-1742205164177.jpg",
            ],
        ];

        $now = Carbon::now();

        $insertData = collect($teachers)->map(function ($teacher, $index) use ($now) {
            // Phân tích giới tính + tên đầy đủ (bỏ "Thầy", "Cô")
            $originalName = $teacher['name'];
            $gender = 'other';
            $fullName = $originalName;

            if (Str::startsWith($originalName, 'Thầy')) {
                $gender = 'male';
                $fullName = Str::replaceFirst('Thầy ', '', $originalName);
            } elseif (Str::startsWith($originalName, 'Cô')) {
                $gender = 'female';
                $fullName = Str::replaceFirst('Cô ', '', $originalName);
            }

            $username = Str::slug($fullName, '_') . '_' . ($index + 1);

            return [
                'username'     => $username,
                'email'        => $username . '@example.com',
                'password'     => bcrypt('password'),
                'full_name'    => $fullName,
                'gender'       => $gender,
                'role'         => 'teacher',
                'avatar'       => $teacher['image'],
                'created_at'   => $now,
                'updated_at'   => $now,
            ];
        })->toArray();

        User::insert($insertData);

        User::factory(5)->create();
    }
}
