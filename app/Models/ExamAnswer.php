<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
    /** @use HasFactory<\Database\Factories\ExamAnswerFactory> */
    use HasFactory;
    //     $table->increments('id');
    //             // $table->foreignId('exam_question_id')->constrained('exam_questions')->cascadeOnDelete();
    //             $table->unsignedInteger('exam_question_id'); // ID của câu hỏi
    //             $table->text('content'); // Nội dung đáp án
    //             $table->boolean('is_correct')->default(false); // Câu trả lời này có đúng hay không. Nếu là dạng Đúng/Sai thì content ghi là: "Đúng" và is_correct = true
    //             $table->timestamps();

    //             $table->foreign('exam_question_id')->references('id')->on('exam_questions')->onDelete('cascade');
    protected $fillable = [
        'exam_question_id',
        'content',
        'is_correct',
    ];
    protected $hidden = ['created_at', 'updated_at', 'exam_question_id', 'is_correct'];

    public function question()
    {
        return $this->belongsTo(ExamQuestion::class);
    }
}
