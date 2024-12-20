<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Leave extends Model
{
    use HasFactory;
    use Notifiable;

    
    protected $table = 'leaves';
    protected $primaryKey = 'id';
    protected $fillable = [
        'post_id',
        'startdate',
        'enddate',
        'tag',
        'title',
        'content',
        'image',
        'stage_id',
        'authorize_id',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function stage(){
        return $this->belongsTo(Stage::class);
    }

    public function leavefiles(){
        return $this->hasMany(LeaveFile::class);
    }

    public function student($userid){
        $students = Student::where('user_id',$userid)->get()->pluck('regnumber');
        foreach($students as $student){
            return $student;
        }
    }

    public function studenturl(){
        return Student::where('user_id',$this->user_id)->get(['students.id'])->first();
    }

    public function tagpersonurl($tagid){
        // return Student::where('user_id',$tagid)->get(['students.id'])->first();
        return Student::where('user_id',$tagid)->value('id');

    }


    public function scopefilteronly($query){
        if($getfilter = request('filter')){
            $query->where('post_id',$getfilter);
        }

        return $query;
    }

    public function scopesearchonly($query){

        if($getsearch = request('search')){
            // search by class date/ created at / updated at / post title orWhereHas(relation,callback)
            $query->where('startdate','LIKE',"%$getsearch%")
                ->orWhere('enddate','LIKE',"%$getsearch%")
                ->orWhere('title','LIKE',"%$getsearch%")
                ->orWhere('content','LIKE',"%$getsearch%")
                ->orWhereHas('post',function($query)use($getsearch){
                    $query->where('title','LIKE',"%$getsearch%");
                })
                ->orWhereHas('user',function($query)use($getsearch){
                    $query->where('name','LIKE',"%$getsearch%");
                });


        }

        return $query;
    }

    public function tagposts($postjson){
        $tagids = json_decode($postjson,true); // Decode json encoded tags 
        $posts = Post::whereIn('id',$tagids)->pluck('title','id'); // Fetch posts in a single query
        return $posts;
    }
    
    public function tagperson(){
        return $this->belongsTo(User::class,'tag');
    }

    // for multi tags 
    public function tagpersons($tagjson){
        $tagids = json_decode($tagjson,true); // Decode Json-encoded tags 
        $tags = User::whereIn('id',$tagids)->pluck('name','id'); // Fetch users in a single query
        return $tags;
    }

}
