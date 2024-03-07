<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_material_category extends Model
{
    use HasFactory;
    protected $table = "sub_material_category";
    public $incrementing = false;

    protected $fillable = ['sub_material', 'id'];
}
