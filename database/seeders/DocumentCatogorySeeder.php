<?php

namespace Database\Seeders;

use App\Models\DocumentCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentCatogorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Tuyển tập đề thi thử tốt nghiệp THPT Toán', 'Tuyển tập đề thi thử tốt nghiệp THPT Vật lý'];

        foreach ($categories as $category) {
            DocumentCategory::create([
                'name' => $category,
                'description' => 'Bộ tài liệu ôn tập đầu năm dành cho học sinh lớp 12, được biên soạn kỹ lưỡng bởi đội ngũ giáo viên giàu kinh nghiệm tại MapLearn, giúp bạn tự tin chinh phục mọi kỳ thi.',
                'status' => 1
            ]);
        }
    }
}
