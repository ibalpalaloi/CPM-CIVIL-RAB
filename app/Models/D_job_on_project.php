<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class D_job_on_project extends Model
{
    use HasFactory;
    protected $table = 'd_job_on_project';
    public $incrementing = false;

    public function project_summary(){
        return $this->belongsTo(Project_summary::class);
    }

    public function job(){
        return $this->belongsTo(Job::class);
    }
}
