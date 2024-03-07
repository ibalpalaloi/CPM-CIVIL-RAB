<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    use HasFactory;
    protected $table = "material";
    public $incrementing = false;

    public function material_category(){
        return $this->belongsTo(Material_category::class)->withDefault([
            'material_category'=>'-',
            'id'=>'-'
        ]);
    }

    public function sub_material_category(){
        return $this->belongsTo(Sub_material_category::class)->withDefault([
            'sub_material'=>'-',
            'id'=>'-'
        ]);
    }
}
