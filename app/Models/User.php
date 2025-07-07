<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable  implements JWTSubject
{
    use HasFactory, Notifiable;

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
        'current_balance',
        'total_deposit',
        'role',
        'banned',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
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
}
