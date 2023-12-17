<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Stage;
use App\Models\Status;

class StagesController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stages = Stage::all();
        $statuses = Status::whereIn('id',[3,4])->get();

        return view('stages.index',['stages' => $stages,'statuses'=>$statuses]);
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
            'name' => 'required|max:50|unique:categories,name',
            'status_id' => 'required|in:3,4'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $stage = new Stage();
        $stage->name = $request['name'];
        $stage->slug = Str::slug($request['name']);
        $stage->status_id = $request['status_id'];
        $stage->user_id = $user_id;

        $stage->save();

        return redirect(route('stages.index'));
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
            'name' => 'required|max:50|unique:categories,name,'.$id,
            'status_id' => 'required|in:3,4'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $stage = Stage::findOrFail($id);
        $stage->name = $request['name'];
        $stage->slug = Str::slug($request['name']);
        $stage->status_id = $request['status_id'];
        $stage->user_id = $user_id;

        $stage->save();

        return redirect(route('stages.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stage = Stage::findOrFail($id);
        $stage->delete();

        return redirect()->back();
    }
}
