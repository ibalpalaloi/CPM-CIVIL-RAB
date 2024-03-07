<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material_of_job extends Model
{
    use HasFactory;
    protected $table = "material_of_job";
    public $incrementing = false;

    public function material(){
        return $this->belongsTo(Material::class)->withDefault([
            'price'=>0
        ]);
    }

    public function job(){
        return $this->belongsTo(Job::class);
    }
}
