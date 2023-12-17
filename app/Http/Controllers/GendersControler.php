<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gender;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GendersControler extends Controller
{
    public function index()
    {
        $genders = Gender::all();
        return view('genders.index',compact('genders'));
    }

  
    public function create()
    {
        return view('genders.create');
    }

    
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:genders,name'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $gender = new Gender();
        $gender->name = $request['name'];
        $gender->slug = Str::slug($request['name']);
        $gender->user_id = $user->id;
        $gender->save();

        return redirect(route('genders.index'));
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
            'name' => 'required|unique:genders,name,'.$id
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $gender = Gender::findOrFail($id);
        $gender->name = $request['name'];
        $gender->slug = Str::slug($request['name']);
        $gender->user_id = $user->id;
        $gender->save();

        return redirect(route('genders.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gender = Gender::findOrFail($id);
        $gender->delete();

        return redirect()->back();
    }
}
