<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job_on_project extends Model
{
    use HasFactory;
    protected $table = 'job_on_project';
    public $incrementing = false;
}
