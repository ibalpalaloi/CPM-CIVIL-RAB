<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material_of_job_project extends Model
{
    use HasFactory;
    protected $table = "material_of_job_project";
    public $incrementing = false;

    public function job_on_project(){
        return $this->belongsTo(Job_on_project::class);
    }
}
