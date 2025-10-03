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
            // SINGLE_CHOICE Questions (8 questions)
            [
                'content'       => 'Mệnh đề nào sau đây tương đương với \( P \implies Q \), trong đó \( P \): "Tôi học bài", \( Q \): "Tôi thi đậu"?',
                'type'          => 'SINGLE_CHOICE',
                'answers'       => [
                    ['content' => "\( \neg P \lor Q \)", 'is_correct' => true],
                    ['content' => "\( P \land Q \)", 'is_correct' => false],
                    ['content' => "\( P \lor Q \)", 'is_correct' => false],
                    ['content' => "\( \neg P \land \neg Q \)", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => 'Mệnh đề \( P \implies Q \) tương đương với \( \neg P \lor Q \) theo định nghĩa logic của phép suy ra.',
            ],
            [
                'content'       => 'Phủ định của mệnh đề: "Mọi số thực \( x \) thỏa mãn \( x^2 > 0 \)" là gì?',
                'type'          => 'SINGLE_CHOICE',
                'answers'       => [
                    ['content' => "Có số thực \( x \) sao cho \( x^2 \leq 0 \)", 'is_correct' => true],
                    ['content' => "Mọi số thực \( x \) thỏa mãn \( x^2 \leq 0 \)", 'is_correct' => false],
                    ['content' => "Có số thực \( x \) sao cho \( x^2 > 0 \)", 'is_correct' => false],
                    ['content' => "Mọi số thực \( x \) thỏa mãn \( x^2 = 0 \)", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => 'Phủ định của \( \forall x P(x) \) là \( \exists x \neg P(x) \). Ở đây, \( P(x) \): \( x^2 > 0 \), nên phủ định là \( \exists x (x^2 \leq 0) \).',
            ],
            [
                'content'       => 'Mệnh đề nào là một tautology?',
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
            [
                'content'       => 'Nếu \( n \) là số nguyên, mệnh đề nào luôn đúng?',
                'type'          => 'SINGLE_CHOICE',
                'answers'       => [
                    ['content' => "\( n + 1 > n \)", 'is_correct' => true],
                    ['content' => "\( n^2 < n \)", 'is_correct' => false],
                    ['content' => "\( n \geq 0 \)", 'is_correct' => false],
                    ['content' => "\( n \) là số chẵn", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => 'Với mọi số nguyên \( n \), \( n + 1 = n + 1 > n \), nên mệnh đề luôn đúng.',
            ],
            [
                'content'       => 'Mệnh đề nào tương đương với \( \neg (P \lor Q) \)?',
                'type'          => 'SINGLE_CHOICE',
                'answers'       => [
                    ['content' => "\( \neg P \land \neg Q \)", 'is_correct' => true],
                    ['content' => "\( \neg P \lor \neg Q \)", 'is_correct' => false],
                    ['content' => "\( P \land Q \)", 'is_correct' => false],
                    ['content' => "\( P \lor Q \)", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => 'Theo định luật De Morgan, \( \neg (P \lor Q) = \neg P \land \neg Q \).',
            ],
            [
                'content'       => 'Cho \( A \): "Trời mưa", \( B \): "Tôi mang ô". Mệnh đề nào tương đương với \( A \implies B \)?',
                'type'          => 'SINGLE_CHOICE',
                'answers'       => [
                    ['content' => "\( \neg B \implies \neg A \)", 'is_correct' => true],
                    ['content' => "\( A \land B \)", 'is_correct' => false],
                    ['content' => "\( A \lor B \)", 'is_correct' => false],
                    ['content' => "\( \neg A \land \neg B \)", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( A \implies B \) tương đương với \( \neg B \implies \neg A \) (đối đảo).',
            ],
            [
                'content'       => 'Mệnh đề nào là phủ định của: "Có số nguyên \( n \) sao cho \( n^2 = 4 \)"?',
                'type'          => 'SINGLE_CHOICE',
                'answers'       => [
                    ['content' => "Mọi số nguyên \( n \) đều thỏa \( n^2 \neq 4 \)", 'is_correct' => true],
                    ['content' => "Có số nguyên \( n \) sao cho \( n^2 = 4 \)", 'is_correct' => false],
                    ['content' => "Mọi số nguyên \( n \) đều thỏa \( n^2 = 4 \)", 'is_correct' => false],
                    ['content' => "Không có số nguyên \( n \) nào thỏa \( n^2 \neq 4 \)", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => 'Phủ định của \( \exists x P(x) \) là \( \forall x \neg P(x) \). Ở đây, \( P(n) \): \( n^2 = 4 \), nên phủ định là \( \forall n (n^2 \neq 4) \).',
            ],
            [
                'content'       => 'Mệnh đề nào là mâu thuẫn?',
                'type'          => 'SINGLE_CHOICE',
                'answers'       => [
                    ['content' => "\( P \land \neg P \)", 'is_correct' => true],
                    ['content' => "\( P \lor \neg P \)", 'is_correct' => false],
                    ['content' => "\( P \implies P \)", 'is_correct' => false],
                    ['content' => "\( P \iff P \)", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( P \land \neg P \) luôn sai theo luật mâu thuẫn.',
            ],

            // MULTIPLE_CHOICE Questions (8 questions)
            [
                'content'       => 'Chọn các mệnh đề đúng về số nguyên \( n \).',
                'type'          => 'MULTIPLE_CHOICE',
                'answers'       => [
                    ['content' => "Nếu \( n \) chia hết cho 4 thì \( n \) chia hết cho 2", 'is_correct' => true],
                    ['content' => "Mọi số nguyên tố đều lớn hơn 1", 'is_correct' => true],
                    ['content' => "Có số nguyên \( n \) sao cho \( n^2 \) là số chẵn", 'is_correct' => true],
                    ['content' => "Mọi số chẵn đều là số nguyên tố", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => 'Mệnh đề 1 đúng vì 4 chia hết cho 2. Mệnh đề 2 đúng vì số nguyên tố lớn hơn 1. Mệnh đề 3 đúng vì \( n = 2 \implies n^2 = 4 \) chẵn. Mệnh đề 4 sai vì 4 chẵn nhưng không phải số nguyên tố.',
            ],
            [
                'content'       => 'Chọn các mệnh đề đúng về hình học phẳng.',
                'type'          => 'MULTIPLE_CHOICE',
                'answers'       => [
                    ['content' => "Tổng các góc trong tam giác bằng 180 độ", 'is_correct' => true],
                    ['content' => "Mọi hình thoi đều có bốn cạnh bằng nhau", 'is_correct' => true],
                    ['content' => "Mọi hình vuông đều là hình chữ nhật", 'is_correct' => true],
                    ['content' => "Mọi hình chữ nhật đều là hình vuông", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => 'Tổng góc tam giác là 180°. Hình thoi có bốn cạnh bằng nhau. Hình vuông là hình chữ nhật đặc biệt. Không phải hình chữ nhật nào cũng là hình vuông.',
            ],
            [
                'content'       => 'Cho \( P \): "Tôi đi học", \( Q \): "Tôi làm bài tập", \( R \): "Tôi thi đậu". Khi \( P \) đúng, \( Q \) sai, \( R \) đúng, chọn các mệnh đề đúng.',
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
            [
                'content'       => 'Chọn các mệnh đề đúng về tập hợp.',
                'type'          => 'MULTIPLE_CHOICE',
                'answers'       => [
                    ['content' => "Tập rỗng là tập con của mọi tập hợp", 'is_correct' => true],
                    ['content' => "Mọi tập hợp là tập con của chính nó", 'is_correct' => true],
                    ['content' => "\( \{1, 2\} \subset \{1, 2, 3\} \)", 'is_correct' => true],
                    ['content' => "Tập hợp số tự nhiên có số phần tử hữu hạn", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => 'Tập rỗng và tập hợp là tập con của chính nó. \( \{1, 2\} \subset \{1, 2, 3\} \). Tập số tự nhiên có vô số phần tử.',
            ],
            [
                'content'       => 'Chọn các mệnh đề đúng về logic.',
                'type'          => 'MULTIPLE_CHOICE',
                'answers'       => [
                    ['content' => "\( P \implies Q = \neg P \lor Q \)", 'is_correct' => true],
                    ['content' => "\( \neg (P \land Q) = \neg P \lor \neg Q \)", 'is_correct' => true],
                    ['content' => "\( P \lor Q = Q \lor P \)", 'is_correct' => true],
                    ['content' => "\( P \land Q = \neg P \land \neg Q \)", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => 'Mệnh đề 1, 2, 3 đúng theo luật logic. Mệnh đề 4 sai vì không tương đương.',
            ],
            [
                'content'       => 'Chọn các mệnh đề đúng về số nguyên tố.',
                'type'          => 'MULTIPLE_CHOICE',
                'answers'       => [
                    ['content' => "2 là số nguyên tố", 'is_correct' => true],
                    ['content' => "Mọi số nguyên tố lớn hơn 2 đều lẻ", 'is_correct' => true],
                    ['content' => "Số 1 là số nguyên tố", 'is_correct' => false],
                    ['content' => "Mọi số lẻ đều là số nguyên tố", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '2 là số nguyên tố chẵn. Số nguyên tố lớn hơn 2 đều lẻ. 1 không phải số nguyên tố. Không phải số lẻ nào cũng là số nguyên tố (ví dụ: 9).',
            ],
            [
                'content'       => 'Chọn các mệnh đề đúng khi \( A \): "Trời nắng", \( B \): "Tôi đi dạo", \( C \): "Tôi vui vẻ", và \( A \) sai, \( B \) đúng, \( C \) sai.',
                'type'          => 'MULTIPLE_CHOICE',
                'answers'       => [
                    ['content' => "\( \neg A \)", 'is_correct' => true],
                    ['content' => "\( B \lor C \)", 'is_correct' => true],
                    ['content' => "\( A \land B \)", 'is_correct' => false],
                    ['content' => "\( C \implies B \)", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => '\( A = \text{false}, B = \text{true}, C = \text{false} \): \( \neg A = \text{true}, B \lor C = \text{true}, A \land B = \text{false}, C \implies B = \text{true} \).',
            ],
            [
                'content'       => 'Chọn các mệnh đề đúng về hình học.',
                'type'          => 'MULTIPLE_CHOICE',
                'answers'       => [
                    ['content' => "Mọi hình vuông đều là hình thoi", 'is_correct' => true],
                    ['content' => "Có hình thoi không phải hình vuông", 'is_correct' => true],
                    ['content' => "Mọi hình thoi đều là hình vuông", 'is_correct' => false],
                    ['content' => "Mọi hình chữ nhật đều có bốn góc vuông", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => 'Hình vuông là hình thoi đặc biệt. Có hình thoi không phải hình vuông. Hình chữ nhật có bốn góc vuông.',
            ],

            // TRUE_FALSE Questions (8 questions)
            [
                'content'       => 'Mệnh đề: "Nếu \( x \) là số thực dương thì \( x^2 > 0 \)" có đúng không?',
                'type'          => 'TRUE_FALSE',
                'answers'       => [
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Sai", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => 'Bình phương của số thực dương luôn dương.',
            ],
            [
                'content'       => 'Mệnh đề: "Nếu \( n \) là số nguyên chẵn thì \( n^2 \) là số lẻ" có đúng không?',
                'type'          => 'TRUE_FALSE',
                'answers'       => [
                    ['content' => "Sai", 'is_correct' => true],
                    ['content' => "Đúng", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => 'Số chẵn bình phương cho số chẵn (ví dụ: \( 2^2 = 4 \)).',
            ],
            [
                'content'       => 'Mệnh đề: "Mọi số thực \( x \) đều thỏa mãn \( x^2 + 1 \geq 1 \)" có đúng không?',
                'type'          => 'TRUE_FALSE',
                'answers'       => [
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Sai", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( x^2 \geq 0 \implies x^2 + 1 \geq 1 \) với mọi \( x \) thực.',
            ],
            [
                'content'       => 'Mệnh đề: "Nếu một số chia hết cho 8 thì nó chia hết cho 4" có đúng không?',
                'type'          => 'TRUE_FALSE',
                'answers'       => [
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Sai", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => 'Số chia hết cho 8 thì chia hết cho 4 vì 8 chia hết cho 4.',
            ],
            [
                'content'       => 'Mệnh đề: "Có số thực \( x \) sao cho \( x^2 = -1 \)" có đúng không?',
                'type'          => 'TRUE_FALSE',
                'answers'       => [
                    ['content' => "Sai", 'is_correct' => true],
                    ['content' => "Đúng", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => 'Không có số thực \( x \) nào thỏa \( x^2 = -1 \) vì bình phương số thực luôn không âm.',
            ],
            [
                'content'       => 'Mệnh đề: "Mọi số nguyên \( n \) đều thỏa mãn \( n + 5 > n \)" có đúng không?',
                'type'          => 'TRUE_FALSE',
                'answers'       => [
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Sai", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => 'Với mọi \( n \), \( n + 5 > n \) vì \( 5 > 0 \).',
            ],
            [
                'content'       => 'Mệnh đề: "Nếu \( x^2 = 9 \), thì \( x = 3 \)" có đúng không?',
                'type'          => 'TRUE_FALSE',
                'answers'       => [
                    ['content' => "Sai", 'is_correct' => true],
                    ['content' => "Đúng", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( x^2 = 9 \implies x = 3 \) hoặc \( x = -3 \), nên mệnh đề sai vì không xét \( x = -3 \).',
            ],
            [
                'content'       => 'Mệnh đề: "Tập rỗng là tập con của mọi tập hợp" có đúng không?',
                'type'          => 'TRUE_FALSE',
                'answers'       => [
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Sai", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => 'Tập rỗng là tập con của mọi tập hợp theo định nghĩa tập hợp.',
            ],

            // DRAG_DROP Questions (8 questions)
            [
                'content'       => 'Cho \( A \): "Tôi đi học", \( B \): "Tôi mang sách". Giá trị của \( A \implies B \) khi \( A \) sai và \( B \) đúng là <-Drag->.',
                'type'          => 'DRAG_DROP',
                'answers'       => [
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Sai", 'is_correct' => false],
                    ['content' => "Không xác định", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( A = \text{false}, B = \text{true} \): \( A \implies B = \neg A \lor B = \text{true} \lor \text{true} = \text{true} \).',
            ],
            [
                'content'       => 'Cho \( C \): "Trời mưa", \( D \): "Tôi ở nhà". Giá trị của \( \neg (C \land D) \) khi \( C \) đúng và \( D \) sai là <-Drag->.',
                'type'          => 'DRAG_DROP',
                'answers'       => [
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Sai", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( C = \text{true}, D = \text{false} \): \( C \land D = \text{false}, \neg (C \land D) = \text{true} \).',
            ],
            [
                'content'       => 'Cho \( E \): "Tôi học toán", \( F \): "Tôi hiểu bài". Giá trị của \( E \iff F \) khi \( E \) đúng và \( F \) sai là <-Drag->.',
                'type'          => 'DRAG_DROP',
                'answers'       => [
                    ['content' => "Sai", 'is_correct' => true],
                    ['content' => "Đúng", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( E \iff F = (E \implies F) \land (F \implies E) \). Với \( E = \text{true}, F = \text{false} \): \( E \implies F = \text{false} \), nên \( E \iff F = \text{false} \).',
            ],
            [
                'content'       => 'Cho \( G \): "Hôm nay là thứ Hai", \( H \): "Tôi làm việc". Nếu \( G \land H \) sai và \( G \) đúng, thì \( H \) là <-Drag->.',
                'type'          => 'DRAG_DROP',
                'answers'       => [
                    ['content' => "Sai", 'is_correct' => true],
                    ['content' => "Đúng", 'is_correct' => false],
                    ['content' => "Không xác định", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( G \land H = \text{false}, G = \text{true} \implies H = \text{false} \).',
            ],
            [
                'content'       => 'Cho \( I \): "Tôi đi ngủ sớm", \( J \): "Tôi thức dậy sớm". Giá trị của \( (I \lor J) \land \neg I \) khi \( I \) sai và \( J \) đúng là <-Drag->.',
                'type'          => 'DRAG_DROP',
                'answers'       => [
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Sai", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( I = \text{false}, J = \text{true} \): \( (I \lor J) \land \neg I = (\text{false} \lor \text{true}) \land \text{true} = \text{true} \land \text{true} = \text{true} \).',
            ],
            [
                'content'       => 'Cho \( K \): "Tôi tập thể dục", \( L \): "Tôi khỏe mạnh". Giá trị của \( K \lor L \) khi \( K \) sai và \( L \) đúng là <-Drag->.',
                'type'          => 'DRAG_DROP',
                'answers'       => [
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Sai", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( K = \text{false}, L = \text{true} \): \( K \lor L = \text{false} \lor \text{true} = \text{true} \).',
            ],
            [
                'content'       => 'Cho \( M \): "Hôm nay trời đẹp", \( N \): "Tôi đi dạo". Khi \( M \) đúng, \( N \) sai, thì \( M \land N \) là <-Drag->.',
                'type'          => 'DRAG_DROP',
                'answers'       => [
                    ['content' => "Sai", 'is_correct' => true],
                    ['content' => "Đúng", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( M = \text{true}, N = \text{false} \): \( M \land N = \text{true} \land \text{false} = \text{false} \).',
            ],
            [
                'content'       => 'Cho \( O \): "Tôi ăn sáng", \( P \): "Tôi no bụng". Nếu \( O \lor P \) đúng và \( O \) sai, thì \( P \) là <-Drag->.',
                'type'          => 'DRAG_DROP',
                'answers'       => [
                    ['content' => "Đúng", 'is_correct' => true],
                    ['content' => "Sai", 'is_correct' => false],
                    ['content' => "Không xác định", 'is_correct' => false],
                ],
                'marks'       => 0.25,
                'explanation' => '\( O \lor P = \text{true}, O = \text{false} \implies P = \text{true} \).',
            ],

            // NUMERIC_INPUT Questions (8 questions)
            [
                'content'       => 'Cho \( x \) là số thực thỏa mãn \( x + 3 = 7 \). Giá trị của \( x \) là bao nhiêu?',
                'type'          => 'NUMERIC_INPUT',
                'answers'       => [
                    ['content' => "4", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => '\( x + 3 = 7 \implies x = 7 - 3 = 4 \).',
            ],
            [
                'content'       => 'Tổng các góc trong một tam giác là bao nhiêu độ?',
                'type'          => 'NUMERIC_INPUT',
                'answers'       => [
                    ['content' => "180", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => 'Tổng các góc trong tam giác luôn bằng 180 độ.',
            ],
            [
                'content'       => 'Cho \( n \) là số nguyên thỏa mãn \( 2n = 10 \). Giá trị của \( n \) là bao nhiêu?',
                'type'          => 'NUMERIC_INPUT',
                'answers'       => [
                    ['content' => "5", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => '\( 2n = 10 \implies n = 10 / 2 = 5 \).',
            ],
            [
                'content'       => 'Số cạnh của một hình vuông là bao nhiêu?',
                'type'          => 'NUMERIC_INPUT',
                'answers'       => [
                    ['content' => "4", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => 'Hình vuông có 4 cạnh.',
            ],
            [
                'content'       => 'Giá trị của \( x \) thỏa mãn \( x^2 = 16 \) và \( x > 0 \) là bao nhiêu?',
                'type'          => 'NUMERIC_INPUT',
                'answers'       => [
                    ['content' => "4", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => '\( x^2 = 16 \implies x = 4 \) hoặc \( x = -4 \). Vì \( x > 0 \), nên \( x = 4 \).',
            ],
            [
                'content'       => 'Số nguyên tố nhỏ nhất là bao nhiêu?',
                'type'          => 'NUMERIC_INPUT',
                'answers'       => [
                    ['content' => "2", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => 'Số nguyên tố nhỏ nhất là 2.',
            ],
            [
                'content'       => 'Cho \( y \) thỏa mãn \( 3y - 6 = 9 \). Giá trị của \( y \) là bao nhiêu?',
                'type'          => 'NUMERIC_INPUT',
                'answers'       => [
                    ['content' => "5", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => '\( 3y - 6 = 9 \implies 3y = 15 \implies y = 5 \).',
            ],
            [
                'content'       => 'Số góc nhọn tối đa trong một tam giác là bao nhiêu?',
                'type'          => 'NUMERIC_INPUT',
                'answers'       => [
                    ['content' => "3", 'is_correct' => true],
                ],
                'marks'       => 0.25,
                'explanation' => 'Một tam giác có thể có tối đa 3 góc nhọn (tam giác nhọn).',
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
