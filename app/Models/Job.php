<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $table = "job";
    public $incrementing = false;

    public function job_category(){
        return $this->belongsTo(Job_category::class);
    }

    public function material_of_job(){
        return $this->hasMany(Material_of_job::class);
    }
}
