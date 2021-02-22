<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sales';

    protected $fillable = [
        "name",
        "piece_id",
        "user_id",
        "price"
    ];

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function pieces(){
        return $this->hasOne(Piece::class,'piece_id');
    }

    use HasFactory;
}
