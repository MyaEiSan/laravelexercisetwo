<?php

namespace App\Http\Controllers;


use App\Models\Post;
use Illuminate\Http\Request;
use App\Events\PostLiveViewerEvent;
use Illuminate\Support\Facades\Cache;

class PostLiveViewersController extends Controller
{
    // auto increment to each cache keyname 
    public function incrementviewer(Post $post){

        $count = Cache::increment('postliveviewer-count_'.$post->id);

        broadcast(new PostLiveViewerEvent($count,$post->id));
        // event(new PostLiveViewerEvent($count,$post->id));

        return response()->json(['success'=>true]);
    }

    // auto decrement to each cache keyname 
    public function decrementviewer(Post $post){
        $count = Cache::decrement('postliveviewer-count_'.$post->id);

        if($count < 0){
            $count = 0;
            Cache::put('postliveviewer-count_'.$post->id,$count);
        }

        broadcast(new PostLiveViewerEvent($count,$post->id));
        // event(new PostLiveViewerEvent($count,$post->id));

        return response()->json(['success'=>true]);
    }
}

// 18:10 
