<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomRequestAttachment extends Model
{
    protected $fillable = [
        'custom_request_id',
        'file_path',
        'file_type',
    ];

    public function customRequest()
    {
        return $this->belongsTo(Custom_request::class);
    }
}