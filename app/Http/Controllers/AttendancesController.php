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
        $attendances = Attendance::orderBy('updated_at','desc')->get();
        // $posts = Post::where('attshow',3)->get();
        $posts = DB::table('posts')->where('attshow',3)->orderBy('title','asc')->get();
        return view('attendances.index',compact('attendances','posts'));
    }
    
    public function store(Request $request)
    {

        $this->validate($request,[
            'classdate' => 'required|date',
            'post_id' => 'required',
            'attcode' => 'required'
        ],[
            'classdate.required' => 'Class date is required',
            'post_id.required' => 'Post is required',
            'attcode.required' => 'Attendance code is required' 
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $attendance = new Attendance();
        $attendance->classdate = $request['classdate'];
        $attendance->post_id = $request['post_id'];
        $attendance->attcode = $request['attcode'];
        $attendance->user_id = $user_id;

        $attendance->save();

        session()->flash('success','Success!');

        return redirect(route('attendances.index'));
    }


    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            'classdate' => 'required|date',
            'post_id' => 'required',
            'attcode' => 'required'
        ],[
            'classdate.required' => 'Class date is required',
            'post_id.required' => 'Post is required',
            'attcode.required' => 'Attendance code is required' 
        ]);

        // $user = Auth::user();
        // $user_id = $user['id'];

        $attendance = Attendance::findOrFail($id);
        $attendance->classdate = $request['classdate'];
        $attendance->post_id = $request['post_id'];
        $attendance->attcode = $request['attcode'];


        $attendance->save();
        session()->flash('success','Success!');

        return redirect(route('attendances.index'));
    }

}
