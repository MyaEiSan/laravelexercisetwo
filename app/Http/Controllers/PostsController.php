<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Day;
use App\Models\DayAble;
use App\Models\Post;
use App\Models\PostViewDuration;
use App\Models\Status;
use App\Models\Tag;
use App\Models\Type;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class PostsController extends Controller
{
    public function index()
    {
        $this->authorize('view', Post::class);
        $posts = Post::all();
        return view('posts.index',compact('posts'));
    }

    public function create()
    {
        $this->authorize('create', Post::class);
        $attshows = Status::whereIn('id',[3,4])->get();
        $days = Day::where('status_id',3)->get();
        $statuses = Status::whereIn('id',[7,10,11])->get();
        $tags = Tag::where('status_id',3)->get();
        $types = Type::whereIn('id',[1,2])->get();
        $gettoday = Carbon::now()->format('Y-m-d');
        $gettime = Carbon::now()->format('H:i');

        return view('posts.create',compact('attshows','days','statuses','tags','types','gettoday','gettime'));
    }

    
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);
        $this->validate($request,[
            'image' => 'image|mimes:jpg,jpeg,png|max:1024',
            'title' => 'required|max:300|unique:posts',
            'content' => 'required',
            'fee' => 'required|numeric',
            'startdate' => 'required',
            'enddate' => 'required',
            'starttime' => 'required',
            'endtime' => 'required',
            'type_id' => 'required|in:1,2',
            'tag_id' => 'required',
            'attshow' => 'required|in:3,4',
            'status_id' => 'required|in:7,10,11',
            'day_id' => 'required|array',
            'day_id.*' => 'exists:days,id'
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
        $post->fill($request->only([
            'title','content','fee','startdate','enddate','starttime','endtime','type_id','tag_id','attshow','status_id'
        ]));

        $post->slug = Str::slug($request['tilte']);
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
            // if(count($request['day_id']) > 0){
            //     foreach($request['day_id'] as $key=>$value){

            //         $day = [
            //             // 'day_id' => $request['day_id'][$key],
            //             'day_id' => $value,
            //             'dayable_id'=>$post->id,
            //             'dayable_type' =>$request['dayable_type'] 
            //         ];

            //         Dayable::insert($day);
            //     }
            // }


            //    Method 3
            $day = array_map(function($dayid)use($post,$request){
                return [
                    'day_id' => $dayid,
                    'dayable_id'=>$post->id,
                    'dayable_type' => $request['dayable_type'] // or you can use Post::class
                ];
            },$request->day_id);
            Dayable::insert($day);
            
            
        }
        
        session()->flash('success','New Post Created');

        return redirect(route('posts.index'));
    }

    
    public function show(Post $post)
    {
        $this->authorize('view', $post);

        $dayables = $post->days()->get();
        // $comments = Comment::where('commentable_id',$post->id)->where('commentable_type','App\Models\Post')->orderBy('created_at','desc')->get();
        $comments = $post->comments()->orderBy('updated_at','desc')->get();

        $user_id = Auth::user()->id;

        $viewers = $post->postViewDurations()->whereNot('user_id',$user_id)->orderBy('id','desc')->take(10)->get();
        
        return view('posts.show',["post"=>$post,'dayables'=>$dayables,'comments'=>$comments,'viewers'=>$viewers]);
    }
    
    public function edit(Post $post)
    {
        $this->authorize('edit', $post);
        // $post = Post::findOrFail($id);
        $attshows = Status::whereIn('id',[3,4])->get();
        $days = Day::where('status_id',3)->get();
        $dayables = $post->days()->get();
        $statuses = Status::whereIn('id',[7,10,11])->get();
        $tags = Tag::where('status_id',3)->get();
        $types = Type::whereIn('id',[1,2])->get();


        return view('posts.edit')->with("post",$post)->with('attshows',$attshows)->with('days',$days)->with('dayables',$dayables)->with('statuses',$statuses)->with('tags',$tags)->with('types',$types);
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        
        $this->validate($request,[
            'image' => 'image|mimes:jpg,jpeg,png|max:1024',
            'title' => 'required|max:300|unique:posts,title,'.$post->id,
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

        // $post = Post::findOrFail($id);
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

        // Update Days
        $post->days()->sync($request['day_id']); 

        session()->flash('success','Update Successfully');
        return redirect(route('posts.index'));
    }

    
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        // $post = Post::findOrFail($id);
            
        // Remove Old Image 

        $path = $post->image;
        
        if(File::exists($path)){
            File::delete($path);
        }

        $post->delete();

        return redirect()->back();
    }

    public function bulkdeletes(Request $request){
        try{

            $getselectedids = $request->selectedids;
            $warehouse = Post::whereIn('id',$getselectedids)->delete();

            return response()->json(['success'=>'Selected data have been deleted successfully.']);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['status'=>'failed','message'=>$e->getMessage()]);
        }
    }

}
