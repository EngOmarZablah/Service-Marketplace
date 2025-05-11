<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Custom_request extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'location',
        'budget',
        'status'
    ];
    
}