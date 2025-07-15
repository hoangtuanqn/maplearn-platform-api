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
                'status' => 1
            ]);
        }
    }
}
