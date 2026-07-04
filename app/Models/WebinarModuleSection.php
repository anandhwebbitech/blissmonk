<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebinarModuleSection extends Model
{
    //
    protected $table = 'webinar_modules_sections';
    protected $guarded = [];

    protected $casts = [
        'modules_data' => 'array'
    ];
}
