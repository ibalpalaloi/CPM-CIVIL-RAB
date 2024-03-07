<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job_category extends Model
{
    use HasFactory;
    protected $table = "job_category";
    public $incrementing = false;
}
