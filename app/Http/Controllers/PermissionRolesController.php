<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PermissionRolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissionroles = PermissionRole::with('role','permission')->orderBy('id','asc')->paginate(10);
        $permissions = Permission::whereIn('status_id',[3,4])->get(['name','id']);
        $roles = Role::whereIn('status_id',[3,4])->get(['name','id']);

        return view('permissionroles.index',compact('permissionroles','permissions','roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|array', 
            'permission_id.*' => 'exists:permissions,id'
        ]);

        $role = Role::findOrFail($request['role_id']); 
        $role->permissions()->sync($request['permission_id']);

        return redirect(route('permissionroles.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            'editrole_id' => 'required|exists:roles,id',
            'editpermission_id' => 'required|exists:permissions,id',
        ]);

        $permissionrole = PermissionRole::findOrFail($id);
        $permissionrole->role_id = $request['editrole_id'];
        $permissionrole->permission_id = $request['editpermission_id'];
        $permissionrole->save();

        return redirect(route('permissionroles.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permissionrole = PermissionRole::findOrFail($id);
        $permissionrole->delete();

        return redirect()->back();
    }

    public function bulkdeletes(Request $request){
        try{

            $getselectedids = $request->selectedids;
            $permissionrole = PermissionRole::whereIn('id',$getselectedids)->delete();

            return response()->json(['success'=>'Selected data have been deleted successfully.']);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['status'=>'failed','message'=>$e->getMessage()]);
        }
    }
}
