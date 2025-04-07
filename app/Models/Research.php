<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
    use HasFactory;
    protected $table = 'researches';

    protected $fillable = [
        'title', 'course', 'researchers', 'adviser', 'year', 
        'abstract', 'keywords', 'program', 'category', 
        'research_design', 'research_type', 'respondents_count',
        'file_path'
    ];
}