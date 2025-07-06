<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Subject::factory(5)->create();
        $subjects = ['Toán', 'Lý', 'Sinh', 'Anh', 'Hóa', 'Văn'];

        foreach ($subjects as $subject) {
            Subject::create([
                'name' => $subject,
                'status' => 1
            ]);
        }
    }
}
