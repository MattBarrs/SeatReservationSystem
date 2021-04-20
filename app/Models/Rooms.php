<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
//    use HasFactory;
    protected $casts = [
        'room_details' => 'array',
        'floor_plan',
        'room_canvas',
    ];
}
