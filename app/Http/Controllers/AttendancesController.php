<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Attendance;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        $getclassdate = $request['classdate']; 
        $getpostid = $request['post_id']; 
        $getattcode = Str::upper($request['attcode']);

        if($attendance->checkattcode($getclassdate,$getpostid,$getattcode)){

        }
        
        $attendance->classdate = $request['classdate'];
        $attendance->post_id = $request['post_id'];
        $attendance->attcode = Str::upper($request['attcode']);
        $attendance->user_id = $user_id;

        $attendance->save();

        session()->flash('success','Att Created!');

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

    public function bulkdeletes(Request $request){
        try{

            $getselectedids = $request->selectedids;
            $attendance = Attendance::whereIn('id',$getselectedids)->delete();

            return response()->json(['success'=>'Selected data have been deleted successfully.']);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['status'=>'failed','message'=>$e->getMessage()]);
        }
    }

}
