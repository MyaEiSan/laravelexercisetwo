<?php

namespace App\Http\Controllers;

use App\Models\Enroll;
use App\Models\Stage;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class EnrollsController extends Controller
{
    public function index()
    {
        $enrolls = Enroll::all();
        return view('enrolls.index',compact('enrolls'));
    }

    public function create()
    {
        return view('enrolls.create');
    }

    
    public function store(Request $request)
    {

        $this->validate($request,[
            'image' => 'image|mimes:jpg,jpeg,png|max:1024'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $enroll = new Enroll();
        $enroll->post_id = $request['post_id'];
        $enroll->remark = $request['remark'];
        $enroll->user_id = $user->id;

        // Single Image Upload 
        if(file_exists($request['image'])){
            $file = $request['image'];
            $fname = $file->getClientOriginalName();
            $imagenewname = uniqid($user_id).$enroll['id'].$fname;
            $file->move(public_path('assets/img/enrolls/'),$imagenewname);

            $filepath = "assets/img/enrolls/".$imagenewname;
            $enroll->image = $filepath;
        }

        $enroll->save();

        return redirect()->back();
    }

    
    public function show(string $id)
    {
        $enroll = Enroll::findOrFail($id);
        return view('enrolls.show',["enroll"=>$enroll]);
    }

    
    public function edit(string $id)
    {
        $enroll = Enroll::findOrFail($id);

        return view('enrolls.edit')->with("enroll",$enroll)->with('statuses');
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            'name' => ['required','max:50','unique:roles,name,'.$id],
            'image' => ['image','mimes:jpg,jpeg,png','max:1024'],
            'status_id' => ['required','in:3,4']
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $enroll = Enroll::findOrFail($id);
        $enroll->name = $request['name'];
        $enroll->slug = Str::slug($request['name']);
        $enroll->status_id = $request['status_id'];
        $enroll->user_id = $user->id;

        // Remove Old Image 
        if($request->hasFile('image')){

            $path = $enroll->image;

            if(File::exists($path)){
                File::delete($path);
            }
        }

        // Single Image Upload 
        if($request->hasFile('image')){
            $file = $request->file('image');
            $fname = $file->getClientOriginalName();
            $imagenewname = uniqid($user_id).$enroll['id'].$fname;
            $file->move(public_path('assets/img/enrolls/'),$imagenewname);

            $filepath = "assets/img/enrolls/".$imagenewname;
            $enroll->image = $filepath;
        }

        $enroll->save();

        return redirect(route('enrolls.index'));
    }

    
    public function destroy(string $id)
    {
        $enroll = Enroll::findOrFail($id);
            
        // Remove Old Image 

        $path = $enroll->image;
        
        if(File::exists($path)){
            File::delete($path);
        }

        $enroll->delete();

        return redirect()->back();
    }
}
