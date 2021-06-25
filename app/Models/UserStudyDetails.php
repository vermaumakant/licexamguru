<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStudyDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'country_name','state_name', 'city_name','university_name'
    ];
}
