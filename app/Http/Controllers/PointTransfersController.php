<?php

namespace App\Http\Controllers;

use App\Models\PointsTransfer;
use App\Models\PointTransferHistory;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PointTransfersController extends Controller
{
    public function index(){

        if(request()->ajax()){
            $pointtransferhistories = PointTransferHistory::all();

            return view('pointtransfers.list',compact('pointtransferhistories'))->render();
        }
        
        return view('pointtransfers.index');
    }

    public function transfer(Request $request){

        $request->validate([
            'receiver_id' => 'required|exists:users,id', 
            'points' => 'required|integer|min:1'
        ]);

        $sender = Auth::user(); 
        $receiver = User::find($request->input('receiver_id')); 
        $points = $request->input('points'); 

        if($sender->id == $receiver->id){
            return response()->json(['message'=>'You cannot transfer points to yourself.'],400);
        }


        if($sender->userpoint->points < $points){
            return response()->json(['message'=>'Insufficient points'],400);
        }

        // Begin a database transaction 

        DB::beginTransaction();

        try{

            // Deduct points from sender 
            $sender->userpoint->points -= $points; 
            $sender->userpoint->save();

            // Add points to receiver
            
            $receiver->userpoint->points += $points; 
            $receiver->userpoint->save();


            // Point Transition Record  
            PointsTransfer::create([
                'sender_id' => $sender->id, 
                'receiver_id' => $receiver->id, 
                'points' => $points
            ]);

             // Commit the transaction 
             DB::commit();

            return response()->json(['message'=>'Point transferred successfully.']);

        }catch(Exception $err){

            // Rollback the transaction 
            DB::rollBack();

            return response()->json(['message'=>'Error occurred while transferring points','error'=>$err->getMessage()],500);
        }
    }
}
