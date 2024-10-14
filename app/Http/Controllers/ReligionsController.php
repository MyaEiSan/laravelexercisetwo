<?php

namespace App\Http\Controllers;

use App\Models\Religion;
use App\Models\Status;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReligionsController extends Controller
{
    public function index()
    {

        $religions = Religion::where(function($query){
            if($getname = request('filtername')){
                $query->where('name','LIKE','%'.$getname.'%');
            }
        })->paginate(15);

    
        $statuses = Status::whereIn('id',[3,4])->get();

        return view('religions.index',compact('religions','statuses'));
    }

  
    public function create()
    {
        return view('religions.create');
    }

    
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:countries,name',
            'status_id' => 'required'
        ],[
            'name.required' => 'Region name is required'
        ]);

        $religion = new Religion();
        $religion->name = $request['name'];
        $religion->status_id = $request['status_id'];
        $religion->user_id = auth()->user()->id;
        $religion->save();

        return redirect(route('religions.index'));
    }

 
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'editname' => 'required|unique:religions,name,'.$id,

        ],[
            'editname.required' => 'Country name is required'
        ]);

        $religion = Religion::findOrFail($id);
        $religion->name = $request['editname'];
        $religion->status_id = $request['editstatus_id'];
        $religion->user_id = auth()->user()->id;
        $religion->save();

        return redirect(route('religions.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $religion = Religion::findOrFail($id);
        $religion->delete();

        return redirect()->back();
    }

    public function typestatus(Request $request){
        $religion = Religion::findOrFail($request['id']);
        $religion->status_id = $request['status_id'];
        $religion->save();

        return response()->json(["success"=>'Status Change Successfully.']);
    }

    public function bulkdeletes(Request $request){
        try{

            $getselectedids = $request->selectedids;
            $religion = Religion::whereIn('id',$getselectedids)->delete();

            return response()->json(['success'=>'Selected data have been deleted successfully.']);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['status'=>'failed','message'=>$e->getMessage()]);
        }
    }
}
