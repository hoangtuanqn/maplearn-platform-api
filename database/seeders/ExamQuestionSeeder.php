<?php

namespace Database\Seeders;

use App\Models\ExamPaper;
use App\Models\ExamQuestion;
use Illuminate\Database\Seeder;

class ExamQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            // Câu 1: SINGLE_CHOICE
            [
                'content'       => 'Xét ba mệnh đề: \( A \): "Nếu trời mưa, tôi mang ô", \( B \): "Trời mưa", \( C \): "Tôi mang ô". Mệnh đề nào luôn đúng bất kể giá trị chân lý của \( A \), \( B \), và \( C \)?',
                'type'          => 'SINGLE_CHOICE',
                'answers'       => [
                    ['content' => "\( A \land B \implies C \)", 'is_correct' => true],
                    ['content' => "\( B \land C \implies A \)", 'is_correct' => false],
                    ['content' => "\( A \lor B \implies C \)", 'is_correct' => false],
                    ['content' => "\( A \land C \implies B \)", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => 'Mệnh đề \( A \): \( B \implies C \). Nếu \( A \) và \( B \) đúng, thì \( C \) phải đúng để \( B \implies C \) đúng. Do đó, \( A \land B \implies C \) luôn đúng theo luật logic suy ra.',
            ],
            // Câu 2: MULTIPLE_CHOICE
            [
                'content'       => 'Chọn các mệnh đề đúng về số nguyên \( n \).',
                'type'          => 'MULTIPLE_CHOICE',
                'answers'       => [
                    ['content' => "Nếu \( n \) chia hết cho 4 thì \( n \) chia hết cho 2", 'is_correct' => true],
                    ['content' => "Mọi số nguyên tố đều lẻ", 'is_correct' => false],
                    ['content' => "Có số nguyên \( n \) sao cho \( n^2 \) là số lẻ", 'is_correct' => true],
                    ['content' => "Nếu \( n \) là số lẻ thì \( n \) không chia hết cho 2", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => 'Mệnh đề 1 đúng vì 4 chia hết cho 2. Mệnh đề 2 sai vì 2 là số nguyên tố chẵn. Mệnh đề 3 đúng vì \( n = 3 \implies n^2 = 9 \) lẻ. Mệnh đề 4 đúng vì số lẻ không chia hết cho 2.',
            ],
            // Câu 3: TRUE_FALSE
            [
                'content'       => 'Mệnh đề: "Nếu \( x \) là số thực và \( x > 2 \), thì \( x^2 > 4 \)" có đúng với mọi số thực \( x \)?',
                'type'          => 'TRUE_FALSE',
                'answers'       => [
                    ['content' => "Đúng", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => 'Hàm \( f(x) = x^2 \) tăng trên \( (2, +\infty) \), nên nếu \( x > 2 \), thì \( x^2 > 4 \). Mệnh đề luôn đúng.',
            ],
            // Câu 4: DRAG_DROP
            [
                'content'       => 'Cho \( P \): "Hôm nay là thứ Bảy", \( Q \): "Tôi đi chơi". Giá trị của \( P \implies Q \) khi \( P \) sai và \( Q \) đúng là <-Drag->.',
                'type'          => 'DRAG_DROP',
                'answers'       => [
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Sai", 'is_correct' => false],
                    ['content' => "Không xác định", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( P = \text{false}, Q = \text{true} \): \( P \implies Q = \neg P \lor Q = \text{true} \lor \text{true} = \text{true} \).',
            ],
            // Câu 5: SINGLE_CHOICE
            [
                'content'       => 'Phủ định của mệnh đề: "Mọi số nguyên \( n \) chia hết cho 6 thì chia hết cho 3" là gì?',
                'type'          => 'SINGLE_CHOICE',
                'answers'       => [
                    ['content' => "Có số nguyên \( n \) chia hết cho 6 nhưng không chia hết cho 3", 'is_correct' => true],
                    ['content' => "Mọi số nguyên \( n \) chia hết cho 3 thì chia hết cho 6", 'is_correct' => false],
                    ['content' => "Có số nguyên \( n \) chia hết cho 3 nhưng không chia hết cho 6", 'is_correct' => false],
                    ['content' => "Mọi số nguyên \( n \) không chia hết cho 6 thì không chia hết cho 3", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => 'Phủ định của \( \forall x (P(x) \implies Q(x)) \) là \( \exists x (P(x) \land \neg Q(x)) \). Ở đây, \( P(n) \): \( n \) chia hết cho 6, \( Q(n) \): \( n \) chia hết cho 3.',
            ],
            // Câu 6: MULTIPLE_CHOICE
            [
                'content'       => 'Chọn các mệnh đề đúng về hình học.',
                'type'          => 'MULTIPLE_CHOICE',
                'answers'       => [
                    ['content' => "Mọi hình vuông đều là hình chữ nhật", 'is_correct' => true],
                    ['content' => "Mọi hình chữ nhật đều là hình vuông", 'is_correct' => false],
                    ['content' => "Có hình chữ nhật không phải là hình vuông", 'is_correct' => true],
                    ['content' => "Nếu một hình là hình vuông thì nó có bốn góc vuông", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => 'Hình vuông là trường hợp đặc biệt của hình chữ nhật, nhưng ngược lại thì không. Mọi hình vuông có bốn góc vuông.',
            ],
            // Câu 7: TRUE_FALSE
            [
                'content'       => 'Mệnh đề: "Nếu \( x^2 = 25 \), thì \( x = 5 \)" có đúng không?',
                'type'          => 'TRUE_FALSE',
                'answers'       => [
                    ['content' => "Sai", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => '\( x^2 = 25 \implies x = 5 \) hoặc \( x = -5 \), nên mệnh đề sai vì không xét \( x = -5 \).',
            ],
            // Câu 8: DRAG_DROP
            [
                'content'       => 'Cho \( A \): "Tôi học bài", \( B \): "Tôi thi đậu". Giá trị của \( \neg (A \land B) \) khi \( A \) sai và \( B \) đúng là <-Drag->.',
                'type'          => 'DRAG_DROP',
                'answers'       => [
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Sai", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( A = \text{false}, B = \text{true} \): \( A \land B = \text{false}, \neg (A \land B) = \text{true} \).',
            ],
            // Câu 9: SINGLE_CHOICE
            [
                'content'       => 'Mệnh đề nào tương đương với \( P \implies Q \), trong đó \( P \): "Tôi chăm chỉ", \( Q \): "Tôi thành công"?',
                'type'          => 'SINGLE_CHOICE',
                'answers'       => [
                    ['content' => "\( \neg Q \implies \neg P \)", 'is_correct' => true],
                    ['content' => "\( P \land Q \)", 'is_correct' => false],
                    ['content' => "\( P \lor Q \)", 'is_correct' => false],
                    ['content' => "\( \neg P \land \neg Q \)", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( P \implies Q \) tương đương với \( \neg Q \implies \neg P \) (đối đảo).',
            ],
            // Câu 10: MULTIPLE_CHOICE
            [
                'content'       => 'Chọn các mệnh đề đúng khi \( P \): "Hôm nay là thứ Hai", \( Q \): "Tôi đi làm", \( R \): "Tôi bận rộn", và \( P \) đúng, \( Q \) sai, \( R \) đúng.',
                'type'          => 'MULTIPLE_CHOICE',
                'answers'       => [
                    ['content' => "\( P \lor R \)", 'is_correct' => true],
                    ['content' => "\( \neg Q \)", 'is_correct' => true],
                    ['content' => "\( P \land Q \)", 'is_correct' => false],
                    ['content' => "\( Q \implies R \)", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => '\( P = \text{true}, Q = \text{false}, R = \text{true} \): \( P \lor R = \text{true}, \neg Q = \text{true}, P \land Q = \text{false}, Q \implies R = \text{true} \).',
            ],
            // Câu 11: TRUE_FALSE
            [
                'content'       => 'Mệnh đề: "Mọi số thực \( x \) đều thỏa mãn \( x^2 \geq 0 \)" có đúng không?',
                'type'          => 'TRUE_FALSE',
                'answers'       => [
                    ['content' => "Đúng", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => 'Bình phương của bất kỳ số thực nào cũng không âm.',
            ],
            // Câu 12: DRAG_DROP
            [
                'content'       => 'Cho \( C \): "Tôi đi ngủ sớm", \( D \): "Tôi thức dậy sớm". Giá trị của \( (C \lor D) \land \neg C \) khi \( C \) sai và \( D \) đúng là <-Drag->.',
                'type'          => 'DRAG_DROP',
                'answers'       => [
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Sai", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( C = \text{false}, D = \text{true} \): \( (C \lor D) \land \neg C = (\text{false} \lor \text{true}) \land \text{true} = \text{true} \land \text{true} = \text{true} \).',
            ],
            // Câu 13: SINGLE_CHOICE
            [
                'content'       => 'Mệnh đề nào là một tautology (luôn đúng)?',
                'type'          => 'SINGLE_CHOICE',
                'answers'       => [
                    ['content' => "\( P \lor \neg P \)", 'is_correct' => true],
                    ['content' => "\( P \land \neg P \)", 'is_correct' => false],
                    ['content' => "\( P \implies Q \)", 'is_correct' => false],
                    ['content' => "\( P \land Q \)", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( P \lor \neg P \) luôn đúng theo luật bài trung.',
            ],
            // Câu 14: MULTIPLE_CHOICE
            [
                'content'       => 'Chọn các mệnh đề đúng về tập hợp.',
                'type'          => 'MULTIPLE_CHOICE',
                'answers'       => [
                    ['content' => "Tập rỗng là tập con của mọi tập hợp", 'is_correct' => true],
                    ['content' => "Mọi tập hợp đều là tập con của chính nó", 'is_correct' => true],
                    ['content' => "Tập hợp \( \{1, 2\} \) là tập con của \( \{1, 2, 3\} \)", 'is_correct' => true],
                    ['content' => "Mọi tập hợp đều có số phần tử vô hạn", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => 'Tập rỗng và tập hợp là tập con của chính nó là đúng. \( \{1, 2\} \subset \{1, 2, 3\} \). Không phải tập nào cũng vô hạn.',
            ],
            // Câu 15: TRUE_FALSE
            [
                'content'       => 'Mệnh đề: "Nếu \( n \) là số nguyên thì \( n + 1 \) là số nguyên" có đúng không?',
                'type'          => 'TRUE_FALSE',
                'answers'       => [
                    ['content' => "Đúng", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => 'Tổng của số nguyên với số nguyên là số nguyên.',
            ],
            // Câu 16: DRAG_DROP
            [
                'content'       => 'Cho \( E \): "Tôi tập thể dục", \( F \): "Tôi khỏe mạnh", \( G \): "Tôi vui vẻ". Khi \( E \) đúng, \( F \) sai, \( G \) đúng, thì \( E \land G \) là <-Drag-> và \( F \lor G \) là <-Drag->.',
                'type'          => 'DRAG_DROP',
                'answers'       => [
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Sai", 'is_correct' => false],
                    ['content' => "Sai", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( E = \text{true}, F = \text{false}, G = \text{true} \): \( E \land G = \text{true}, F \lor G = \text{true} \).',
            ],
            // Câu 17: SINGLE_CHOICE
            [
                'content'       => 'Phủ định của mệnh đề: "Có số thực \( x \) sao cho \( x^2 = 16 \)" là gì?',
                'type'          => 'SINGLE_CHOICE',
                'answers'       => [
                    ['content' => "Mọi số thực \( x \) đều thỏa \( x^2 \neq 16 \)", 'is_correct' => true],
                    ['content' => "Có số thực \( x \) sao cho \( x^2 = 16 \)", 'is_correct' => false],
                    ['content' => "Mọi số thực \( x \) đều thỏa \( x^2 = 16 \)", 'is_correct' => false],
                    ['content' => "Không có số thực \( x \) nào thỏa \( x^2 \neq 16 \)", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => 'Phủ định của \( \exists x P(x) \) là \( \forall x \neg P(x) \).',
            ],
            // Câu 18: MULTIPLE_CHOICE
            [
                'content'       => 'Chọn các mệnh đề đúng khi \( H \): "Tôi đi học", \( I \): "Tôi mang sách", \( J \): "Tôi ghi chép", và \( H \) sai, \( I \) đúng, \( J \) sai.',
                'type'          => 'MULTIPLE_CHOICE',
                'answers'       => [
                    ['content' => "\( \neg H \)", 'is_correct' => true],
                    ['content' => "\( I \lor J \)", 'is_correct' => true],
                    ['content' => "\( H \land I \)", 'is_correct' => false],
                    ['content' => "\( J \implies H \)", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => '\( H = \text{false}, I = \text{true}, J = \text{false} \): \( \neg H = \text{true}, I \lor J = \text{true}, H \land I = \text{false}, J \implies H = \text{true} \).',
            ],
            // Câu 19: TRUE_FALSE
            [
                'content'       => 'Mệnh đề: "Có số nguyên âm lớn hơn mọi số dương" có đúng không?',
                'type'          => 'TRUE_FALSE',
                'answers'       => [
                    ['content' => "Sai", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => 'Không tồn tại số nguyên âm lớn hơn mọi số dương.',
            ],
            // Câu 20: DRAG_DROP
            [
                'content'       => 'Cho \( K \): "Hôm nay trời nắng", \( L \): "Tôi đi dạo". Nếu \( K \land L \) sai và \( K \) đúng, thì \( L \) là <-Drag->.',
                'type'          => 'DRAG_DROP',
                'answers'       => [
                    ['content' => "Sai", 'is_correct' => true],
                    ['content' => "Đúng", 'is_correct' => false],
                    ['content' => "Không xác định", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( K \land L = \text{false}, K = \text{true} \implies L = \text{false} \).',
            ],
            // Câu 21: SINGLE_CHOICE
            [
                'content'       => 'Mệnh đề nào tương đương với \( \neg (M \land N) \), trong đó \( M \): "Tôi học bài", \( N \): "Tôi thi đậu"?',
                'type'          => 'SINGLE_CHOICE',
                'answers'       => [
                    ['content' => "\( \neg M \lor \neg N \)", 'is_correct' => true],
                    ['content' => "\( \neg M \land \neg N \)", 'is_correct' => false],
                    ['content' => "\( M \lor N \)", 'is_correct' => false],
                    ['content' => "\( M \land N \)", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => 'Theo định luật De Morgan: \( \neg (M \land N) = \neg M \lor \neg N \).',
            ],
            // Câu 22: MULTIPLE_CHOICE
            [
                'content'       => 'Chọn các mệnh đề đúng về số nguyên tố.',
                'type'          => 'MULTIPLE_CHOICE',
                'answers'       => [
                    ['content' => "Mọi số nguyên tố lớn hơn 2 đều lẻ", 'is_correct' => true],
                    ['content' => "Có số nguyên tố là số chẵn", 'is_correct' => true],
                    ['content' => "Mọi số lẻ đều là số nguyên tố", 'is_correct' => false],
                    ['content' => "Số 1 không phải là số nguyên tố", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => '2 là số nguyên tố chẵn. Số 1 không phải nguyên tố. Không phải số lẻ nào cũng là nguyên tố (ví dụ: 9).',
            ],
            // Câu 23: TRUE_FALSE
            [
                'content'       => 'Mệnh đề: "Nếu \( x \) là số thực dương thì \( x^2 > 0 \)" có đúng không?',
                'type'          => 'TRUE_FALSE',
                'answers'       => [
                    ['content' => "Đúng", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => 'Bình phương số thực dương luôn dương.',
            ],
            // Câu 24: DRAG_DROP
            [
                'content'       => 'Cho \( O \): "Tôi đi học", \( P \): "Tôi mang sách", \( Q \): "Tôi ghi chép". Khi \( O \) sai, \( P \) đúng, \( Q \) sai, thì \( O \land P \) là <-Drag->, \( P \lor Q \) là <-Drag->, và \( \neg O \) là <-Drag->.',
                'type'          => 'DRAG_DROP',
                'answers'       => [
                    ['content' => "Sai", 'is_correct' => true],
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Sai", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( O = \text{false}, P = \text{true}, Q = \text{false} \): \( O \land P = \text{false}, P \lor Q = \text{true}, \neg O = \text{true} \).',
            ],
            // Câu 25: SINGLE_CHOICE
            [
                'content'       => 'Mệnh đề nào là mâu thuẫn (luôn sai)?',
                'type'          => 'SINGLE_CHOICE',
                'answers'       => [
                    ['content' => "\( R \land \neg R \)", 'is_correct' => true],
                    ['content' => "\( R \lor \neg R \)", 'is_correct' => false],
                    ['content' => "\( R \implies R \)", 'is_correct' => false],
                    ['content' => "\( R \iff R \)", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( R \land \neg R \) luôn sai theo luật mâu thuẫn.',
            ],
            // Câu 26: MULTIPLE_CHOICE
            [
                'content'       => 'Chọn các mệnh đề đúng khi \( S \): "Trời nắng", \( T \): "Tôi đi biển", \( U \): "Tôi tắm nắng", và \( S \) đúng, \( T \) sai, \( U \) đúng.',
                'type'          => 'MULTIPLE_CHOICE',
                'answers'       => [
                    ['content' => "\( S \lor U \)", 'is_correct' => true],
                    ['content' => "\( \neg T \)", 'is_correct' => true],
                    ['content' => "\( S \land T \)", 'is_correct' => false],
                    ['content' => "\( T \implies U \)", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => '\( S = \text{true}, T = \text{false}, U = \text{true} \): \( S \lor U = \text{true}, \neg T = \text{true}, S \land T = \text{false}, T \implies U = \text{true} \).',
            ],
            // Câu 27: TRUE_FALSE
            [
                'content'       => 'Mệnh đề: "Mọi số nguyên \( n \) đều thỏa mãn \( n + 3 > n \)" có đúng không?',
                'type'          => 'TRUE_FALSE',
                'answers'       => [
                    ['content' => "Đúng", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => 'Với mọi \( n \), \( n + 3 > n \) vì \( 3 > 0 \).',
            ],
            // Câu 28: DRAG_DROP
            [
                'content'       => 'Cho \( V \): "Tôi ăn sáng", \( W \): "Tôi no bụng". Giá trị của \( V \iff W \) khi \( V \) đúng và \( W \) sai là <-Drag->.',
                'type'          => 'DRAG_DROP',
                'answers'       => [
                    ['content' => "Sai", 'is_correct' => true],
                    ['content' => "Đúng", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( V \iff W = (V \implies W) \land (W \implies V) \). Với \( V = \text{true}, W = \text{false} \): \( V \implies W = \text{false} \), nên \( V \iff W = \text{false} \).',
            ],
            // Câu 29: SINGLE_CHOICE
            [
                'content'       => 'Phủ định của mệnh đề: "Nếu một hàm liên tục thì nó khả vi" là gì?',
                'type'          => 'SINGLE_CHOICE',
                'answers'       => [
                    ['content' => "Có hàm liên tục nhưng không khả vi", 'is_correct' => true],
                    ['content' => "Mọi hàm liên tục đều khả vi", 'is_correct' => false],
                    ['content' => "Có hàm không liên tục nhưng khả vi", 'is_correct' => false],
                    ['content' => "Nếu hàm không khả vi thì không liên tục", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => 'Phủ định của \( P \implies Q \) là \( P \land \neg Q \).',
            ],
            // Câu 30: MULTIPLE_CHOICE
            [
                'content'       => 'Chọn các mệnh đề đúng về quan hệ logic.',
                'type'          => 'MULTIPLE_CHOICE',
                'answers'       => [
                    ['content' => "\( P \implies Q \) tương đương với \( \neg P \lor Q \)", 'is_correct' => true],
                    ['content' => "\( \neg (P \lor Q) = \neg P \land \neg Q \)", 'is_correct' => true],
                    ['content' => "\( P \land Q = Q \land P \)", 'is_correct' => true],
                    ['content' => "\( P \lor Q = \neg P \lor \neg Q \)", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => 'Các mệnh đề 1, 2, 3 đúng theo luật logic. Mệnh đề 4 sai vì không tương đương.',
            ],
            // Câu 31: TRUE_FALSE
            [
                'content'       => 'Mệnh đề: "Nếu \( x^2 \geq 0 \), thì \( x \) là số thực" có đúng không?',
                'type'          => 'TRUE_FALSE',
                'answers'       => [
                    ['content' => "Đúng", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => '\( x^2 \geq 0 \) đúng với mọi \( x \) thực, nên mệnh đề đúng.',
            ],
            // Câu 32: DRAG_DROP
            [
                'content'       => 'Cho \( X \): "Mèo kêu", \( Y \): "Chó sủa", \( Z \): "Chim hót". Khi \( X \) đúng, \( Y \) sai, \( Z \) đúng, thì \( X \lor Y \) là <-Drag-> và \( Y \land Z \) là <-Drag->.',
                'type'          => 'DRAG_DROP',
                'answers'       => [
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Sai", 'is_correct' => true],
                    ['content' => "Sai", 'is_correct' => false],
                    ['content' => "Đúng", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( X = \text{true}, Y = \text{false}, Z = \text{true} \): \( X \lor Y = \text{true}, Y \land Z = \text{false} \).',
            ],
            // Câu 33: SINGLE_CHOICE
            [
                'content'       => 'Mệnh đề nào tương đương với \( P \iff Q \), trong đó \( P \): "Tôi nỗ lực", \( Q \): "Tôi thành công"?',
                'type'          => 'SINGLE_CHOICE',
                'answers'       => [
                    ['content' => "\( (P \implies Q) \land (Q \implies P) \)", 'is_correct' => true],
                    ['content' => "\( P \lor Q \)", 'is_correct' => false],
                    ['content' => "\( P \land Q \)", 'is_correct' => false],
                    ['content' => "\( \neg P \lor \neg Q \)", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( P \iff Q = (P \implies Q) \land (Q \implies P) \).',
            ],
            // Câu 34: MULTIPLE_CHOICE
            [
                'content'       => 'Chọn các mệnh đề đúng về hình học phẳng.',
                'type'          => 'MULTIPLE_CHOICE',
                'answers'       => [
                    ['content' => "Tổng các góc trong tam giác bằng 180 độ", 'is_correct' => true],
                    ['content' => "Mọi tam giác đều có ba cạnh bằng nhau", 'is_correct' => false],
                    ['content' => "Có tam giác không có góc nhọn", 'is_correct' => true],
                    ['content' => "Mọi hình bình hành đều là hình thoi", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => 'Tổng góc tam giác là 180°. Có tam giác không nhọn (tam giác vuông hoặc tù). Không phải hình bình hành nào cũng là hình thoi.',
            ],
            // Câu 35: TRUE_FALSE
            [
                'content'       => 'Mệnh đề: "Nếu \( n \) là số lẻ thì \( n^2 \) là số lẻ" có đúng không?',
                'type'          => 'TRUE_FALSE',
                'answers'       => [
                    ['content' => "Đúng", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => 'Số lẻ bình phương vẫn là số lẻ (ví dụ: \( 3^2 = 9 \)).',
            ],
            // Câu 36: DRAG_DROP
            [
                'content'       => 'Cho \( A \): "Hôm nay là thứ Sáu", \( B \): "Tôi nghỉ ngơi". Nếu \( A \lor B \) đúng và \( A \) sai, thì \( B \) là <-Drag->.',
                'type'          => 'DRAG_DROP',
                'answers'       => [
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Sai", 'is_correct' => false],
                    ['content' => "Không xác định", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( A \lor B = \text{true}, A = \text{false} \implies B = \text{true} \).',
            ],
            // Câu 37: SINGLE_CHOICE
            [
                'content'       => 'Phủ định của mệnh đề: "Mọi số tự nhiên đều lớn hơn 0" là gì?',
                'type'          => 'SINGLE_CHOICE',
                'answers'       => [
                    ['content' => "Có số tự nhiên không lớn hơn 0", 'is_correct' => true],
                    ['content' => "Mọi số tự nhiên đều nhỏ hơn 0", 'is_correct' => false],
                    ['content' => "Có số tự nhiên lớn hơn 0", 'is_correct' => false],
                    ['content' => "Không có số tự nhiên nào lớn hơn 0", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => 'Phủ định của \( \forall x P(x) \) là \( \exists x \neg P(x) \).',
            ],
            // Câu 38: MULTIPLE_CHOICE
            [
                'content'       => 'Chọn các mệnh đề đúng khi \( C \): "Tôi ăn sáng", \( D \): "Tôi no bụng", \( E \): "Tôi năng động", và \( C \) sai, \( D \) đúng, \( E \) sai.',
                'type'          => 'MULTIPLE_CHOICE',
                'answers'       => [
                    ['content' => "\( \neg C \)", 'is_correct' => true],
                    ['content' => "\( D \lor E \)", 'is_correct' => true],
                    ['content' => "\( C \land D \)", 'is_correct' => false],
                    ['content' => "\( E \implies C \)", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => '\( C = \text{false}, D = \text{true}, E = \text{false} \): \( \neg C = \text{true}, D \lor E = \text{true}, C \land D = \text{false}, E \implies C = \text{true} \).',
            ],
            // Câu 39: TRUE_FALSE
            [
                'content'       => 'Mệnh đề: "Nếu một số chia hết cho 9 thì nó chia hết cho 3" có đúng không?',
                'type'          => 'TRUE_FALSE',
                'answers'       => [
                    ['content' => "Đúng", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => 'Số chia hết cho 9 thì chia hết cho 3 vì 9 chia hết cho 3.',
            ],
            // Câu 40: DRAG_DROP
            [
                'content'       => 'Cho \( F \): "Tôi đi ngủ sớm", \( G \): "Tôi thức dậy sớm", \( H \): "Tôi khỏe mạnh". Khi \( F \) sai, \( G \) đúng, \( H \) sai, thì \( \neg F \) là <-Drag->, \( G \lor H \) là <-Drag->, và \( F \land G \) là <-Drag->.',
                'type'          => 'DRAG_DROP',
                'answers'       => [
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Sai", 'is_correct' => true],
                    ['content' => "Sai", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( F = \text{false}, G = \text{true}, H = \text{false} \): \( \neg F = \text{true}, G \lor H = \text{true}, F \land G = \text{false} \).',
            ],
        ];
        // get số lượng bản ghi bên exam paper
        $examPaperCount = ExamPaper::count();
        for ($i = 1; $i <= $examPaperCount; $i++) {
            for ($j = 0; $j < 40; $j++) {
                // Randomly pick a question from the $questions array
                $question = $questions[array_rand($questions)];

                // Remove answers from question array before creating ExamQuestion
                $answers = $question['answers'];
                unset($question['answers']);
                $correct = [];
                foreach ($answers as $idx => $answer) {
                    if ($answer['is_correct']) {
                        $correct[] = $answer['content'];
                    }
                    unset($answers[$idx]['is_correct']);
                }
                // $correct             = array_filter($answers, fn($item) => $item['is_correct']);
                $question['options'] = $answers;
                $question['correct'] = array_values($correct);
                $question['exam_paper_id'] = $i;



                ExamQuestion::create($question);
            }
        }
    }
}
