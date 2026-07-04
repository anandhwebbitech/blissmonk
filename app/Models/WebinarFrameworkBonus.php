<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebinarFrameworkBonus extends Model
{
    //
    protected $table = 'webinar_framework_and_bonuses';
    protected $guarded = [];

    protected $casts = [
        'fw_list_items' => 'array',
        'perfect_items' => 'array',
        'not_perfect_items' => 'array',
        'bonuses_cards' => 'array',
        'risk_paragraphs' => 'array',
        'expire_items' => 'array',
    ];
}
