<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CitiesControler extends Controller
{
    public function index()
    {
        $cities = City::all();
        return view('cities.index',compact('cities'));
    }

  
    public function create()
    {
        return view('cities.create');
    }

    
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:cities,name'
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
        //
    }

    
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required|unique:cities,name,'.$id
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
}
