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
    protected $appends = ['final_price', 'department', 'subject', 'category', 'grade_level', 'rating', 'is_favorite', 'is_cart', 'is_enrolled', 'lesson_count', 'duration',  'is_best_seller']; // tự động thêm vào JSON
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


    // Danh sách chương học, sort theo vị trí
    public function chapters()
    {
        return $this->hasMany(CourseChapter::class, 'course_id')->orderBy('position');
    }

    public function courseDiscounts()
    {
        return $this->hasMany(CourseDiscount::class, 'course_id');
    }

    public function getLessonCountAttribute()
    {
        // Lấy tất cả chương có khóa học này
        $chapters = $this->chapters()->with('lessons')->get();

        // Duyệt tất cả chương, gộp lại toàn bộ lesson, rồi tính tổng thời lượng
        return $chapters->flatMap->lessons->count();
    }
    public function getDurationAttribute()
    {
        // Lấy tất cả chương có khóa học này
        $chapters = $this->chapters()->with('lessons')->get();

        // Duyệt tất cả chương, gộp lại toàn bộ lesson, rồi tính tổng thời lượng
        return $chapters->flatMap->lessons->sum('duration');
    }


    // Get số tiền sau khi áp dụng giảm giá (truyền số tiền gốc vào)
    public function getDiscountedPrice(float $originalPrice): float
    {
        // Lấy tất cả giảm giá đang hoạt động và còn hiệu lực
        $activeDiscounts = $this->courseDiscounts()
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->get();

        if ($activeDiscounts->isEmpty()) {
            return $originalPrice;
        }

        $minPrice = $originalPrice;

        foreach ($activeDiscounts as $discount) {
            $priceAfterDiscount = $discount->type === 'percentage'
                ? $originalPrice * (1 - $discount->value / 100)
                : max(0, $originalPrice - $discount->value);

            $minPrice = min($minPrice, $priceAfterDiscount);
        }

        return round($minPrice, 2);
    }

    // Lấy giá tiền sau khi áp dụng giảm giá (mã giảm giá cao nhất)
    public function getFinalPriceAttribute(): float
    {
        $originalPrice = $this->price;

        $activeDiscounts = $this->courseDiscounts()
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')->orWhere('end_date', '>=', now());
            })
            ->where(function ($query) {
                $query->whereColumn('usage_count', '<', 'usage_limit') // ✅ fix đúng
                    ->orWhere('usage_limit', '=', 0);
            })
            ->get();

        if ($activeDiscounts->isEmpty()) {
            return round($originalPrice, 2);
        }

        $minPrice = $originalPrice;

        foreach ($activeDiscounts as $discount) {
            $priceAfterDiscount = $discount->type === 'percentage'
                ? $originalPrice * (1 - $discount->value / 100)
                : max(0, $originalPrice - $discount->value);

            $minPrice = min($minPrice, $priceAfterDiscount);
        }

        return round($minPrice, 2);
    }

    // Liên kết v

    // Đánh dấu sản phẩm có bán chạy hay không (trong vòng 7 ngày mà bàn được > 100 sản phẩm thì bán chạy)
    public function getIsBestSellerAttribute(): bool
    {
        return $this->enrollments()
            ->where('created_at', '>=', now()->subDays(7))
            ->count() > 100;
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
