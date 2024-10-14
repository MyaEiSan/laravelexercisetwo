<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Lead extends Model
{
    use HasFactory;

    protected $table = 'leads';
    protected $primaryKey = 'id';
    protected $fillable = [
        'leadnumber',
        'firstname',
        'lastname',
        'gender_id',
        'age',
        'email',
        'country_id',
        'city_id',
        'user_id',
        'converted',
        'student_id',
    ];

    public function gender(){
        return $this->belongsTo(Gender::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    protected static function boot(){
        parent::boot();
        static::creating(function($student){
            $student->leadnumber =  self::generatestudentid();
        });

    }

    protected static function generatestudentid(){
        return DB::transaction(function(){
            $latestlead = DB::table('leads')->orderBy('id','desc')->first();
            $latestid = $latestlead? $latestlead->id : 0;
            $newleadid = "LD".str_pad($latestid+1,5,'0',STR_PAD_LEFT); 

            while(DB::table('leads')->where('leadnumber',$newleadid)->exists()){
                $latestid++;
                $newleadid = "LD".str_pad($latestid+1,5,'0',STR_PAD_LEFT); 

            }

            return $newleadid;

        });
    }

    public function coverttostudent(){

        // student create 
        $student = Student::create([
           'firstname' => $this->firstname,
           'lastname' => $this->lastname,
           'slug' => Str::slug($this->firstname),
           'gender_id' => $this->gender_id, 
           'age' => $this->age, 
           'email' => $this->email, 
           'country_id' => $this->country_id, 
           'city_id' => $this->city_id,
           'user_id' => $this->user_id,
        ]); 
        
        //create empty phone 
        StudentPhone::create([
        'student_id' => $student->id, 
        'phone' => null
        ]);

        // lead update
        $this->update([
            'converted' => true, 
            'student_id' => $student->id
        ]);
        
        return $student;
    }

    public function isconverted(){
        return $this->converted === 1;
    }
}
