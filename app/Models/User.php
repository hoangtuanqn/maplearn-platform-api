<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

// Implement JWTSubject để sử dụng các phương thức được cấp
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     *  Trả về dạng boolean: Check quyền admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     *  Trả về dạng boolean: Check quyền teacher
     */
    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    /**
     *  Trả về dạng boolean: Check quyền student
     */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }


    /**
     * Trả về id của user để đưa vào token
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();  // thường là id
    }

    /**
     * Các claim (payload) bổ sung (nếu cần)
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'password',
        'full_name',
        'email',
        'phone_number',
        'gender',
        'avatar',
        'birth_year',
        'facebook_link',
        'school',
        'city',
        'role',
        'google_id',
        'facebook_id',
        'banned',
        'google2fa_secret',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'google_id',
        'facebook_id',
        'google2fa_secret',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'email_verified_at' => 'datetime',
        'current_balance' => 'decimal:2',
        'total_deposit' => 'decimal:2',
        'banned' => 'boolean',
        'birth_year' => 'integer',
    ];

    // Cấu hình gửi Email
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }


    // Lấy danh sách documents người này đã upload
    public function createdDocuments()
    {
        return $this->hasMany(Document::class, 'created_by');
    }

    // Lấy danh sách documents người này đã upload
    public function createdPosts()
    {
        return $this->hasMany(Post::class, 'created_by');
    }
}
