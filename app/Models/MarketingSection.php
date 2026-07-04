<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketingSection extends Model
{
    //
    protected $table = 'create_marketing_sections';
    protected $guarded = [];
    protected $casts = [
        'problems_list' => 'array',
        'benefits_list' => 'array',
    ];
}
