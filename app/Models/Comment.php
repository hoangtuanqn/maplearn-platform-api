<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'type',
        'type_id',
        'description',
        'reply_id',
    ];
    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];
    protected $appends = ['creator']; // tự động thêm vào JSON

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 👇 Tạo accessor cho JSON export
    public function getCreatorAttribute()
    {
        return $this->creator()->first();
    }

    // Hiển thị thời gian dạng 1 phút trước, 2 giờ trước, ....
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }
    public function replies()
    {
        return $this->hasMany(Comment::class, 'reply_id');
    }
}
