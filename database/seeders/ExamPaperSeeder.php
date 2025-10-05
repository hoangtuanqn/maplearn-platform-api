<?php

namespace Database\Seeders;

use App\Models\ExamPaper;
use App\Models\User;
use App\Services\GoogleAuthenService;
use Illuminate\Database\Seeder;

class ExamPaperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjectsForName = [
            'Toán' => 'toan',
            'Vật Lý' => 'ly',
            'Hóa Học' => 'hoa',
            'Sinh Học' => 'sinh',
            'Tiếng Anh' => 'tieng-anh',
            'Ngữ Văn' => 'van'
        ];

        // Định nghĩa loại đề thi và category tương ứng
        $examTypes = [
            // 'HSA','V-ACT','TSA','THPT','OTHER'
            'minh_hoa' => ['exam_type' => 'THPT', 'exam_category' => 'tot-nghiep-thpt', 'name' => 'Đề minh hoạ'],
            'khao_sat' => ['exam_type' => 'V-ACT', 'exam_category' => 'dgnl-v-act', 'name' => 'Đề khảo sát'],
            'thi_thu' => ['exam_type' => 'THPT', 'exam_category' => 'tot-nghiep-thpt', 'name' => 'Đề thi thử'],
            'on_tap' => ['exam_type' => 'OTHER', 'exam_category' => 'thi-cuoi-ki-1', 'name' => 'Đề ôn tập'],
            'dgnl_hsa' => ['exam_type' => 'HSA', 'exam_category' => 'dgnl-hsa', 'name' => 'Đề ĐGNL HSA'],
            'dgnl_vact' => ['exam_type' => 'V-ACT', 'exam_category' => 'dgnl-v-act', 'name' => 'Đề ĐGNL V-ACT'],
            'dgtd_tsa' => ['exam_type' => 'TSA', 'exam_category' => 'dgtd-tsa', 'name' => 'Đề ĐGTD TSA'],
            'tot_nghiep_thpt' => ['exam_type' => 'THPT', 'exam_category' => 'tot-nghiep-thpt', 'name' => 'Đề tốt nghiệp THPT'],
            'thi_cuoi_ki_1' => ['exam_type' => 'THPT', 'exam_category' => 'thi-cuoi-ki-1', 'name' => 'Đề cuối kì 1'],
            'thi_cuoi_ki_2' => ['exam_type' => 'THPT', 'exam_category' => 'thi-cuoi-ki-2', 'name' => 'Đề cuối kì 2'],
            'thi_giua_ki_1' => ['exam_type' => 'THPT', 'exam_category' => 'thi-giua-ki-1', 'name' => 'Đề giữa kì 1'],
            'thi_giua_ki_2' => ['exam_type' => 'THPT', 'exam_category' => 'thi-giua-ki-2', 'name' => 'Đề giữa kì 2'],
        ];

        $years = [2023, 2024, 2025];
        $schools = [
            'THPT Nguyễn Khuyến',
            'THPT Lê Quý Đôn',
            'THPT Trần Phú',
            'THPT Chuyên Hà Nội',
            'THPT Quốc Học Huế',
            'THPT Bùi Thị Xuân',
            'THPT Phan Đình Phùng',
            'THPT Gia Định',
            'THPT Lương Thế Vinh',
            'THPT Nguyễn Thị Minh Khai',
            'THPT Trần Quang Diệu',
        ];

        // Sinh thêm đề thi ngẫu nhiên cho đủ 81 đề
        for ($i = 1; $i <= 1000; $i++) {
            // Random dữ liệu cho đề thi mới
            $subjectName = array_rand($subjectsForName);
            $subject = $subjectsForName[$subjectName];
            $examTypeKey = array_rand($examTypes);
            $examType = $examTypes[$examTypeKey];

            $type = $examTypeKey; // Kiểu đề thi (minh_hoa, khao_sat, thi_thu...)
            $year = $years[array_rand($years)];
            $school = $schools[array_rand($schools)];

            // Tạo tên đề thi dựa trên kiểu đề và môn học
            $examTitle = $this->generateExamTitle($type, $examType['name'], $subjectName, $year, $i, $school);

            $teacherId = User::where('role', 'teacher')->pluck('id')->random();

            // Tạo exam paper với thông tin đầy đủ và đúng category
            ExamPaper::create([
                'title'                     => $examTitle,
                'user_id'                   => $teacherId,
                'max_score'                 => 10,
                'duration_minutes'          => 120,
                'exam_category'             => $examType['exam_category'],
                'subject'                   => $subject,
                'grade_level'               => collect(['dg-td', 'dg-nl', 'lop-12', 'lop-11', 'lop-10'])->random(), // Giả sử lớp 12
                'difficulty'                => collect(['easy', 'normal', 'hard', 'very_hard'])->random(),
                'province'                  => collect(['Quảng Ngãi', 'Phú Thọ', 'Thành phố Hà Nội', 'Thành phố Hồ Chí Minh'])->random(),
                'exam_type'                 => $examType['exam_type'],
                'status'                    => true,
                'anti_cheat_enabled'        => true,
                'max_attempts'              => 3,
                'start_time'                => now()->subDays(rand(0, 365)),
                'password'                  => null,
                'created_at'                => now()->subDays(rand(0, 365)),
            ]);
        }
    }

    /**
     * Generate exam title based on type, subject, number, and school
     */
    private function generateExamTitle($type, $title, $subjectName, $year, $examNumber, $school)
    {
        // Định nghĩa các template tên đề thi dựa trên loại đề thi
        $templates = [
            'minh_hoa' => "{$title} môn {$subjectName} - Đề số {$examNumber} (Trích trong Sách 30 đề minh hoạ môn {$subjectName} {$year})",
            'khao_sat' => "{$title} môn {$subjectName} - Đề số {$examNumber} (Kỳ thi {$subjectName} {$year})",
            'thi_thu' => "{$title} môn {$subjectName} - Đề số {$examNumber} (Trường {$school} - Kỳ thi thử {$year})",
            'on_tap' => "{$title} môn {$subjectName} - Đề số {$examNumber} (Ôn tập {$subjectName} {$year})",
            'dgnl_hsa' => "Đề ĐGNL HSA môn {$subjectName} - Đề số {$examNumber} (Kỳ thi ĐGNL HSA {$year})",
            'dgnl_vact' => "Đề ĐGNL V-ACT môn {$subjectName} - Đề số {$examNumber} (Kỳ thi ĐGNL V-ACT {$year})",
            'dgtd_tsa' => "Đề ĐGTD TSA môn {$subjectName} - Đề số {$examNumber} (Kỳ thi ĐGTD TSA {$year})",
            'tot_nghiep_thpt' => "{$title} môn {$subjectName} - Đề số {$examNumber} (Kỳ thi tốt nghiệp THPT {$year})",
            'thi_cuoi_ki_1' => "{$title} môn {$subjectName} - Đề số {$examNumber} (Thi cuối kì 1 năm {$year})",
            'thi_cuoi_ki_2' => "{$title} môn {$subjectName} - Đề số {$examNumber} (Thi cuối kì 2 năm {$year})",
            'thi_giua_ki_1' => "{$title} môn {$subjectName} - Đề số {$examNumber} (Thi giữa kì 1 năm {$year})",
            'thi_giua_ki_2' => "{$title} môn {$subjectName} - Đề số {$examNumber} (Thi giữa kì 2 năm {$year})",
        ];

        // Chọn template dựa trên loại đề thi
        return $templates[$type] ?? "{$type} môn {$subjectName} - Đề số {$examNumber}";
    }
}
