<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionCourseMapping extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'subscription_id', 'course_id',
    ];
}
