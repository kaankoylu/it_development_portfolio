<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    // Tell the model exactly which table to use
    protected $table = 'course_progress';

    protected $fillable = [
        'course_name',
        'credits_ec',
        'status',
        'grade'
    ];
}
