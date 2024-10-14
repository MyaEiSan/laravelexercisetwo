<?php

namespace App\Http\Controllers;

use App\Models\PostViewDuration;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PostViewDurationController extends Controller
{
    public function trackduration(Request $request){

        // need to convert laravel timing format for to get time diff 
        // $entrytime = Session::get('entrytime');
        // $exittime = $request->input('exittime'); 

        $entrytime = Carbon::parse(Session::get('entrytime')); 
        $exittime = Carbon::parse($request->input('exittime')); 
        $postid = Session::get('post_id')->id;
        $user_id  = Auth::id();


        if($entrytime && $exittime && $postid && $user_id){

            $durationinsecond = $entrytime->diffInSeconds($exittime);
            // $durationinminute = $entrytime->diffInMinutes($exittime);

            $postviewduration = new PostViewDuration();
            $postviewduration->user_id = $user_id; 
            $postviewduration->post_id = $postid;
            $postviewduration->duration = $durationinsecond; 
            $postviewduration->save();
            
            // Clear Session variables 
            Session::forget('entrytime');
            Session::forget('post_id');

        }

        // return response()->json(['status'=>'success','entrytime'=>$entrytime,'exittime'=>$exittime,'postid'=>$postid]);
        return response()->json(['status'=>'success']);
    }
}
