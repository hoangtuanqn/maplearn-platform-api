<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documentsData = [
            [
                'title' => 'THI THỬ TỐT NGHIỆP THPT TOÁN LẦN 2 2025 - THÁI BÌNH',
                'source' => '',
                'tags_id' => [1, 2, 3, 4],
                'views' => rand(100, 1000),
                'category_id' => 1, // Assuming category_id 1 exists for Math
            ],
            [
                'title' => 'THI THỬ TỐT NGHIỆP THPT TOÁN 2025 - BÌNH PHƯỚC (LỜI GIẢI)',
                'source' => '',
                'tags_id' => [1, 2, 3, 4],
                'views' => rand(100, 1000),
                'category_id' => 1,
            ],
            [
                'title' => 'THI THỬ TỐT NGHIỆP THPT TOÁN 2025 - BÌNH PHƯỚC (ĐỀ BÀI)',
                'source' => '',
                'views' => rand(100, 1000),
                'tags_id' => [1, 2, 3, 4],
                'category_id' => 1,
            ],
            [
                'title' => 'THI THỬ TỐT NGHIỆP THPT TOÁN 2025 - KHÁNH HOÀ',
                'source' => '',
                'tags_id' => [1, 2, 3, 4],
                'views' => rand(100, 1000),
                'category_id' => 1,
            ],
            [
                'title' => 'THI THỬ TỐT NGHIỆP THPT TOÁN 2025 - QUẢNG NAM',
                'source' => '',
                'tags_id' => [1, 2, 3, 4],
                'views' => rand(100, 1000),
                'category_id' => 1,
            ],
            [
                'title' => 'THI THỬ TỐT NGHIỆP THPT TOÁN 2025 - YÊN BÁI',
                'source' => '',
                'tags_id' => [1, 2, 3, 4],
                'views' => rand(100, 1000),
                'category_id' => 1,
            ],
            [
                'title' => 'THI THỬ TỐT NGHIỆP THPT TOÁN LẦN 2 2025 - BẮC GIANG',
                'source' => '',
                'tags_id' => [1, 2, 3, 4],
                'views' => rand(100, 1000),
                'category_id' => 1,
            ],
            [
                'title' => 'THI THỬ TỐT NGHIỆP THPT TOÁN 2025 - HÀ TĨNH',
                'source' => '',
                'tags_id' => [1, 2, 3, 4],
                'views' => rand(100, 1000),
                'category_id' => 1,
            ],
        ];

        foreach ($documentsData as $document) {
            Document::create([
                'title' => $document['title'],
                'source' => $document['source'],
                'views' => $document['views'],
                'tags_id' => $document['tags_id'],
                'category_id' => $document['category_id'],
                'created_by' => 1,
                'status' => 1,
            ]);
        }
    }
}
