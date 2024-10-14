<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentScore extends Model
{
    use HasFactory;

    protected $table = 'student_scores';
    protected $primaryKey = 'id';
    protected $fillable = [
        'student_id',
        'subject',
        'score',
    ];

    public function student(){
        return $this->belongsTo(Student::class);
    }
}
