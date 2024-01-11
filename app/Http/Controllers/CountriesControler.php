<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Country;

class CountriesControler extends Controller
{
    public function index()
    {
        // http://localhost:8000/countries?filtername=My
        // dd(request('filtername'));

        $countries = Country::where(function($query){
            if($getname = request('filtername')){
                $query->where('name','LIKE','%'.$getname.'%');
            }
        })->orderBy('id','asc')->paginate(10);
        // dd($countries);
        
        return view('countries.index',compact('countries'));
    }

  
    public function create()
    {
        return view('countries.create');
    }

    
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:countries,name'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $country = new Country();
        $country->name = $request['name'];
        $country->slug = Str::slug($request['name']);
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
            'name' => 'required|unique:countries,name,'.$id
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $country = Country::findOrFail($id);
        $country->name = $request['name'];
        $country->slug = Str::slug($request['name']);
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
        $country = Country::findOrFail($id);
        $country->delete();

        return redirect()->back();
    }
}
