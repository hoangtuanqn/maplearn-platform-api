<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
                'source' => '/doc.pdf',
                'download_count' => rand(10000, 20000),
                'category_id' => 1,

            ];
        }

        foreach ($documentsData as $document) {
            Document::create([
                'title' => $document['title'],
                'source' => $document['source'],
                'download_count' => $document['download_count'],
                'category_id' => $document['category_id'],
                'created_by' => 1,
                'status' => 1,
                'grade_level_id' => rand(1, 5), // Giả sử có 6 khối lớp
                'subject_id' => rand(1, 6), // Giả sử có 5 môn học
            ]);
        }
    }
}
