<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material_category extends Model
{
    use HasFactory;
    protected $table = "material_category";
    public $incrementing = false;

    protected $fillable = ['material_category', 'id'];
}
