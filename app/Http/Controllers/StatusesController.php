<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusCreateRequest;
use App\Models\Status;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StatusesController extends Controller
{
   
    public function index()
    {
        $statuses = Status::all();
        return view('statuses.index',compact('statuses'));
    }

  
    public function create()
    {
        return view('statuses.create');
    }

    
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:statuses,name'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $status = new Status();
        $status->name = $request['name'];
        $status->slug = Str::slug($request['name']);
        $status->user_id = $user->id;
        $status->save();

        return redirect(route('statuses.index'));
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
            'name' => 'required|unique:statuses,name,'.$id
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $status = Status::findOrFail($id);
        $status->name = $request['name'];
        $status->slug = Str::slug($request['name']);
        $status->user_id = $user->id;
        $status->save();

        return redirect(route('statuses.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = Status::findOrFail($id);
        $status->delete();

        return redirect()->back();
    }

    public function bulkdeletes(Request $request){
        try{

            $getselectedids = $request->selectedids;
            $status = Status::whereIn('id',$getselectedids)->delete();

            return response()->json(['success'=>'Selected data have been deleted successfully.']);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['status'=>'failed','message'=>$e->getMessage()]);
        }
    }

}
