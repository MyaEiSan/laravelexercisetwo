<?php

namespace App\Http\Controllers;

use App\Http\Resources\RegionsResource;
use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use App\Models\Status;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Constraint\Count;

class RegionsController extends Controller
{
    public function index()
    {
        $this->authorize('view', Region::class);
        $regions = Region::where(function($query){
            if($getname = request('filtername')){
                $query->where('name','LIKE','%'.$getname.'%');
            }
        })->paginate(15);

        $countries = Country::orderBy('name','asc')->where('status_id',3)->get();
        $statuses = Status::whereIn('id',[3,4])->get();

        return view('regions.index',compact('regions','countries','statuses'));
    }

  
    public function create()
    {
        $this->authorize('create', Region::class);
        return view('regions.create');
    }

    
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:regions,name',
            'country_id' => 'required|exists:countries,id',
            'status_id' => 'required'
        ],[
            'name.required' => 'Region name is required',
            'country_id.required' => 'Country is required', 
        ]);

        $region = new Region();
        $region->name = $request['name'];
        $region->country_id = $request['country_id'];
        $region->status_id = $request['status_id'];
        $region->user_id = auth()->user()->id;
        $region->save();

        return redirect(route('regions.index'));
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
        $this->authorize('edit', Region::class);
        $this->validate($request,[
            'editname' => 'required|unique:regions,name,'.$id,
            'editcountry_id' => 'required|exists:countries,id',

        ],[
            'editname.required' => 'Country name is required'
        ]);

        $region = Region::findOrFail($id);
        $region->name = $request['editname'];
        $region->country_id = $request['editcountry_id'];
        $region->status_id = $request['editstatus_id'];
        $region->user_id = auth()->user()->id;
        $region->save();

        return redirect(route('regions.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Region::class);
        $region = Region::findOrFail($id);
        $region->delete();

        return redirect()->back();
    }

    public function typestatus(Request $request){
        $country = Region::findOrFail($request['id']);
        $country->status_id = $request['status_id'];
        $country->save();

        return response()->json(["success"=>'Status Change Successfully.']);
    }

    public function bulkdeletes(Request $request){
        try{

            $getselectedids = $request->selectedids;
            $region = Region::whereIn('id',$getselectedids)->delete();

            return response()->json(['success'=>'Selected data have been deleted successfully.']);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['status'=>'failed','message'=>$e->getMessage()]);
        }
    }

    public function filterbycityid($filter){
        return RegionsResource::collection(Region::where('city_id',$filter)->where('status_id',3)->orderBy('name','asc')->get());
    }
}



// Regions U 
// Townships CRUD 

// Religon CRUD 

// name 
// status_id 
// user_id 