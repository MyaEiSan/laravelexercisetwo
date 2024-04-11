<?php

namespace App\Http\Controllers;

use App\Models\Socialapplication;
use Illuminate\Http\Request;
use App\Models\Status;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class SocialapplicationsController extends Controller
{
    public function index()
    {
        $socialapplications = Socialapplication::all();
        $statuses = Status::whereIn('id',[3,4])->get();
        return view('socialapplications.index',compact('socialapplications','statuses'));
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

        try{
            
            $socialapplication = new Socialapplication();
            $socialapplication->name = $request['name'];
            $socialapplication->slug = Str::slug($request['name']);
            $socialapplication->status_id = $request['status_id'];
            $socialapplication->user_id = $user->id;

            $socialapplication->save();

            if($socialapplication){
                return response()->json(["status"=>"success","data"=>$socialapplication]);
            }
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(["status"=>"failed","message"=>$e->getMessage()]);
        }

    }

    
    public function show(string $id)
    {
        $socialapplication = Socialapplication::findOrFail($id);
        return view('paymentmemethods.show',["socialapplication"=>$socialapplication]);
    }

    
    public function edit(string $id)
    {
        $socialapplication = Socialapplication::findOrFail($id);
        return response()->json($socialapplication);
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

        try{
            
            $socialapplication = Socialapplication::findOrFail($id);
            $socialapplication->name = $request['name'];
            $socialapplication->slug = Str::slug($request['name']);
            $socialapplication->status_id = $request['status_id'];
            $socialapplication->user_id = $user->id;


            $socialapplication->save();

            if($socialapplication){
                return response()->json(['status'=>'success','message'=>$socialapplication,'data'=>$socialapplication]);
            }

            return response()->json(['status'=>'failed','message'=>'Failed to update application']);
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['status'=>'success','message'=>$e->getMessage()]);
        }


        return redirect(route('paymentmethods.index'));
    }

    public function destroy(string $id)
    {
        try{

            $socialapplication = Socialapplication::where('id',$id)->delete();
            return Response::json($socialapplication);
            
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(["status"=>"failed","message"=>$e->getMessage()]);
        }
    }

    public function typestatus(Request $request){ 

        $type = Socialapplication::findOrFail($request['id']);
        $type->status_id = $request['status_id'];
        $type->save();

        return response()->json(["success"=>'Status Change Successfully.']);
    }

    public function fetchalldatas()
    {
        try{
            $socialapplications = Socialapplication::all();
        return response()->json(["status"=>"status","data"=>$socialapplications]);
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(["status"=>"failed","message"=>$e->getMessage()]);
        }
    }
}
