<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{

    /**
     * *Sử dụng quan hệ polymorphic: Quan hệ polymorphic (đa hình) trong Laravel là một dạng quan hệ đặc biệt cho phép một model có thể liên kết với nhiều model khác nhau chỉ qua một quan hệ duy nhất.
     * Bạn có một bảng comments, và muốn cho phép người dùng:
     * Bình luận vào bài viết (posts)
     * Bình luận vào video (videos)
     * Bình luận vào tài liệu (documents)
     * Nếu dùng quan hệ thông thường, bạn sẽ cần 3 cột: => Điều này rối và không tối ưu.
     */
    /** @use HasFactory<\Database\Factories\ReportFactory> */
    use HasFactory;
    protected $fillable = [
        'reported_by',
        'handled_by',
        'reportable_type',
        'reportable_id',
        'reason',
        'status',
        'message'
    ];
    public function reportable()
    {
        return $this->morphTo();
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }
}
//  Cách sử dụng
// $document = Document::find(5);

// $report = new Report([
//     'reason' => 'Nội dung sai chính tả',
//     'message' => 'Trang 1 có lỗi "đồng thơi"',
//     'reported_by' => auth()->id()
// ]);

// $report->reportable()->associate($document);
// $report->save();


// Cách lấy data
// $report = Report::find(1);

// echo $report->reportable; // sẽ là Document, Post hoặc Course
// echo $report->reporter->name;
// echo $report->handler?->name ?? 'Chưa xử lý';
