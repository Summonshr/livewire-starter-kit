<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    public $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'current' => 'boolean',
    ];

    public $fillable = [
        'title',
        'company',
        'position',
        'summary',
        'start_date',
        'end_date',
        'current',
    ];
}
