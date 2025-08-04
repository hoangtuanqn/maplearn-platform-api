<?php

namespace App\Models;

use App\Observers\CourseObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

#[ObservedBy([CourseObserver::class])]
class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'thumbnail',
        'intro_video',
        'price',
        'grade_level_id',
        'subject_id',
        'category_id',
        'department_id',
        'start_date',
        'end_date',
        'status',
    ];
    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];
    // Nhớ đi qua middleware auth.optional.jwt để lấy được user đang đăng nhập
    protected $appends = ['department', 'subject', 'category', 'grade_level', 'rating', 'is_favorite', 'is_cart', 'is_enrolled']; // tự động thêm vào JSON
    protected $casts = [
        'price' => 'double',

        'status' => 'boolean',
    ];
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function courseCategory()
    {
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    // public function audience()
    // {
    //     return $this->belongTo(Audience::class);
    // }
    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function getDepartmentAttribute()
    {
        return $this->department()->select('id', 'name')->get();
    }
    public function getSubjectAttribute()
    {
        return $this->subject()->select('id', 'name')->get();
    }

    public function getCategoryAttribute()
    {
        return $this->courseCategory()->select('id', 'name')->get();
    }
    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class, 'grade_level_id');
    }

    // Lấy thông tin grade level
    public function getGradeLevelAttribute()
    {
        return $this->gradeLevel()->select('slug')->first()?->slug;
        // return null;
    }

    // Lấy danh sách giáo viên đang dạy
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'course_teacher');
    }

    // Reviews
    public function reviews()
    {
        return $this->hasMany(CourseReview::class, 'course_id');
    }
    // Tính điểm đánh giá trung bình
    public function getRatingAttribute()
    {
        return [
            'average_rating' => round($this->reviews()->avg('rating'), 1),
            'total_reviews' => $this->reviews()->count(),
        ]; // Làm tròn 1 chữ số sau dấu phẩy
    }

    // Tính số lượng học viên đã đăng ký khóa học
    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class);
    }
    // Lấy danh sách học viên đã đăng ký khóa học
    public function students()
    {
        return $this->belongsToMany(User::class, 'course_enrollments', 'course_id', 'user_id');
    }

    public function getStudentCountAttribute()
    {
        return $this->enrollments()->count();
    }

    // Danh sách chương học, sort theo vị trí
    public function chapters()
    {
        return $this->hasMany(CourseChapter::class, 'course_id')->orderBy('position');
    }

    // Check khóa học có dc yêu thích bởi người dùng đang gửi request lấy data hay k ?
    public function getIsFavoriteAttribute()
    {
        $user = Auth::user();
        // Nếu chưa đăng nhập, trả về false
        if (!$user) {
            return false;
        }
        return $user->favoriteCourses->contains($this->id);
    }

    // Check khóa học có dc thêm vô giỏ hàng bởi người dùng đang gửi request lấy data hay k ?
    public function getIsCartAttribute()
    {
        $user = Auth::user();
        // Nếu chưa đăng nhập, trả về false
        if (!$user) {
            return false;
        }
        return $user->cartItems->contains('course_id', $this->id);
    }
    // Check khóa học có dc mua bởi người dùng đang gửi request lấy data hay k ?
    public function getIsEnrolledAttribute()
    {
        $user = Auth::user();
        // Nếu chưa đăng nhập, trả về false
        if (!$user) {
            return false;
        }
        return $user->purchasedCourses->contains($this->id);
    }
}
