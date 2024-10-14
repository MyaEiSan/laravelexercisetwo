<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Status;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class RolesController extends Controller
{
    
    public function index()
    {
        $roles = Role::where(function($query){
           if($statusid = request('filterstatus_id')){
            $query->where('status_id',$statusid);
           }
        })->orderBy('id','asc')->paginate(10);
        $filterstatuses = Status::whereIn('id',[3,4])->get()->pluck('name','id')->prepend('Choose Status','');
        return view('roles.index',compact('roles','filterstatuses'));
    }

    public function create()
    {
        $statuses = Status::whereIn('id',[3,4])->get()->pluck('name','id');
        return view('roles.create',compact('statuses'));
    }

    
    public function store(Request $request)
    {

        $this->validate($request,[
            'name' => 'required|max:50|unique:roles,name',
            'image' => 'image|mimes:jpg,jpeg,png|max:1024',
            'status_id' => 'required|in:3,4'
        ],[
            'name.required' => 'Name is required',
            'status_id.required' => 'Status is required'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $role = new Role();
        $role->name = $request['name'];
        $role->slug = Str::slug($request['name']);
        $role->status_id = $request['status_id'];
        $role->user_id = $user->id;

        // Single Image Upload 
        if(file_exists($request['image'])){
            $file = $request['image'];
            $fname = $file->getClientOriginalName();
            $imagenewname = uniqid($user_id).$role['id'].$fname;
            $file->move(public_path('assets/img/roles/'),$imagenewname);

            $filepath = "assets/img/roles/".$imagenewname;
            $role->image = $filepath;
        }

        $role->save();

        return redirect(route('roles.index'));
    }

    
    public function show(string $id)
    {
        $role = Role::findOrFail($id);
        return view('roles.show',["role"=>$role]);
    }

    
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        $statuses = Status::whereIn('id',[3,4])->get();

        return view('roles.edit')->with("role",$role)->with('statuses',$statuses);
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            'name' => ['required','max:50','unique:roles,name,'.$id],
            'image' => ['image','mimes:jpg,jpeg,png','max:1024'],
            'status_id' => ['required','in:3,4']
        ],[
            'name.required' => 'Name is required',
            'status_id.required' => 'Status is required'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $role = Role::findOrFail($id);
        $role->name = $request['name'];
        $role->slug = Str::slug($request['name']);
        $role->status_id = $request['status_id'];
        $role->user_id = $user->id;

        // Remove Old Image 
        if($request->hasFile('image')){

            $path = $role->image;

            if(File::exists($path)){
                File::delete($path);
            }
        }

        // Single Image Upload 
        if($request->hasFile('image')){
            $file = $request->file('image');
            $fname = $file->getClientOriginalName();
            $imagenewname = uniqid($user_id).$role['id'].$fname;
            $file->move(public_path('assets/img/roles/'),$imagenewname);

            $filepath = "assets/img/roles/".$imagenewname;
            $role->image = $filepath;
        }

        $role->save();

        return redirect(route('roles.index'));
    }

    
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
            
        // Remove Old Image 

        $path = $role->image;
        
        if(File::exists($path)){
            File::delete($path);
        }

        $role->delete();

        return redirect()->back();
    }

    public function typestatus(Request $request){ 

        $role = Role::findOrFail($request['id']);
        $role->status_id = $request['status_id'];
        $role->save();

        return response()->json(["success"=>'Status Change Successfully.']);
    }

    public function bulkdeletes(Request $request){
        try{

            $getselectedids = $request->selectedids;
            $role = Role::whereIn('id',$getselectedids)->delete();

            return response()->json(['success'=>'Selected data have been deleted successfully.']);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['status'=>'failed','message'=>$e->getMessage()]);
        }
    }
}
