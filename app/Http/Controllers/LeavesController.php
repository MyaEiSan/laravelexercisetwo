<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use App\Models\Leave;
use App\Models\User;


class LeavesController extends Controller
{
    public function index()
    {
        $leaves = Leave::filteronly()->searchonly()->paginate(10);
        $posts = DB::table('posts')->where('attshow',3)->orderBy('title','asc')->get()->pluck('title','id')->prepend('Choose class','');
        return view('leaves.index',compact('leaves','posts'));
    }

    public function create()
    {
        $data['posts']= DB::table('posts')->where('attshow',3)->orderBy('title','asc')->get()->pluck('title','id');
        $data['tags'] = User::orderBy('name','asc')->get()->pluck('name','id');
      
        return view('leaves.create',$data);
    }

    
    public function store(LeaveRequest $request)
    {

        // $this->validate($request,[
        //     'post_id' => 'required',
        //     'startdate' => 'required|date',
        //     'enddate' => 'required|date',
        //     'tag' => 'required',
        //     'title' => 'required|max:50',
        //     'content' => 'required',
        //     'image' => 'nullable|image|mimes:jpg,jpeg,png|max:1024'
        // ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $leave = new Leave();
        $leave->post_id = $request['post_id'];
        $leave->startdate = $request['startdate'];
        $leave->enddate = $request['enddate'];
        $leave->tag = $request['tag'];
        $leave->title = $request['title'];
        $leave->content = $request['content'];
        $leave->user_id = $user_id;

        // Single Image Upload 
        if(file_exists($request['image'])){
            $file = $request['image'];
            $fname = $file->getClientOriginalName();
            $imagenewname = uniqid($user_id).$leave['id'].$fname;
            $file->move(public_path('assets/img/leaves/'),$imagenewname);

            $filepath = "assets/img/leaves/".$imagenewname;
            $leave->image = $filepath;
        }

        $leave->save();

        session()->flash('success',"New Leave Created");

        return redirect(route('leaves.index'));
    }

    
    public function show(string $id)
    {

        $leave = Leave::findOrFail($id);
        // dd($leave->checkenroll(1));

        $dayables = $leave->days()->get();
        // dd($dayables);
        // $comments = Comment::where('commentable_id',$leave->id)->where('commentable_type','App\Models\Leave')->orderBy('created_at','desc')->get();
        $comments = $leave->comments()->orderBy('updated_at','desc')->get();
        return view('leaves.show',["leave"=>$leave,'dayables'=>$dayables,'comments'=>$comments]);
    }

    
    public function edit(string $id)
    {
        
        $data['leave'] = Leave::findOrFail($id);
        $data['posts']= DB::table('posts')->where('attshow',3)->orderBy('title','asc')->get()->pluck('title','id');
        $data['tags'] = User::orderBy('name','asc')->get()->pluck('name','id');


        return view('leaves.edit',$data);
    }

    public function update(LeaveRequest $request, string $id)
    {
       
        $leave = Leave::findOrFail($id);

        $user = Auth::user();
        $user_id = $user['id'];

        $leave->post_id = $request['post_id'];
        $leave->startdate = $request['startdate'];
        $leave->enddate = $request['enddate'];
        $leave->tag = $request['tag'];
        $leave->title = $request['title'];
        $leave->content = $request['content'];

        // Remove Old Image 
        if($request->hasFile('image')){

            $path = $leave->image;

            if(File::exists($path)){
                File::delete($path);
            }
        }

        // Single Image Upload 
        if($request->hasFile('image')){
            $file = $request->file('image');
            $fname = $file->getClientOriginalName();
            $imagenewname = uniqid($user_id).$leave['id'].$fname;
            $file->move(public_path('assets/img/leaves/'),$imagenewname);

            $filepath = "assets/img/leaves/".$imagenewname;
            $leave->image = $filepath;
        }

        $leave->save();

        session()->flash('success','Updated Successfully');

        return redirect(route('leaves.index'));
    }

    
    public function destroy(string $id)
    {
        $leave = Leave::findOrFail($id);
            
        // Remove Old Image 

        $path = $leave->image;
        
        if(File::exists($path)){
            File::delete($path);
        }

        $leave->delete();

        session()->flash('success','Deleted Successfully');

        return redirect()->back();
    }
}


