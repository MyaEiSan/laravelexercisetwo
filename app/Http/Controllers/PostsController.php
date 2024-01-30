<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Day;
use App\Models\DayAble;
use App\Models\Post;
use App\Models\Status;
use App\Models\Tag;
use App\Models\Type;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('posts.index',compact('posts'));
    }

    public function create()
    {
        $attshows = Status::whereIn('id',[3,4])->get();
        $days = Day::where('status_id',3)->get();
        $statuses = Status::whereIn('id',[7,10,11])->get();
        $tags = Tag::where('status_id',3)->get();
        $types = Type::whereIn('id',[1,2])->get();
        return view('posts.create',compact('attshows','days','statuses','tags','types'));
    }

    
    public function store(Request $request)
    {

        $this->validate($request,[
            'image' => 'image|mimes:jpg,jpeg,png|max:1024',
            'title' => 'required|max:300|unique:posts',
            'content' => 'required',
            'fee' => 'required',
            'startdate' => 'required',
            'enddate' => 'required',
            'starttime' => 'required',
            'endtime' => 'required',
            'type_id' => 'required|in:1,2',
            'tag_id' => 'required',
            'attshow' => 'required|in:3,4',
            'status_id' => 'required|in:7,10,11'
        ],[
            'title.required' => 'Title is required',
            'content.required' => 'Content is required',
            'fee.required' => 'Fee is required',
            'startdate.required' => 'Start date is required',
            'enddate.required' => 'End date is required',
            'starttime.required' => 'Start time is required',
            'endtime.required' => 'End time is required',
            'type_id.required' => 'Type is required',
            'tag_id.required' => 'Tag is required',
            'attshow.required' => 'Attendance show is required',
            'status_id.required' => 'Status is required'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $post = new Post();
        $post->title = $request['title'];
        $post->slug = Str::slug($request['tilte']);
        $post->content = $request['content'];
        $post->fee = $request['fee'];
        $post->startdate = $request['startdate'];
        $post->enddate = $request['enddate'];
        $post->starttime = $request['starttime'];
        $post->endtime = $request['endtime'];
        $post->type_id = $request['type_id'];
        $post->tag_id = $request['tag_id'];
        $post->attshow = $request['attshow'];
        $post->status_id = $request['status_id'];
        $post->user_id = $user->id;

        // Single Image Upload 
        if(file_exists($request['image'])){
            $file = $request['image'];
            $fname = $file->getClientOriginalName();
            $imagenewname = uniqid($user_id).$post['id'].$fname;
            $file->move(public_path('assets/img/posts/'),$imagenewname);

            $filepath = "assets/img/posts/".$imagenewname;
            $post->image = $filepath;
        }

        $post->save();

        if($post->id){

            // create dayable 

            // Method 1
            // if(count($request['day_id']) > 0){
            //     foreach($request['day_id'] as $key=>$value){
            //         Dayable::create([
            //             // 'day_id' => $request['day_id'][$key],
            //             'day_id' => $value,
            //             'dayable_id'=>$post->id,
            //             'dayable_type' =>$request['dayable_type'] 
            //         ]);
            //     }
            // }

            // Method 2
            if(count($request['day_id']) > 0){
                foreach($request['day_id'] as $key=>$value){

                    $day = [
                        // 'day_id' => $request['day_id'][$key],
                        'day_id' => $value,
                        'dayable_id'=>$post->id,
                        'dayable_type' =>$request['dayable_type'] 
                    ];

                    Dayable::insert($day);
                }
            }
        }

        return redirect(route('posts.index'));
    }

    
    public function show(string $id)
    {

        $post = Post::findOrFail($id);
        // dd($post->checkenroll(1));

        $dayables = $post->days()->get();
        // dd($dayables);
        // $comments = Comment::where('commentable_id',$post->id)->where('commentable_type','App\Models\Post')->orderBy('created_at','desc')->get();
        $comments = $post->comments()->orderBy('updated_at','desc')->get();
        return view('posts.show',["post"=>$post,'dayables'=>$dayables,'comments'=>$comments]);
    }

    
    public function edit(string $id)
    {
        
        $post = Post::findOrFail($id);
        $attshows = Status::whereIn('id',[3,4])->get();
        $days = Day::where('status_id',3)->get();
        $dayables = $post->days()->get();
        $statuses = Status::whereIn('id',[7,10,11])->get();
        $tags = Tag::where('status_id',3)->get();
        $types = Type::whereIn('id',[1,2])->get();


        return view('posts.edit')->with("post",$post)->with('attshows',$attshows)->with('days',$days)->with('dayables',$dayables)->with('statuses',$statuses)->with('tags',$tags)->with('types',$types);
    }

    public function update(Request $request, string $id)
    {
        
        $this->validate($request,[
            'image' => 'image|mimes:jpg,jpeg,png|max:1024',
            'title' => 'required|max:300|unique:posts,title,'.$id,
            'content' => 'required',
            'fee' => 'required',
            'startdate' => 'required',
            'enddate' => 'required',
            'starttime' => 'required',
            'endtime' => 'required',
            'type_id' => 'required|in:1,2',
            'tag_id' => 'required',
            'attshow' => 'required|in:3,4',
            'status_id' => 'required|in:7,10,11'
        ],[
            'title.required' => 'Title is required',
            'content.required' => 'Content is required',
            'fee.required' => 'Fee is required',
            'startdate.required' => 'Start date is required',
            'enddate.required' => 'End date is required',
            'starttime.required' => 'Start time is required',
            'endtime.required' => 'End time is required',
            'type_id.required' => 'Type is required',
            'tag_id.required' => 'Tag is required',
            'attshow.required' => 'Attendance show is required',
            'status_id.required' => 'Status is required'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $post = Post::findOrFail($id);
        $post->title = $request['title'];
        $post->slug = Str::slug($request['tilte']);
        $post->content = $request['content'];
        $post->fee = $request['fee'];
        $post->startdate = $request['startdate'];
        $post->enddate = $request['enddate'];
        $post->starttime = $request['starttime'];
        $post->endtime = $request['endtime'];
        $post->type_id = $request['type_id'];
        $post->tag_id = $request['tag_id'];
        $post->attshow = $request['attshow'];
        $post->status_id = $request['status_id'];
        $post->user_id = $user->id;

        // Remove Old Image 
        if($request->hasFile('image')){

            $path = $post->image;

            if(File::exists($path)){
                File::delete($path);
            }
        }

        // Single Image Upload 
        if($request->hasFile('image')){
            $file = $request->file('image');
            $fname = $file->getClientOriginalName();
            $imagenewname = uniqid($user_id).$post['id'].$fname;
            $file->move(public_path('assets/img/posts/'),$imagenewname);

            $filepath = "assets/img/posts/".$imagenewname;
            $post->image = $filepath;
        }

        $post->save();

        // Method 1 
        if($post->id){
            if(isset($request['day_id'])){
                $post->days()->sync($request['day_id']);
            }else{
                $dayable =Dayable::where('dayable_id',$post['id'])
                ->where('dayable_type',$request['dayable_type']);
                $dayable->delete();
            }
        }

        // Start Day Action 
    //    if(isset($request['newday_id'])){

    //         // remove all days 
    //         foreach($request['newday_id'] as $key=>$value){
    //             $dayable =Dayable::where('dayable_id',$post['id'])
    //                         ->where('dayable_type',$request['dayable_type']);
    //             $dayable->delete();
    //         }

    //         // add renewday 
    //         foreach($request['newday_id'] as $key=>$value){
    //             $renewday = [
    //                 'day_id' => $request['newday_id'][$key],
    //                 'dayable_id' => $post['id'],
    //                 'dayable_type' => $request['dayable_type']
    //             ];
    //             Dayable::insert($renewday);
    //         }
    //    }elseif(isset($request['day_id'])){

    //         $dayable =Dayable::where('dayable_id',$post['id'])
    //                         ->where('dayable_type',$request['dayable_type']);
    //         $dayable->delete();

    //         foreach($request['newday_id'] as $key=>$value){
    //             $renewday = [
    //                 'day_id' => $request['newday_id'][$key],
    //                 'dayable_id' => $post['id'],
    //                 'dayable_type' => $request['dayable_type']
    //             ];
    //             Dayable::insert($renewday);
    //         }
            
    //    }else{

    //    }
        // End Day Action 

        return redirect(route('posts.index'));
    }

    
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
            
        // Remove Old Image 

        $path = $post->image;
        
        if(File::exists($path)){
            File::delete($path);
        }

        $post->delete();

        return redirect()->back();
    }
}
