<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Status;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PermissionsController extends Controller
{
    public function index()
    {
        $this->authorize('view', Permission::class);
        $permissions = Permission::where(function($query){
           if($statusid = request('filterstatus_id')){
            $query->where('status_id',$statusid);
           }
        })->orderBy('id','asc')->paginate(10);
        $filterstatuses = Status::whereIn('id',[3,4])->get()->pluck('name','id')->prepend('Choose Status','');
        return view('permissions.index',compact('permissions','filterstatuses'));
    }

    public function create()
    {
        $this->authorize('create', Permission::class);
        $statuses = Status::whereIn('id',[3,4])->get()->pluck('name','id');
        return view('permissions.create',compact('statuses'));
    }

    
    public function store(Request $request)
    {

        $this->validate($request,[
            'name' => 'required|max:50|unique:permissions,name',
            'image' => 'image|mimes:jpg,jpeg,png|max:1024',
            'status_id' => 'required|in:3,4'
        ],[
            'name.required' => 'Name is required',
            'status_id.required' => 'Status is required'
        ]);

        $user = Auth::user();

        $permission = new Permission();
        $permission->name = $request['name'];
        $permission->slug = Str::slug($request['name']);
        $permission->status_id = $request['status_id'];
        $permission->user_id = $user->id;

        $permission->save();

        return redirect(route('permissions.index'));
    }

    
    public function show(string $id)
    {
        $role = Permission::findOrFail($id);
        return view('permissions.show',["role"=>$role]);
    }

    
    public function edit(string $id)
    {
        $permission = Permission::findOrFail($id);
        $statuses = Status::whereIn('id',[3,4])->get();

        return view('permissions.edit')->with("permission",$permission)->with('statuses',$statuses);
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            'name' => ['required','max:50','unique:permissions,name,'.$id],
            'image' => ['image','mimes:jpg,jpeg,png','max:1024'],
            'status_id' => ['required','in:3,4']
        ],[
            'name.required' => 'Name is required',
            'status_id.required' => 'Status is required'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $permission = Permission::findOrFail($id);
        $permission->name = $request['name'];
        $permission->slug = Str::slug($request['name']);
        $permission->status_id = $request['status_id'];
        $permission->user_id = $user->id;

        $permission->save();

        return redirect(route('permissions.index'));
    }

    
    public function destroy(string $id)
    {
        $this->authorize('delete', Permission::class);
        $permission = Permission::findOrFail($id);

        $permission->delete();

        return redirect()->back();
    }

    public function typestatus(Request $request){ 

        $permission = Permission::findOrFail($request['id']);
        $permission->status_id = $request['status_id'];
        $permission->save();

        return response()->json(["success"=>'Status Change Successfully.']);
    }

    public function bulkdeletes(Request $request){
        try{

            $getselectedids = $request->selectedids;
            $permission = Permission::whereIn('id',$getselectedids)->delete();

            return response()->json(['success'=>'Selected data have been deleted successfully.']);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['status'=>'failed','message'=>$e->getMessage()]);
        }
    }
}
