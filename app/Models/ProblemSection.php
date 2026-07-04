<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProblemSection extends Model
{
    //
    protected $guarded = [];

    protected $casts = [
        'good_points'         => 'array',
        'bad_points'          => 'array',
        'wondering_questions' => 'array',
    ];
}
