<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enroll extends Model
{
    use HasFactory;
    protected $table = 'enrolls';
    protected $primaryKey = 'id';
    protected $fillable = [
        'image',
        'post_id',
        'user_id',
        'stage_id',
        'remark'
    ];

    public function stage(){
        return $this->belongsTo(Stage::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

   
}
