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
                'source' => 'https://drive.google.com/drive/u/6/folders/1PQ2jd7mN5ZBsUd0La4zEODKk4S62mGBb',
                'tags_id' => [1, 2, 3, 4],
                'download_count' => rand(10000, 20000),
                'category_id' => 1,
            ],
            [
                'title' => 'THI THỬ TỐT NGHIỆP THPT TOÁN 2025 - BÌNH PHƯỚC (LỜI GIẢI)',
                'source' => 'https://drive.google.com/drive/u/6/folders/1PQ2jd7mN5ZBsUd0La4zEODKk4S62mGBb',
                'tags_id' => [1, 2, 3, 4],
                'download_count' => rand(10000, 20000),
                'category_id' => 1,
            ],
            [
                'title' => 'THI THỬ TỐT NGHIỆP THPT TOÁN 2025 - BÌNH PHƯỚC (ĐỀ BÀI)',
                'source' => 'https://drive.google.com/drive/u/6/folders/1PQ2jd7mN5ZBsUd0La4zEODKk4S62mGBb',
                'download_count' => rand(10000, 20000),
                'tags_id' => [1, 2, 3, 4],
                'category_id' => 1,
            ],
            [
                'title' => 'THI THỬ TỐT NGHIỆP THPT TOÁN 2025 - KHÁNH HOÀ',
                'source' => 'https://drive.google.com/drive/u/6/folders/1PQ2jd7mN5ZBsUd0La4zEODKk4S62mGBb',
                'tags_id' => [1, 2, 3, 4],
                'download_count' => rand(10000, 20000),
                'category_id' => 1,
            ],
            [
                'title' => 'THI THỬ TỐT NGHIỆP THPT TOÁN 2025 - QUẢNG NAM',
                'source' => 'https://drive.google.com/drive/u/6/folders/1PQ2jd7mN5ZBsUd0La4zEODKk4S62mGBb',
                'tags_id' => [1, 2, 3, 4],
                'download_count' => rand(10000, 20000),
                'category_id' => 1,
            ],
            [
                'title' => 'THI THỬ TỐT NGHIỆP THPT TOÁN 2025 - YÊN BÁI',
                'source' => 'https://drive.google.com/drive/u/6/folders/1PQ2jd7mN5ZBsUd0La4zEODKk4S62mGBb',
                'tags_id' => [1, 2, 3, 4],
                'download_count' => rand(10000, 20000),
                'category_id' => 1,
            ],
            [
                'title' => 'THI THỬ TỐT NGHIỆP THPT TOÁN LẦN 2 2025 - BẮC GIANG',
                'source' => 'https://drive.google.com/drive/u/6/folders/1PQ2jd7mN5ZBsUd0La4zEODKk4S62mGBb',
                'tags_id' => [1, 2, 3, 4],
                'download_count' => rand(10000, 20000),
                'category_id' => 1,
            ],
            [
                'title' => 'THI THỬ TỐT NGHIỆP THPT TOÁN 2025 - HÀ TĨNH',
                'source' => 'https://drive.google.com/drive/u/6/folders/1PQ2jd7mN5ZBsUd0La4zEODKk4S62mGBb',
                'tags_id' => [1, 2, 3, 4],
                'download_count' => rand(10000, 20000),
                'category_id' => 1,
            ],
        ];

        // Thêm ngẫu nhiên 50 đề thi thử
        $provinces = [
            'HÀ NỘI',
            'HẢI PHÒNG',
            'HẢI DƯƠNG',
            'NAM ĐỊNH',
            'THANH HOÁ',
            'NGHỆ AN',
            'HÀ NAM',
            'NINH BÌNH',
            'PHÚ THỌ',
            'THÁI NGUYÊN',
            'BẮC NINH',
            'BẮC KẠN',
            'BẮC GIANG',
            'LẠNG SƠN',
            'CAO BẰNG',
            'SƠN LA',
            'LAI CHÂU',
            'ĐIỆN BIÊN',
            'LÂM ĐỒNG',
            'ĐẮK LẮK',
            'ĐẮK NÔNG',
            'GIA LAI',
            'KON TUM',
            'BÌNH ĐỊNH',
            'PHÚ YÊN',
            'KHÁNH HOÀ',
            'NINH THUẬN',
            'BÌNH THUẬN',
            'BÌNH PHƯỚC',
            'BÌNH DƯƠNG',
            'ĐỒNG NAI',
            'TÂY NINH',
            'LONG AN',
            'TIỀN GIANG',
            'BẾN TRE',
            'VĨNH LONG',
            'TRÀ VINH',
            'CẦN THƠ',
            'HẬU GIANG',
            'SÓC TRĂNG',
            'BẠC LIÊU',
            'CÀ MAU',
            'AN GIANG',
            'KIÊN GIANG',
            'ĐỒNG THÁP',
            'QUẢNG BÌNH',
            'QUẢNG TRỊ',
            'THỪA THIÊN HUẾ',
            'QUẢNG NGÃI',
            'QUẢNG NINH',
            'HÒA BÌNH',
            'TUYÊN QUANG'
        ];

        for ($i = 0; $i < 50; $i++) {
            $province = $provinces[array_rand($provinces)];
            $lan = rand(1, 3);
            $title = "THI THỬ TỐT NGHIỆP THPT TOÁN " . ($lan > 1 ? "LẦN $lan " : "") . "2025 - $province";
            $documentsData[] = [
                'title' => $title,
                'source' => 'https://drive.google.com/drive/u/6/folders/1PQ2jd7mN5ZBsUd0La4zEODKk4S62mGBb',
                'tags_id' => [1, 2, 3, 4],
                'download_count' => rand(10000, 20000),
                'category_id' => 1,
            ];
        }

        foreach ($documentsData as $document) {
            Document::create([
                'title' => $document['title'],
                'source' => $document['source'],
                'download_count' => $document['download_count'],
                'tags_id' => $document['tags_id'],
                'category_id' => $document['category_id'],
                'created_by' => 1,
                'status' => 1,
            ]);
        }
    }
}
