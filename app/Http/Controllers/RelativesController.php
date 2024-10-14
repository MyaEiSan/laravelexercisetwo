<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Relative;
use App\Models\Status;
use Exception;
use Illuminate\Support\Facades\Log;
use PgSql\Lob;

class RelativesController extends Controller
{
      /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $relatives = Relative::all();
        $statuses = Status::whereIn('id',[3,4])->get();

        return view('relatives.index',['relatives' => $relatives,'statuses'=>$statuses]);
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
            'name' => 'required|max:50|unique:relatives,name',
            'status_id' => 'required|in:3,4'
        ],[
            'name.required' => 'Name is required',
            'status_id.required' => 'Status is required'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $day = new Relative();
        $day->name = $request['name'];
        $day->slug = Str::slug($request['name']);
        $day->status_id = $request['status_id'];
        $day->user_id = $user_id;

        $day->save();

        return redirect(route('relatives.index'));
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
            'name' => 'required|max:50|unique:relatives,name,'.$id,
            'status_id' => 'required|in:3,4'
        ],[
            'name.required' => 'Name is required',
            'status_id.required' => 'Status is required'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $day = Relative::findOrFail($id);
        $day->name = $request['name'];
        $day->slug = Str::slug($request['name']);
        $day->status_id = $request['status_id'];
        $day->user_id = $user_id;

        $day->save();

        return redirect(route('relatives.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $day = Relative::findOrFail($id);
        $day->delete();

        return redirect()->back();
    }

    public function typestatus(Request $request){
        $relative = Relative::findOrFail($request['id']);
        $relative->status_id = $request['status_id'];
        $relative->save();

        return response()->json(["success"=>'Status Change Successfully.']);
    }

    public function bulkdeletes(Request $request){
        try{

            $getselectedids = $request->selectedids;
            $relative = Relative::whereIn('id',$getselectedids)->delete();

            return response()->json(['success'=>'Selected data have been deleted successfully.']);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['status'=>'failed','message'=>$e->getMessage()]);
        }
    }

}
