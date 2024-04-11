<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attcodegenerator extends Model
{
    use HasFactory;

    protected $table = "attcodegenerators";
    protected $primaryKey = "id";
    protected $fillable = [
        'classdate',
        'post_id',
        'attcode',
        'status_id',
        'user_id'
    ];

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function randomstringgenerator($length){

        $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $characterlengths = strlen($characters);

        $randomstring= '';

        for($i=0; $i < $length; $i++){
            $randomstring .= $characters[rand(0,$characterlengths-1)];
        }

        return $randomstring;
    }
}
