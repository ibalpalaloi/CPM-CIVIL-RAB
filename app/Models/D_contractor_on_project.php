<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class D_contractor_on_project extends Model
{
    use HasFactory;
    protected $table = 'd_contractor_on_project';
    public $incrementing = false;

    public function contractor(){
        return $this->belongsTo(Contractor::class);
    }
}
