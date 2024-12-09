<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Models\Status;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class WarehousesController extends Controller
{
    public function index()
    {
        $this->authorize('view', Warehouse::class);
        $warehouses = Warehouse::paginate(5);
        $statuses = Status::whereIn('id',[3,4])->get();
        return view('warehouses.index',compact('warehouses','statuses'));
    }

    public function create()
    {
        $this->authorize('create', Warehouse::class);
        $statuses = Status::whereIn('id',[3,4])->get();
        return view('warehouses.create',compact('statuses'));
    }

    
  

    
    public function show(string $id)
    {
        $warehouse = Warehouse::findOrFail($id);
        return view('paymentmemethods.show',["wareh$warehouse"=>$warehouse]);
    }

    
    public function edit(string $id)
    {
        $warehouse = Warehouse::findOrFail($id);
        return response()->json($warehouse);
    }

    public function typestatus(Request $request){ 

        $warehouse = Warehouse::findOrFail($request['id']);
        $warehouse->status_id = $request['status_id'];
        $warehouse->save();

        return response()->json(["success"=>'Status Change Successfully.']);
    }

    public function fetchalldatas()
    {
        try{
            $warehouse = Warehouse::all();
        return response()->json(["status"=>"status","data"=>$warehouse]);
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(["status"=>"failed","message"=>$e->getMessage()]);
        }
    }

    public function bulkdeletes(Request $request){
        try{

            $getselectedids = $request->selectedids;
            $warehouse = Warehouse::whereIn('id',$getselectedids)->delete();

            return response()->json(['success'=>'Selected data have been deleted successfully.']);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['status'=>'failed','message'=>$e->getMessage()]);
        }
    }
}
