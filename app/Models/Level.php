<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    public function scopeCreateDefault($query, $field_id)
    {
        $data = [
            [
                "field_id" => $field_id,
                "level_name" => "Easy",
            ],
            [
                "field_id" => $field_id,
                "level_name" => "Moderate",
            ],
            [
                "field_id" => $field_id,
                "level_name" => "Hard",
            ],
        ];
        $query->insert($data);
    }
}
