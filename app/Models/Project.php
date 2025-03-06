<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $fillable = [
        'title',
        'description',
        'url',
        'github_url',
        'image',
    ];
}
