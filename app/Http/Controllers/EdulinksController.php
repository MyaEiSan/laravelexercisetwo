<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use App\Models\Edulink;
use App\Models\Post;
class EdulinksController extends Controller
{
    public function index()
    {
        // $data['edulinks'] = Edulink::orderBy('updated_at','desc')->paginate(5);

        // Method 1
        // $data['edulinks'] = Edulink::where(function($query){

        //     if($getfilter = request('filter')){
        //         $query->where('post_id',$getfilter);
        //     }

        //     if($getsearch = request('search')){
        //         // $query->where('classdate','LIKE','%'.$getsearch.'%');
        //         $query->where('classdate','LIKE',"%$getsearch%");
        //     }

        // })->zaclassdate()->paginate(5);
        
        // Method 2 by Local Scope 

        // DB::enableQueryLog();
        // $data['edulinks'] = Edulink::filter()->zaclassdate()->paginate(5);
        // dd(DB::getQueryLog());


        // DB::enableQueryLog();
        $data['edulinks'] = Edulink::filteronly()->searchonly()->zaclassdate()->paginate(5);
        // dd(DB::getQueryLog());

        // DB::enableQueryLog();
        $data['posts'] = DB::table('posts')->where('attshow',3)->orderBy('title','asc')->pluck('title','id');// beware:: {{$post['id']}} array can't .must be call by object in view file such as ,{{$post->id}}
        // dd(DB::getQueryLog());
        $data['filterposts'] = Post::whereIn('attshow',[3])->orderBy('title','asc')->pluck('title','id')->prepend('Choose class','');
        return view('edulinks.index',$data);
    }

    public function create()
    {
        return view('edulinks.create');
    }

    
    public function store(Request $request)
    {

        $this->validate($request,[
            'classdate' => 'required|date',
            'post_id' => 'required',
            'url' => 'required'
        ],[
            'classdate.required' => 'Class date is required',
            'post_id.required' => 'Post is required',
            'url.required' => 'Record url is required'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $edulink = new Edulink();
        $edulink->classdate = $request['classdate'];
        $edulink->post_id = $request['post_id'];
        $edulink->url = $request['url'];
        $edulink->user_id = $user_id;

        $edulink->save();

        // return redirect()->route('edulinks.index');
        // return redirect()->route('edulinks.index')->with('success','New Link Created');

        session()->flash('success','New Link Created');
        return redirect()->route('edulinks.index');
    }

    
    public function show(string $id)
    {
        $edulink = Edulink::findOrFail($id);
        return view('edulinks.show',["edulink"=>$edulink]);
    }

    
    public function edit(string $id)
    {
        $edulink = Edulink::findOrFail($id);

        return view('edulinks.edit')->with("edulink",$edulink)->with('statuses');
    }

    public function update(Request $request, string $id)
    {

        
        $this->validate($request,[
            'editclassdate' => 'required|date',
            'editpost_id' => 'required',
            'editurl' => 'required'
        ],[
            'editclassdate.required' => 'Class date is required',
            'editpost_id.required' => 'Post is required',
            'editurl.required' => 'Record url is required'
        ]);

        $user = Auth::user();
        $user_id = $user->id;

        $edulink = Edulink::findOrFail($id);
        $edulink->classdate = $request['editclassdate'];
        $edulink->post_id = $request['editpost_id'];
        $edulink->url = $request['editurl'];
        $edulink->user_id = $user_id;

        $edulink->save();

        // return redirect(route('edulinks.index'));
        // return redirect(route('edulinks.index'))->with('success','Update Successfully');

        session()->flash('success','Update Successfully!!');
        return redirect(route('edulinks.index'));
    }

    
    public function destroy(string $id)
    {
        $edulink = Edulink::findOrFail($id);

        $edulink->delete();

        session()->flash('success','Delete Successfully!!');
        return redirect(route('edulinks.index'));
    }
}
