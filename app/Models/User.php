<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function comments(){
        return $this->morphMany(Comment::class,'commentable');
    }

    public function likes(){
        return $this->belongsToMany(Post::class,'post_like')->withTimestamps();
    }

    public function checkpostlike($postid){
        return $this->likes()->where('post_id',$postid)->exists();
    }

    public function followings(){
                                                            //  fk       rk
        return $this->belongsToMany(User::class,'follower_user','follower_id','user_id')->withTimestamps();

        // Note::user_id mean = Other Person 
        // Note::follower_id mean = 

    }

    public function checkuserfollowing($followingid){
        return $this->followings()->where('user_id',$followingid)->exists();

        // Note::user_id mean = Other Person 
        // Note::follower_id mean = I
        // Note:: $followingid mean = Other Person 
    }

    public function scopeOnlineusers($query){
        return $this->where('is_online',1)->get();
    }

    public function scopeOfflineusers($query){
        return $this->where('is_online',0)->get();
    }


    public function carts(){
        return $this->hasMany(Cart::class);
    }

    public function userpoint(){
        return $this->hasOne(UserPoint::class);
    }

    public function lead(){
        return $this->hasOne(Lead::class);
    }

    public function student(){
        return $this->hasOne(Student::class);
    }

    public function roles(){
        return $this->belongsToMany(Role::class,'role_users');  // default naming convention is role_user 
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class,'permission_roles');
    }

    // public function hasRole($rolename){
    //     return $this->roles()->where('name',$rolename)->exists();
    // }

    public function hasRoles($rolenames){
        return $this->roles()->whereIn('name',$rolenames)->exists();
    }

    public function hasPermission($permissionname){
        return $this->roles()->whereHas('permissions', function($query) use($permissionname){
            $query->where('name',$permissionname);
        })->exists();
    }

    public function isOwner($model){
        return $this->id == $model->user_id;
    }
}
