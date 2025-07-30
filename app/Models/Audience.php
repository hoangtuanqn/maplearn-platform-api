<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audience extends Model
{
    /** @use HasFactory<\Database\Factories\AudienceFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'status',
    ];

    protected $hidden = [
        'created_by',
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
