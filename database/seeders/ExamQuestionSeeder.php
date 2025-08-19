<?php

namespace Database\Seeders;

use App\Models\ExamQuestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            [
                'exam_paper_id' => 39,
                'content' => 'An và Bình không quen biết nhau và học ở hai nơi khác nhau. Xác suất để An và Bình đạt điểm giỏi về môn Toán trong kì thi cuối năm tương ứng là 0,92 và 0,88. Tính xác suất để cả An và Bình đều đạt điểm giỏi.',
                'type' => 'single_choice',
                'answers' => [
                    [
                        'content' => "0,3597",
                        'is_correct' => false
                    ],
                    [
                        'content' => "0,8096",
                        'is_correct' => true
                    ],
                    [
                        'content' => "0,0096",
                        'is_correct' => false
                    ],
                    [
                        'content' => "0,3649",
                        'is_correct' => false
                    ],
                ],
                'marks' => 0.25
            ],
        ];
        for ($i = 0; $i < 40; $i++) {
            foreach ($questions as $question) {
                // Remove answers from question array before creating ExamQuestion
                $answers = $question['answers'];
                unset($question['answers']);

                // Create ExamQuestion model instance
                $examQuestion = ExamQuestion::create($question);

                // Add answers
                foreach ($answers as $answer) {
                    $examQuestion->answers()->create($answer);
                }
            }
        }
    }
}
