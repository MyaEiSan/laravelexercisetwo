<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Day;
use App\Models\Status;

class DaysController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $days = Day::all();
        $statuses = Status::whereIn('id',[3,4])->get();

        return view('days.index',['days' => $days,'statuses'=>$statuses]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:50|unique:days,name',
            'status_id' => 'required|in:3,4'
        ],[
            'name.required' => 'Day Name is required',
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $day = new Day();
        $day->name = $request['name'];
        $day->slug = Str::slug($request['name']);
        $day->status_id = $request['status_id'];
        $day->user_id = $user_id;

        $day->save();

        return redirect(route('days.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            'name' => 'required|max:50|unique:days,name,'.$id,
            'status_id' => 'required|in:3,4'
        ],[
            'name.required' => 'Day Name is required'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $day = Day::findOrFail($id);
        $day->name = $request['name'];
        $day->slug = Str::slug($request['name']);
        $day->status_id = $request['status_id'];
        $day->user_id = $user_id;

        $day->save();

        return redirect(route('days.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $day = Day::findOrFail($id);
        $day->delete();

        return redirect()->back();
    }

    public function typestatus(Request $request){
        $day = Day::findOrFail($request['id']);
        $day->status_id = $request['status_id'];
        $day->save();

        return response()->json(["success"=>'Status Change Successfully.']);
    }
}

// HW 

// change message in validation if need 
