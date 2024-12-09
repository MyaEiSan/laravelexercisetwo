<?php

namespace App\Http\Controllers;

use App\Models\StudentPhone;
use Illuminate\Http\Request;

class StudentPhonesController extends Controller
{
    public function destroy($id){
        $studentphone = StudentPhone::find($id); 
       

        $student = $studentphone->student; 

        // check if the profile is locked 
        if($student->isProfileLocked()){
            return redirect()->back()->with('error','Profile locked. Please contact to admin');
        }

        $studentphone->delete();
        
         // Recalculate Profile Score 
         if($student){
            $student->calculateProfileScore();
         }

        session()->flash('success','Successfully Deleted');
        return redirect()->back();
    }
}
