<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FundedAccountSection extends Model
{
    protected $table = 'funded_account_sections';
    protected $guarded = [];

    // Cast the array values automatically to avoid manual json_encode/decode steps
    protected $casts = [
        'left_points' => 'array',
        'right_points' => 'array',
    ];
}
