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
            [
                'exam_paper_id' => 39,
                'content' => 'Một hình có dạng nửa hình cầu với bán kính $R$ chứa đầy nước. Trong bình nhúng một hình hộp chữ nhật (theo chiều thẳng đứng) với cạnh đáy là $a$ và $b$ , chiều cao là $h (h > R)$   . Khi đó để tràn ra được nhiều nước nhất thì kích thước cần tìm khi đó là $a$ = <-Drag->',
                'type' => 'drag_drop',
                'answers' => [
                    [
                        'content' => "$\dfrac{2R}{√3}$",
                        'is_correct' => false
                    ],
                    [
                        'content' => "$\dfrac{R}{√3}$",
                        'is_correct' => true
                    ],
                    [
                        'content' => "$\dfrac{R}{√2}$",
                        'is_correct' => false
                    ],
                    [
                        'content' => "$\dfrac{3R}{√2}$",
                        'is_correct' => false
                    ],
                ],
                'marks' => 0.25
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Bốn quả bóng được đặt trong một chiếc hộp. Một quả màu xanh, một quả màu đen và hai quả còn lại màu vàng. Lắc chiếc hộp và lấy 2 quả bóng ra. Có ít nhất một quả bóng được lấy ra là màu vàng. Xác suất để quả bóng còn lại được lấy ra cũng màu vàng?',
                'type' => 'numeric_input',
                'answers' => [
                    [
                        'content' => "200",
                        'is_correct' => true
                    ]
                ],
                'marks' => 0.25
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Cho $ab = 100$. Giá trị biểu thức là $log_{a}$ + $log_{b}$ là <-Drag->, $log_{ab}10$ là <-Drag->',
                'type' => 'drag_drop',
                'answers' => [
                    [
                        'content' => "2",
                        'is_correct' => true
                    ],
                    [
                        'content' => "4",
                        'is_correct' => true
                    ],
                    [
                        'content' => "1",
                        'is_correct' => false
                    ],
                    [
                        'content' => "0.5",
                        'is_correct' => false
                    ]

                ],
                'marks' => 0.25
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Tập hợp các số nguyên tố nhỏ hơn 10 là những số nào?',
                'type' => 'multiple_choice',
                'answers' => [
                    [
                        'content' => "2",
                        'is_correct' => true
                    ],
                    [
                        'content' => "3",
                        'is_correct' => true
                    ],
                    [
                        'content' => "5",
                        'is_correct' => true
                    ],
                    [
                        'content' => "7",
                        'is_correct' => true
                    ],
                    [
                        'content' => "9",
                        'is_correct' => false
                    ]
                ],
                'marks' => 0.25
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Tuấn là người code ra cái này?',
                'type' => 'true_false',
                'answers' => [
                    [
                        'content' => "Đúng", // or  (cái này có 1 item thôi)
                        'is_correct' => true
                    ],
                ],
                'marks' => 0.25
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Số nào sau đây là số nguyên tố?',
                'type' => 'single_choice',
                'answers' => [
                    ['content' => "4", 'is_correct' => false],
                    ['content' => "6", 'is_correct' => false],
                    ['content' => "9", 'is_correct' => false],
                    ['content' => "8", 'is_correct' => false],
                ],
                'marks' => 0.25
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Kết quả của phép tính $5 \times 7$ là?',
                'type' => 'numeric_input',
                'answers' => [
                    ['content' => "20", 'is_correct' => false]
                ],
                'marks' => 0.25
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Chọn các số chẵn dưới đây.',
                'type' => 'multiple_choice',
                'answers' => [
                    ['content' => "3", 'is_correct' => false],
                    ['content' => "5", 'is_correct' => false],
                    ['content' => "7", 'is_correct' => false],
                    ['content' => "9", 'is_correct' => false],
                ],
                'marks' => 0.25
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Hà Nội là thủ đô của nước nào?',
                'type' => 'single_choice',
                'answers' => [
                    ['content' => "Thái Lan", 'is_correct' => false],
                    ['content' => "Lào", 'is_correct' => false],
                    ['content' => "Campuchia", 'is_correct' => false],
                    ['content' => "Singapore", 'is_correct' => false],
                ],
                'marks' => 0.25
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Số nào là số lẻ?',
                'type' => 'single_choice',
                'answers' => [
                    ['content' => "2", 'is_correct' => false],
                    ['content' => "4", 'is_correct' => false],
                    ['content' => "6", 'is_correct' => false],
                    ['content' => "8", 'is_correct' => false],
                ],
                'marks' => 0.25
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Chọn các màu cơ bản.',
                'type' => 'multiple_choice',
                'answers' => [
                    ['content' => "Xanh lá", 'is_correct' => false],
                    ['content' => "Hồng", 'is_correct' => false],
                    ['content' => "Cam", 'is_correct' => false],
                    ['content' => "Tím", 'is_correct' => false],
                ],
                'marks' => 0.25
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Biển nào sau đây là lớn nhất thế giới?',
                'type' => 'single_choice',
                'answers' => [
                    ['content' => "Biển Đỏ", 'is_correct' => false],
                    ['content' => "Biển Đen", 'is_correct' => false],
                    ['content' => "Biển Baltic", 'is_correct' => false],
                    ['content' => "Biển Caspi", 'is_correct' => false],
                ],
                'marks' => 0.25
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Số nào là số chia hết cho 5?',
                'type' => 'single_choice',
                'answers' => [
                    ['content' => "12", 'is_correct' => false],
                    ['content' => "13", 'is_correct' => false],
                    ['content' => "14", 'is_correct' => false],
                    ['content' => "16", 'is_correct' => false],
                ],
                'marks' => 0.25
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Chọn các động vật có vú.',
                'type' => 'multiple_choice',
                'answers' => [
                    ['content' => "Cá", 'is_correct' => false],
                    ['content' => "Chim", 'is_correct' => false],
                    ['content' => "Rắn", 'is_correct' => false],
                    ['content' => "Ếch", 'is_correct' => false],
                ],
                'marks' => 0.25
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Việt Nam nằm ở châu lục nào?',
                'type' => 'single_choice',
                'answers' => [
                    ['content' => "Châu Âu", 'is_correct' => false],
                    ['content' => "Châu Mỹ", 'is_correct' => false],
                    ['content' => "Châu Phi", 'is_correct' => false],
                    ['content' => "Châu Đại Dương", 'is_correct' => false],
                ],
                'marks' => 0.25
            ],
        ];
        for ($i = 0; $i < 40; $i++) {
            // Randomly pick a question from the $questions array
            $question = $questions[array_rand($questions)];

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
