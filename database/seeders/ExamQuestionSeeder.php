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
                'content' => 'Cho ba mệnh đề: P: "Nếu trời mưa thì đường ướt", Q: "Trời mưa", R: "Đường ướt". Mệnh đề nào sau đây đúng?',
                'type' => 'single_choice',
                'answers' => [
                    ['content' => "P ∧ Q ⇒ R", 'is_correct' => true],
                    ['content' => "P ∧ R ⇒ Q", 'is_correct' => false],
                    ['content' => "Q ∧ R ⇒ P", 'is_correct' => false],
                    ['content' => "P ∨ Q ⇒ R", 'is_correct' => false]
                ],
                'marks' => 0.25,
                'explanation' => 'Theo logic, P: "Nếu Q thì R" (Q ⇒ R). Với P và Q đúng, suy ra R đúng. Do đó P ∧ Q ⇒ R là đúng.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Xác định mệnh đề phủ định của "Mọi số nguyên tố đều là số lẻ".',
                'type' => 'single_choice',
                'answers' => [
                    ['content' => "Có ít nhất một số nguyên tố không phải số lẻ", 'is_correct' => true],
                    ['content' => "Mọi số nguyên tố là số chẵn", 'is_correct' => false],
                    ['content' => "Có ít nhất một số lẻ không phải số nguyên tố", 'is_correct' => false],
                    ['content' => "Mọi số lẻ là số nguyên tố", 'is_correct' => false]
                ],
                'marks' => 0.25,
                'explanation' => 'Phủ định của "Mọi A là B" là "Có ít nhất một A không phải B".'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Cho mệnh đề P: "Nếu x chia hết cho 6 thì x chia hết cho 3". Mệnh đề nào sau đây tương đương với P?',
                'type' => 'single_choice',
                'answers' => [
                    ['content' => "Nếu x không chia hết cho 3 thì x không chia hết cho 6", 'is_correct' => true],
                    ['content' => "Nếu x chia hết cho 3 thì x chia hết cho 6", 'is_correct' => false],
                    ['content' => "Nếu x không chia hết cho 6 thì x không chia hết cho 3", 'is_correct' => false],
                    ['content' => "x chia hết cho 6 hoặc x chia hết cho 3", 'is_correct' => false]
                ],
                'marks' => 0.25,
                'explanation' => 'Mệnh đề P: x chia hết cho 6 ⇒ x chia hết cho 3. Mệnh đề tương đương là đảo ngược và phủ định: ¬(x chia hết cho 3) ⇒ ¬(x chia hết cho 6).'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Chọn các mệnh đề đúng trong các mệnh đề sau.',
                'type' => 'multiple_choice',
                'answers' => [
                    ['content' => "Nếu 2 là số nguyên tố thì 2 là số lẻ", 'is_correct' => false],
                    ['content' => "Nếu 4 là số nguyên tố thì 4 là số lẻ", 'is_correct' => true],
                    ['content' => "Mọi số chẵn đều chia hết cho 2", 'is_correct' => true],
                    ['content' => "Có số lẻ không chia hết cho 2", 'is_correct' => true]
                ],
                'marks' => 0.25,
                'explanation' => 'Mệnh đề 1 sai vì 2 là số nguyên tố và lẻ. Mệnh đề 2 đúng vì tiền đề sai (4 không phải số nguyên tố). Mệnh đề 3 và 4 đúng theo định nghĩa.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Mệnh đề "Nếu x > 2 thì x^2 > 4" có đúng với mọi số thực x không?',
                'type' => 'true_false',
                'answers' => [
                    ['content' => "Đúng", 'is_correct' => true]
                ],
                'marks' => 0.25,
                'explanation' => 'Với x > 2, x^2 > 4 vì hàm x^2 tăng trên (2, +∞).'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Kết quả của phép toán logic (P ∧ Q) ∨ ¬P là gì nếu P đúng và Q sai? Kết quả là <-Drag->.',
                'type' => 'drag_drop',
                'answers' => [
                    ['content' => "Sai", 'is_correct' => true],
                    ['content' => "Đúng", 'is_correct' => false],
                    ['content' => "Không xác định", 'is_correct' => false],
                    ['content' => "Luôn đúng", 'is_correct' => false]
                ],
                'marks' => 0.25,
                'explanation' => 'Thay P = true, Q = false: (true ∧ false) ∨ ¬true = false ∨ false = false.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Nối các biểu thức logic với giá trị đúng khi P đúng, Q sai, R đúng. Kết quả là <-Drag->.',
                'type' => 'drag_drop',
                'answers' => [
                    ['content' => "P ∧ R → Đúng", 'is_correct' => true],
                    ['content' => "Q ∨ R → Đúng", 'is_correct' => true],
                    ['content' => "P ∧ Q → Sai", 'is_correct' => true],
                    ['content' => "¬Q → Đúng", 'is_correct' => true]
                ],
                'marks' => 0.25,
                'explanation' => 'P = true, Q = false, R = true: P ∧ R = true, Q ∨ R = true, P ∧ Q = false, ¬Q = true.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Mệnh đề nào sau đây là tautology (luôn đúng)?',
                'type' => 'single_choice',
                'answers' => [
                    ['content' => "P ∨ ¬P", 'is_correct' => true],
                    ['content' => "P ∧ ¬P", 'is_correct' => false],
                    ['content' => "P ⇒ Q", 'is_correct' => false],
                    ['content' => "P ∧ Q", 'is_correct' => false]
                ],
                'marks' => 0.25,
                'explanation' => 'P ∨ ¬P luôn đúng vì một trong hai mệnh đề luôn đúng.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Cho mệnh đề P: "Nếu x là số chẵn thì x chia hết cho 2". Mệnh đề phủ định của P là?',
                'type' => 'single_choice',
                'answers' => [
                    ['content' => "x là số chẵn và x không chia hết cho 2", 'is_correct' => true],
                    ['content' => "x không là số chẵn và x chia hết cho 2", 'is_correct' => false],
                    ['content' => "x là số lẻ và x chia hết cho 2", 'is_correct' => false],
                    ['content' => "x là số chẵn hoặc x chia hết cho 2", 'is_correct' => false]
                ],
                'marks' => 0.25,
                'explanation' => 'Phủ định của P: A ⇒ B là ¬A ∨ B, tức là x chẵn và không chia hết cho 2.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Kết quả của $¬(P ∧ Q)$ khi P sai và Q đúng là <-Drag->.',
                'type' => 'drag_drop',
                'answers' => [
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Sai", 'is_correct' => false]
                ],
                'marks' => 0.25,
                'explanation' => 'P = false, Q = true: P ∧ Q = false, ¬(P ∧ Q) = true.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Mệnh đề "Nếu x^2 = 9 thì x = 3" có đúng không?',
                'type' => 'true_false',
                'answers' => [
                    ['content' => "Sai", 'is_correct' => true]
                ],
                'marks' => 0.25,
                'explanation' => 'x^2 = 9 ⇒ x = 3 hoặc x = -3, nên mệnh đề sai.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Chọn các mệnh đề tương đương với P ⇒ Q.',
                'type' => 'multiple_choice',
                'answers' => [
                    ['content' => "¬P ∨ Q", 'is_correct' => true],
                    ['content' => "¬Q ⇒ ¬P", 'is_correct' => true],
                    ['content' => "P ∧ ¬Q", 'is_correct' => false],
                    ['content' => "P ∨ Q", 'is_correct' => false]
                ],
                'marks' => 0.25,
                'explanation' => 'P ⇒ Q tương đương với ¬P ∨ Q và ¬Q ⇒ ¬P.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Nếu P sai và Q đúng, giá trị của P ⇒ Q là?',
                'type' => 'single_choice',
                'answers' => [
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Sai", 'is_correct' => false],
                    ['content' => "Không xác định", 'is_correct' => false],
                    ['content' => "Luôn sai", 'is_correct' => false]
                ],
                'marks' => 0.25,
                'explanation' => 'P = false, Q = true: P ⇒ Q = ¬P ∨ Q = true ∨ true = true.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Nối các biểu thức logic với giá trị đúng khi P đúng, Q sai, R đúng. Kết quả là <-Drag->.',
                'type' => 'drag_drop',
                'answers' => [
                    ['content' => "P ∧ R → Đúng", 'is_correct' => true],
                    ['content' => "Q ∨ R → Đúng", 'is_correct' => true],
                    ['content' => "P ∧ Q → Sai", 'is_correct' => true],
                    ['content' => "¬Q → Đúng", 'is_correct' => true]
                ],
                'marks' => 0.25,
                'explanation' => 'P = true, Q = false, R = true: P ∧ R = true, Q ∨ R = true, P ∧ Q = false, ¬Q = true.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Mệnh đề nào sau đây là mâu thuẫn?',
                'type' => 'single_choice',
                'answers' => [
                    ['content' => "P ∧ ¬P", 'is_correct' => true],
                    ['content' => "P ∨ ¬P", 'is_correct' => false],
                    ['content' => "P ⇒ P", 'is_correct' => false],
                    ['content' => "P ∧ P", 'is_correct' => false]
                ],
                'marks' => 0.25,
                'explanation' => 'P ∧ ¬P luôn sai vì P và ¬P không thể đồng thời đúng.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Cho P: "Nếu x > 0 thì x^2 > 0". Mệnh đề phủ định của P là?',
                'type' => 'single_choice',
                'answers' => [
                    ['content' => "x > 0 và x^2 ≤ 0", 'is_correct' => true],
                    ['content' => "x ≤ 0 và x^2 > 0", 'is_correct' => false],
                    ['content' => "x > 0 hoặc x^2 > 0", 'is_correct' => false],
                    ['content' => "x ≤ 0 hoặc x^2 ≤ 0", 'is_correct' => false]
                ],
                'marks' => 0.25,
                'explanation' => 'Phủ định của A ⇒ B là A ∧ ¬B, tức x > 0 và x^2 ≤ 0.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Giá trị của (P ∨ Q) ∧ ¬P khi P sai và Q đúng là <-Drag->.',
                'type' => 'drag_drop',
                'answers' => [
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Sai", 'is_correct' => false]
                ],
                'marks' => 0.25,
                'explanation' => 'P = false, Q = true: (P ∨ Q) ∧ ¬P = (false ∨ true) ∧ true = true ∧ true = true.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Mệnh đề "Mọi số thực x đều thỏa mãn x^2 ≥ 0" có đúng không?',
                'type' => 'true_false',
                'answers' => [
                    ['content' => "Đúng", 'is_correct' => true]
                ],
                'marks' => 0.25,
                'explanation' => 'Với mọi x thực, x^2 ≥ 0 luôn đúng.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Chọn các mệnh đề đúng khi P sai, Q đúng, R sai.',
                'type' => 'multiple_choice',
                'answers' => [
                    ['content' => "¬P", 'is_correct' => true],
                    ['content' => "Q ∨ R", 'is_correct' => true],
                    ['content' => "P ∧ Q", 'is_correct' => false],
                    ['content' => "R ⇒ P", 'is_correct' => true]
                ],
                'marks' => 0.25,
                'explanation' => 'P = false, Q = true, R = false: ¬P = true, Q ∨ R = true, P ∧ Q = false, R ⇒ P = true.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Mệnh đề nào tương đương với ¬(P ∧ Q)?',
                'type' => 'single_choice',
                'answers' => [
                    ['content' => "¬P ∨ ¬Q", 'is_correct' => true],
                    ['content' => "¬P ∧ ¬Q", 'is_correct' => false],
                    ['content' => "P ∨ Q", 'is_correct' => false],
                    ['content' => "P ∧ Q", 'is_correct' => false]
                ],
                'marks' => 0.25,
                'explanation' => 'Theo định luật De Morgan, ¬(P ∧ Q) = ¬P ∨ ¬Q.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Nếu P ⇒ Q đúng và Q sai, thì P là <-Drag->.',
                'type' => 'drag_drop',
                'answers' => [
                    ['content' => "Sai", 'is_correct' => true],
                    ['content' => "Đúng", 'is_correct' => false],
                    ['content' => "Không xác định", 'is_correct' => false],
                    ['content' => "Luôn đúng", 'is_correct' => false]
                ],
                'marks' => 0.25,
                'explanation' => 'P ⇒ Q = ¬P ∨ Q. Nếu Q = false và P ⇒ Q = true, thì ¬P = true, suy ra P = false.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Nối các biểu thức logic với giá trị khi P sai, Q sai, R đúng. Kết quả là <-Drag->.',
                'type' => 'drag_drop',
                'answers' => [
                    ['content' => "P ∨ R → Đúng", 'is_correct' => true],
                    ['content' => "Q ∧ R → Sai", 'is_correct' => true],
                    ['content' => "¬P → Đúng", 'is_correct' => true],
                    ['content' => "P ⇒ Q → Đúng", 'is_correct' => true]
                ],
                'marks' => 0.25,
                'explanation' => 'P = false, Q = false, R = true: P ∨ R = true, Q ∧ R = false, ¬P = true, P ⇒ Q = true.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Mệnh đề nào sau đây là phủ định của "Nếu x là số lẻ thì x không chia hết cho 2"?',
                'type' => 'single_choice',
                'answers' => [
                    ['content' => "x là số lẻ và x chia hết cho 2", 'is_correct' => true],
                    ['content' => "x là số chẵn và x chia hết cho 2", 'is_correct' => false],
                    ['content' => "x là số lẻ hoặc x chia hết cho 2", 'is_correct' => false],
                    ['content' => "x không là số lẻ và x chia hết cho 2", 'is_correct' => false]
                ],
                'marks' => 0.25,
                'explanation' => 'Phủ định của A ⇒ B là A ∧ ¬B.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Giá trị của P ⇔ Q khi P đúng và Q sai là <-Drag->.',
                'type' => 'drag_drop',
                'answers' => [
                    ['content' => "Sai", 'is_correct' => true],
                    ['content' => "Đúng", 'is_correct' => false]
                ],
                'marks' => 0.25,
                'explanation' => 'P ⇔ Q = (P ⇒ Q) ∧ (Q ⇒ P). Với P = true, Q = false: P ⇒ Q = false, Q ⇒ P = true, nên P ⇔ Q = false.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Mệnh đề "Nếu x^2 ≥ 0 thì x là số thực" có đúng không?',
                'type' => 'true_false',
                'answers' => [
                    ['content' => "Đúng", 'is_correct' => true]
                ],
                'marks' => 0.25,
                'explanation' => 'x^2 ≥ 0 đúng với mọi x thực, và x thực, nên mệnh đề đúng.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Chọn các mệnh đề đúng khi P đúng, Q sai, R đúng.',
                'type' => 'multiple_choice',
                'answers' => [
                    ['content' => "P ∨ R", 'is_correct' => true],
                    ['content' => "¬Q", 'is_correct' => true],
                    ['content' => "P ∧ Q", 'is_correct' => false],
                    ['content' => "Q ⇒ R", 'is_correct' => true]
                ],
                'marks' => 0.25,
                'explanation' => 'P = true, Q = false, R = true: P ∨ R = true, ¬Q = true, P ∧ Q = false, Q ⇒ R = true.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Mệnh đề nào tương đương với P ⇔ Q?',
                'type' => 'single_choice',
                'answers' => [
                    ['content' => "(P ⇒ Q) ∧ (Q ⇒ P)", 'is_correct' => true],
                    ['content' => "P ∨ Q", 'is_correct' => false],
                    ['content' => "P ∧ Q", 'is_correct' => false],
                    ['content' => "¬P ∨ ¬Q", 'is_correct' => false]
                ],
                'marks' => 0.25,
                'explanation' => 'P ⇔ Q = (P ⇒ Q) ∧ (Q ⇒ P).'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Nếu P ∨ Q đúng và P sai, thì Q là <-Drag->.',
                'type' => 'drag_drop',
                'answers' => [
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Sai", 'is_correct' => false],
                    ['content' => "Không xác định", 'is_correct' => false],
                    ['content' => "Luôn sai", 'is_correct' => false]
                ],
                'marks' => 0.25,
                'explanation' => 'P ∨ Q = true, P = false ⇒ Q = true.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Nối các biểu thức logic với giá trị khi P đúng, Q đúng, R sai. Kết quả là <-Drag->.',
                'type' => 'drag_drop',
                'answers' => [
                    ['content' => "P ∧ Q → Đúng", 'is_correct' => true],
                    ['content' => "Q ∨ R → Đúng", 'is_correct' => true],
                    ['content' => "P ∧ R → Sai", 'is_correct' => true],
                    ['content' => "¬R → Đúng", 'is_correct' => true]
                ],
                'marks' => 0.25,
                'explanation' => 'P = true, Q = true, R = false: P ∧ Q = true, Q ∨ R = true, P ∧ R = false, ¬R = true.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Mệnh đề nào sau đây không phải tautology?',
                'type' => 'single_choice',
                'answers' => [
                    ['content' => "P ⇒ Q", 'is_correct' => true],
                    ['content' => "P ∨ ¬P", 'is_correct' => false],
                    ['content' => "P ⇒ P", 'is_correct' => false],
                    ['content' => "(P ∧ Q) ∨ ¬(P ∧ Q)", 'is_correct' => false]
                ],
                'marks' => 0.25,
                'explanation' => 'P ⇒ Q không phải tautology vì giá trị phụ thuộc vào P và Q.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Phủ định của "Có x sao cho x^2 = 4" là?',
                'type' => 'single_choice',
                'answers' => [
                    ['content' => "Mọi x đều thỏa x^2 ≠ 4", 'is_correct' => true],
                    ['content' => "Có x sao cho x^2 = 4", 'is_correct' => false],
                    ['content' => "Mọi x đều thỏa x^2 = 4", 'is_correct' => false],
                    ['content' => "Không có x nào thỏa x^2 ≠ 4", 'is_correct' => false]
                ],
                'marks' => 0.25,
                'explanation' => 'Phủ định của "Có x, P(x)" là "Mọi x, ¬P(x)".'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Giá trị của ¬(P ∨ Q) khi P sai và Q sai là <-Drag->.',
                'type' => 'drag_drop',
                'answers' => [
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Sai", 'is_correct' => false]
                ],
                'marks' => 0.25,
                'explanation' => 'P = false, Q = false: P ∨ Q = false, ¬(P ∨ Q) = true.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Mệnh đề "Mọi số nguyên x đều thỏa x + 1 > x" có đúng không?',
                'type' => 'true_false',
                'answers' => [
                    ['content' => "Đúng", 'is_correct' => true]
                ],
                'marks' => 0.25,
                'explanation' => 'Với mọi x nguyên, x + 1 > x luôn đúng.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Chọn các mệnh đề đúng khi P sai, Q đúng, R sai.',
                'type' => 'multiple_choice',
                'answers' => [
                    ['content' => "¬P", 'is_correct' => true],
                    ['content' => "Q ∨ R", 'is_correct' => true],
                    ['content' => "P ∧ Q", 'is_correct' => false],
                    ['content' => "R ⇒ P", 'is_correct' => true]
                ],
                'marks' => 0.25,
                'explanation' => 'P = false, Q = true, R = false: ¬P = true, Q ∨ R = true, P ∧ Q = false, R ⇒ P = true.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Mệnh đề nào tương đương với ¬(P ⇒ Q)?',
                'type' => 'single_choice',
                'answers' => [
                    ['content' => "P ∧ ¬Q", 'is_correct' => true],
                    ['content' => "¬P ∧ Q", 'is_correct' => false],
                    ['content' => "P ∨ Q", 'is_correct' => false],
                    ['content' => "¬P ∨ ¬Q", 'is_correct' => false]
                ],
                'marks' => 0.25,
                'explanation' => '¬(P ⇒ Q) = ¬(¬P ∨ Q) = P ∧ ¬Q.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Nếu P ∧ Q sai và P đúng, thì Q là <-Drag->.',
                'type' => 'drag_drop',
                'answers' => [
                    ['content' => "Sai", 'is_correct' => true],
                    ['content' => "Đúng", 'is_correct' => false],
                    ['content' => "Không xác định", 'is_correct' => false],
                    ['content' => "Luôn đúng", 'is_correct' => false]
                ],
                'marks' => 0.25,
                'explanation' => 'P ∧ Q = false, P = true ⇒ Q = false.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Nối các biểu thức logic với giá trị khi P sai, Q đúng, R sai. Kết quả là <-Drag->.',
                'type' => 'drag_drop',
                'answers' => [
                    ['content' => "P ∧ Q → Sai", 'is_correct' => true],
                    ['content' => "Q ∨ R → Đúng", 'is_correct' => true],
                    ['content' => "¬P → Đúng", 'is_correct' => true],
                    ['content' => "P ⇒ R → Đúng", 'is_correct' => true]
                ],
                'marks' => 0.25,
                'explanation' => 'P = false, Q = true, R = false: P ∧ Q = false, Q ∨ R = true, ¬P = true, P ⇒ R = true.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Mệnh đề nào sau đây là phủ định của "Mọi x, x^2 ≥ 0"?',
                'type' => 'single_choice',
                'answers' => [
                    ['content' => "Có x sao cho x^2 < 0", 'is_correct' => true],
                    ['content' => "Mọi x, x^2 < 0", 'is_correct' => false],
                    ['content' => "Có x sao cho x^2 ≥ 0", 'is_correct' => false],
                    ['content' => "Mọi x, x^2 = 0", 'is_correct' => false]
                ],
                'marks' => 0.25,
                'explanation' => 'Phủ định của "Mọi x, P(x)" là "Có x, ¬P(x)".'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Giá trị của (P ⇒ Q) ∧ (Q ⇒ P) khi P sai và Q đúng là <-Drag->.',
                'type' => 'drag_drop',
                'answers' => [
                    ['content' => "Sai", 'is_correct' => true],
                    ['content' => "Đúng", 'is_correct' => false]
                ],
                'marks' => 0.25,
                'explanation' => 'P = false, Q = true: P ⇒ Q = true, Q ⇒ P = false, nên (P ⇒ Q) ∧ (Q ⇒ P) = false.'
            ],
            [
                'exam_paper_id' => 39,
                'content' => 'Mệnh đề "Nếu x là số nguyên thì x + 1 là số nguyên" có đúng không?',
                'type' => 'true_false',
                'answers' => [
                    ['content' => "Đúng", 'is_correct' => true]
                ],
                'marks' => 0.25,
                'explanation' => 'Nếu x là số nguyên thì x + 1 cũng là số nguyên, nên mệnh đề đúng.'
            ]
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
