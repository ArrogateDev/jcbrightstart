<?php

namespace App\Models;

class Quiz extends Base
{
    protected $casts = [
        'questions' => 'array'
    ];

    protected $hidden = [
        'pivot'
    ];
}
