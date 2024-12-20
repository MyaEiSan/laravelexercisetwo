<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use App\Models\Type;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TypesController extends Controller
{
   
    public function index()
    {
        $types = Type::all();
        $statuses = Status::whereIn('id',[3,4])->get();
        return view('types.index',compact('types','statuses'));
    }

    public function create()
    {
        $statuses = Status::whereIn('id',[3,4])->get();
        return view('types.create',compact('statuses'));
    }

    
    public function store(Request $request)
    {

        $this->validate($request,[
            'name' => 'required|max:50|unique:types,name',
            'status_id' => 'required|in:3,4'
        ],[
            'name.required' => 'Name is required',
            'status_id.required' => 'Status is required'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $type = new Type();
        $type->name = $request['name'];
        $type->slug = Str::slug($request['name']);
        $type->status_id = $request['status_id'];
        $type->user_id = $user->id;

        $type->save();

        return redirect(route('types.index'));
    }

    
    public function show(string $id)
    {
        $type = Type::findOrFail($id);
        return view('types.show',["type"=>$type]);
    }

    
    public function edit(string $id)
    {
        $type = Type::findOrFail($id);
        $statuses = Status::whereIn('id',[3,4])->get();

        return view('types.edit')->with("type",$type)->with('statuses',$statuses);
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            'name' => ['required','max:50','unique:types,name,'.$id],
            'status_id' => ['required','in:3,4']
        ],[
            'name.required' => 'Name is required',
            'status_id.required' => 'Status is required'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $type = Type::findOrFail($id);
        $type->name = $request['name'];
        $type->slug = Str::slug($request['name']);
        $type->status_id = $request['status_id'];
        $type->user_id = $user->id;


        $type->save();

        return redirect(route('types.index'));
    }

    
    // public function destroy(string $id)
    // {
    //     $type = Type::findOrFail($id);
            
    //     $type->delete();

    //     return redirect()->back();
    // }

    public function destroy(Request $request)
    {
        $type = Type::findOrFail($request['id']);  
        $type->delete();

        // session()->flash('info', 'Delete Successfully');
        return response()->json(["success"=>"Delete Successfully."]);
    }

    public function typestatus(Request $request){ 

        $type = Type::findOrFail($request['id']);
        $type->status_id = $request['status_id'];
        $type->save();

        return response()->json(["success"=>'Status Change Successfully.']);
    }

    public function bulkdeletes(Request $request){
        try{

            $getselectedids = $request->selectedids;
            $type = Type::whereIn('id',$getselectedids)->delete();

            return response()->json(['success'=>'Selected data have been deleted successfully.']);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['status'=>'failed','message'=>$e->getMessage()]);
        }
    }

}
