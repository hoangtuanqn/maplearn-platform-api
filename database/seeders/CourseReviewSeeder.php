<?php

namespace Database\Seeders;

use App\Models\CourseReview;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comments = ['Khóa học này chất lượng quá, học sinh mất gốc vẫn học được',  'Giảng viên giảng dạy rất nhiệt tình, dễ hiểu', 'Nội dung khóa học rất đầy đủ và chi tiết', 'Tôi đã học được rất nhiều kiến thức bổ ích từ khóa học này', 'Khóa học này thực sự giúp tôi nâng cao kỹ năng của mình', 'Rất hài lòng với chất lượng giảng dạy của khóa học', 'Tôi đã áp dụng được nhiều kiến thức từ khóa học vào công việc thực tế', 'Khóa học này rất phù hợp với những người mới bắt đầu', 'Tôi cảm thấy tự tin hơn khi làm việc trong lĩnh vực này sau khi hoàn thành khóa học', 'Khóa học này thực sự đáng giá với số tiền bỏ ra', 'Giảng viên rất chuyên nghiệp và có kinh nghiệm thực tế', 'Tôi đã tìm thấy nhiều giải pháp hữu ích cho công việc của mình trong khóa học này', 'Khóa học này giúp tôi hiểu rõ hơn về các khái niệm cơ bản trong lĩnh vực này', 'Tôi rất ấn tượng với cách giảng dạy của giảng viên', 'Khóa học này đã giúp tôi cải thiện kỹ năng lập trình của mình', 'Tôi cảm thấy hài lòng với sự hỗ trợ từ giảng viên trong quá trình học', 'Khóa học này thực sự giúp tôi tự tin hơn khi tham gia phỏng vấn xin việc', 'Tôi đã áp dụng được nhiều kiến thức từ khóa học vào dự án cá nhân của mình', 'Khóa học này rất hữu ích cho những người muốn nâng cao kỹ năng của mình', 'Tôi đã học được nhiều mẹo và thủ thuật từ khóa học này', 'Khóa học này giúp tôi hiểu rõ hơn về cách làm việc trong ngành công nghiệp này', 'Tôi cảm thấy hài lòng với chất lượng video và tài liệu trong khóa học', 'Khóa học này thực sự giúp tôi phát triển bản thân và sự nghiệp của mình', 'Tôi đã tìm thấy nhiều nguồn tài nguyên hữu ích từ khóa học này', 'Khóa học này giúp tôi có cái nhìn tổng quan về lĩnh vực này', 'Tôi cảm thấy tự tin hơn khi tham gia các dự án thực tế sau khi hoàn thành khóa học'];
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 200; $i++) {
            CourseReview::create([
                'course_id' => rand(1, 81),
                'user_id' => rand(1, 18),
                'rating' =>  rand(4, 5),
                'comment' => $faker->randomElement($comments),
            ]);
        }
    }
}
