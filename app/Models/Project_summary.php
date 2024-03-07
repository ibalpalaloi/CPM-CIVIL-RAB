<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project_summary extends Model
{
    use HasFactory;
    protected $table = 'project_summary';
    public $incrementing = false;

    public function contractor(){
        return $this->hasOne(Contractor::class);
    }
}
