<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Country;
use App\Models\Status;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CitiesControler extends Controller
{
    public function index()
    {

        $cities = City::where(function($query){
            if($getname = request('filtername')){
                $query->where('name','LIKE','%'.$getname.'%');
            }
        })->orderBy('id','asc')->paginate(10);

        $countries = Country::where('status_id',3)->orderBy('name','asc')->get();
        
        $statuses = Status::whereIn('id',[3,4])->get();

        return view('cities.index',compact('cities','countries','statuses'));
    }

  
    public function create()
    {
        return view('cities.create');
    }

    
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:cities,name'
        ],[
            'name.required' => 'City name is required'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $city = new City();
        $city->name = $request['name'];
        $city->slug = Str::slug($request['name']);
        $city->user_id = $user->id;
        $city->save();

        return redirect(route('cities.index'));
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
        $city = City::findOrFail($id); 

        return response()->json($city);
    }

    
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required|unique:cities,name,'.$id
        ],[
            'name.required' => 'City name is required'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $city = City::findOrFail($id);
        $city->name = $request['name'];
        $city->slug = Str::slug($request['name']);
        $city->user_id = $user->id;
        $city->save();

        return redirect(route('cities.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        return redirect()->back();
    }

    public function bulkdeletes(Request $request){
        try{

            $getselectedids = $request->selectedids;
            $city = City::whereIn('id',$getselectedids)->delete();

            return response()->json(['success'=>'Selected data have been deleted successfully.']);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['status'=>'failed','message'=>$e->getMessage()]);
        }
    }
}
