<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'materials';

    protected $fillable = [
        "name",
        "type_material",
        "temperature",
        "toxic"
    ];


    //La relacion de muchos
    public function pieces() {
        return $this->belongsToMany(Piece::class, "material_piece","material_id","piece_id");
    }

    

    use HasFactory;
}
