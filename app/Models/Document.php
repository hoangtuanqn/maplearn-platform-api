<?php

namespace App\Models;

use App\Observers\DocumentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([DocumentObserver::class])]
class Document extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'download_count',
        'source',
        'created_by',
        'category_id',
        'subject_id',
        'grade_level_id',
        'status',
    ];

    // Nó chỉ ẩn khi output, k ảnh hưởng khi dùng code trong PHP

    // 'category' => khi cần thi thêm vô appends
    protected $appends = ['creator',  'subject', 'grade_level']; // tự động thêm vào JSON

    protected $hidden = [
        // 'category_id',
        'grade_level_id',
        'subject_id',
        'created_by',
        'deleted_at',
        'updated_at',
    ];

    protected $casts = [
        'download_count' => 'integer',
        'status' => 'boolean',
    ];

    // getRouteKeyName là phương thức để xác định trường nào sẽ được sử dụng làm khóa định tuyến
    // Mặc định Laravel sẽ dùng 'id', nhưng nếu bạn muốn dùng 'slug'
    // thì bạn cần định nghĩa lại phương thức này trong model của bạn.
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(DocumentCategory::class, 'category_id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class, 'grade_level_id');
    }


    // Lấy thông tin người tạo
    public function getCreatorAttribute()
    {
        return $this->creator()->select('id', 'full_name')->first();
    }

    // Lấy thông tin category
    public function getCategoryAttribute()
    {
        return $this->category()->select('id', 'name')->first();
    }
    // Lấy thông tin subject
    public function getSubjectAttribute()
    {
        return $this->subject()->select('slug')->first()->slug;
    }
    // Lấy thông tin grade level
    public function getGradeLevelAttribute()
    {
        return $this->gradeLevel()->select('slug')->first()->slug;
    }

    // Scope lấy document active
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
