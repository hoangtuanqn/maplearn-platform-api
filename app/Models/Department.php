<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /** @use HasFactory<\Database\Factories\DepartmentFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'name' => 'string',
    ];

    // List giáo viên trong tổ
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class);
    }
}
