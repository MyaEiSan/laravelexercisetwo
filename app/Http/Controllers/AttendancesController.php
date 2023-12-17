<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AttendancesController extends Controller
{
    public function index()
    {
        $attendances = Attendance::all();
        // $posts = Post::where('attshow',3)->get();
        $posts = DB::table('posts')->where('attshow',3)->orderBy('title','asc')->get();
        return view('attendances.index',compact('attendances','posts'));
    }

    public function create()
    {
        $posts = Post::where('attshow',3)->get();
        return view('attendances.create',compact('posts'));
    }

    
    public function store(Request $request)
    {

        $this->validate($request,[
            'classdate' => 'required|date',
            'post_id' => 'required',
            'attcode' => 'required'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $attendance = new Attendance();
        $attendance->classdate = $request['classdate'];
        $attendance->post_id = $request['post_id'];
        $attendance->attcode = $request['attcode'];
        $attendance->user_id = $user_id;

        $attendance->save();

        return redirect(route('attendances.index'));
    }

    
    public function show(string $id)
    {
        $attendance = Attendance::findOrFail($id);
        return view('attendances.show',["attendance"=>$attendance]);
    }

    
    public function edit(string $id)
    {
        $attendance = Attendance::findOrFail($id);
        $posts = Post::where('attshow',3)->get();

        return view('attendances.edit')->with("attendance",$attendance)->with('statuses',$posts);
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            'classdate' => 'required|date',
            'post_id' => 'required',
            'attcode' => 'required'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $attendance = Attendance::findOrFail($id);
        $attendance->classdate = $request['classdate'];
        $attendance->post_id = $request['post_id'];
        $attendance->attcode = $request['attcode'];
        $attendance->user_id = $user->id;


        $attendance->save();

        return redirect(route('attendances.index'));
    }

}
