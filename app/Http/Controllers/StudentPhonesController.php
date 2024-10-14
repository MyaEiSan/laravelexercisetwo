<?php

namespace App\Http\Controllers;

use App\Models\StudentPhone;
use Illuminate\Http\Request;

class StudentPhonesController extends Controller
{
    public function destroy($id){
        $studentphone = StudentPhone::find($id); 
        $studentphone->delete(); 
        session()->flash('success','Successfully Deleted');
        return redirect()->back();
    }
}
