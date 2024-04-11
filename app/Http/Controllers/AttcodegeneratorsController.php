<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Attcodegenerator;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AttcodegeneratorsController extends Controller
{
    public function index()
    {
        $attcodegenerators = Attcodegenerator::orderBy('created_at','desc')->get();
        $posts = DB::table('posts')->where('attshow',3)->orderBy('title','asc')->get();
        $statuses = Status::whereIn('id',[3,4])->get();
        // $gettoday = date('Y-m-d',strtotime(Carbon::today()));
        $gettoday = Carbon::today()->format('Y-m-d');
        return view('attcodegenerators.index',compact('attcodegenerators','posts','statuses','gettoday'));
    }
    
    public function store(Request $request)
    {

        $this->validate($request,[
            'classdate' => 'required|date',
            'post_id' => 'required',

        ],[
            'classdate.required' => 'Class date is required',
            'post_id.required' => 'Post is required',
            'attcode.required' => 'Attendance code is required' 
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $attcodegenerator = new Attcodegenerator();
        $attcodegenerator->classdate = $request['classdate'];
        $attcodegenerator->post_id = $request['post_id'];
        $attcodegenerator->attcode = is_null($request['attcode'])? $attcodegenerator->randomstringgenerator(4) :Str::upper($request['attcode']);
        $attcodegenerator->status_id = $request['status_id'];
        $attcodegenerator->user_id = $user_id;

        $attcodegenerator->save();

        session()->flash('success','Att Code Created!');

        return redirect(route('attcodegenerators.index'));
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

        $attendance = Attcodegenerator::findOrFail($id);
        $attendance->classdate = $request['classdate'];
        $attendance->post_id = $request['post_id'];
        $attendance->attcode = $request['attcode'];


        $attendance->save();
        session()->flash('success','Success!');

        return redirect(route('attendances.index'));
    }


    public function typestatus(Request $request){ 

        $type = Attcodegenerator::findOrFail($request['id']);
        $type->status_id = $request['status_id'];
        $type->save();

        return response()->json(["success"=>'Status Change Successfully.']);
    }
}
