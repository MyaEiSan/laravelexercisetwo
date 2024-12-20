<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Country;
use App\Models\Status;
use Exception;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Constraint\Count;

class CountriesController extends Controller
{
    public function index()
    {
        $this->authorize('view',Country::class);
        // http://localhost:8000/countries?filtername=My
        // dd(request('filtername'));

        $countries = Country::where(function($query){
            if($getname = request('filtername')){
                $query->where('name','LIKE','%'.$getname.'%');
            }
        })->orderBy('id','asc')->paginate(10);
        // dd($countries);

        $statuses = Status::whereIn('id',[3,4])->get();
        
        return view('countries.index',compact('countries','statuses'));
    }

  
    public function create()
    {
        $this->authorize('create', Country::class);
        return view('countries.create');
    }

    
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:countries,name'
        ],[
            'name.required' => 'Country name is required'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $country = new Country();
        $country->name = $request['name'];
        $country->slug = Str::slug($request['name']);
        $country->status_id = $request['status_id'];
        $country->user_id = $user->id;
        $country->save();

        return redirect(route('countries.index'));
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
            'editname' => 'required|unique:countries,name,'.$id
        ],[
            'editname.required' => 'Country name is required'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $country = Country::findOrFail($id);
        $country->name = $request['editname'];
        $country->slug = Str::slug($request['editname']);
        $country->status_id = $request['editstatus_id'];
        $country->user_id = $user->id;
        $country->save();

        return redirect(route('countries.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete',Country::class);
        $country = Country::findOrFail($id);
        $country->delete();

        return redirect()->back();
    }

    public function typestatus(Request $request){
        $country = Country::findOrFail($request['id']);
        $country->status_id = $request['status_id'];
        $country->save();

        return response()->json(["success"=>'Status Change Successfully.']);
    }

    public function bulkdeletes(Request $request){
        try{

            $getselectedids = $request->selectedids;
            $country = Country::whereIn('id',$getselectedids)->delete();

            return response()->json(['success'=>'Selected data have been deleted successfully.']);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['status'=>'failed','message'=>$e->getMessage()]);
        }
    }
}
