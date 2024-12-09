<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use App\Models\Status;
use App\Models\Township;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TownshipsController extends Controller
{
    public function index()
    {
        $this->authorize('view', Township::class);
        $townships = Township::where(function($query){
            if($getname = request('filtername')){
                $query->where('name','LIKE','%'.$getname.'%');
            }
        })->paginate(15);

        $cities = City::orderBy('name','asc')->where('status_id',3)->get();
        $statuses = Status::whereIn('id',[3,4])->get();

        return view('townships.index',compact('townships','cities','statuses'));
    }

  
    public function create()
    {
        return view('townships.create');
    }

    
    public function store(Request $request)
    {
        $this->authorize('create', Township::class);
        $this->validate($request,[
            'name' => 'required|unique:townships,name',
            'city_id' => 'required|exists:cities,id', 
            'status_id' => 'required'
        ],[
            'name.required' => 'Region name is required',
            'city_id.required' => 'City is required'
        ]);

        $township = new Township();
        $township->name = $request['name'];
        $township->city_id = $request['city_id'];
        $township->status_id = $request['status_id'];
        $township->user_id = auth()->user()->id;
        $township->save();

        return redirect(route('townships.index'));
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
        $this->authorize('edit', Township::class);
        $this->validate($request,[
            'editname' => 'required|unique:townships,name,'.$id,
            'editcity_id' => 'required|exists:cities,id',

        ],[
            'editname.required' => 'Country name is required'
        ]);

        $township = Township::findOrFail($id);
        $township->name = $request['editname'];
        $township->city_id = $request['editcity_id'];
        $township->status_id = $request['editstatus_id'];
        $township->user_id = auth()->user()->id;
        $township->save();

        return redirect(route('townships.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Township::class);
        $township = Township::findOrFail($id);
        $township->delete();

        return redirect()->back();
    }

    public function typestatus(Request $request){
        $township = Township::findOrFail($request['id']);
        $township->status_id = $request['status_id'];
        $township->save();

        return response()->json(["success"=>'Status Change Successfully.']);
    }

    public function bulkdeletes(Request $request){
        try{

            $getselectedids = $request->selectedids;
            $township = Township::whereIn('id',$getselectedids)->delete();

            return response()->json(['success'=>'Selected data have been deleted successfully.']);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['status'=>'failed','message'=>$e->getMessage()]);
        }
    }
}
