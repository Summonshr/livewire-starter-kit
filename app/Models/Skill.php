<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'group',
        'group_rank',
        'skill',
        'skill_rank',
        'description',
        'level',
    ];

    public $timestamps = false;
}
