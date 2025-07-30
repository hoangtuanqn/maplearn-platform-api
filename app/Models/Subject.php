<?php

namespace App\Models;

use App\Observers\SubjectObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([SubjectObserver::class])]
class Subject extends Model
{
    /** @use HasFactory<\Database\Factories\SubjectFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'status',
    ];

    // Không hiển thị các cột này khi in ra danh sách
    protected $hidden = [
        'deleted_at'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
