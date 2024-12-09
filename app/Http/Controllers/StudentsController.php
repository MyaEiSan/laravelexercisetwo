<?php

namespace App\Http\Controllers;

use App\Jobs\MailBoxJob;
use App\Jobs\StudentMailBoxJob;
use App\Models\Enroll;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Mail\MailBox;
use App\Mail\StudentMailBox;
use App\Models\City;
use App\Models\Country;
use App\Models\Gender;
use App\Models\Region;
use App\Models\StudentPhone;
use App\Models\Township;
use Exception;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StudentsController extends Controller
{
   
    public function index()
    {
        $this->authorize('view', Student::class);
        $students = Student::all();
        return view('students.index',compact('students'));
    }

   
    public function create()
    {
        $this->authorize('create', Student::class);
        return view('students.create');
    }

   
    public function store(Request $request)
    {
        
        $this->validate($request,[
            // 'regnumber' => 'required|unique:students,regnumber',
            'firstname' => 'required',
            'lastname' => 'required',
            'remark' => 'max:1000'
        ],[
            // 'regnumber.required' => 'Register number is required',
            'firstname.required' => 'First name is required',
            'lastname.required' => 'Last name is required'
        ]);

        $user = Auth::user();
        $user_id = $user->id;

        $student = new Student();
        // $student->regnumber = $request['regnumber'];
        $student->firstname = $request['firstname'];
        $student->lastname = $request['lastname'];
        $student->slug = Str::slug($request['firstname']);
        $student->remark = $request['remark'];
        $student->user_id = $user_id;
        $student->save();

        // Create New Student 

        // Method 1 
        // if(!empty($request['phone'])){

        //     foreach($request['phone'] as $key=>$phone){
        //         $phonedatas = [
        //             'student_id' => $student['id'], 
        //             'phone' => $phone
        //         ];
        //         StudentPhone::insert($phonedatas);
        //     }
        // }

        // Method 2  
        foreach($request->phone as $phone){
            $student->studentphones()->create([
                'student_id' => $student['id'], 
                'phone' => $phone
            ]);
        }

        return redirect(route('students.index'));

    }

    
    public function show($id)
    {
        $student = Student::findOrFail($id);
        $enrolls = $student->enrolls();
        return view('students.show',["student"=>$student,"enrolls"=>$enrolls]);
    }

   
    public function edit($id)
    {
        $this->authorize('edit', Student::class);
        $student = Student::findOrFail($id);
        $studentsphones = StudentPhone::where('student_id',$id)->get();
        $genders = Gender::orderBy('name','asc')->get();
        $countries = Country::orderBy('name','asc')->where('status_id',3)->get();
        $regions = Region::orderBy('name','asc')->where('status_id',3)->get();
        $cities = City::orderBy('name','asc')->where('status_id',3)->get(); 
        $townships = Township::orderBy('name','asc')->where('status_id',3)->get(); 
        return view('students.edit')->with("student",$student)->with("studentphones",$studentsphones)->with("genders",$genders)->with("countries",$countries)->with("regions",$regions)->with("cities",$cities)->with("townships",$townships);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'editfirstname' => 'required',
            'editlastname' => 'required',
            'remark' => 'max:1000'
        ]);

        $user = Auth::user();
        $user_id = $user->id;

        $student = Student::findOrFail($id);

        // check if the profile is locked 
        if($student->isProfileLocked()){
            return redirect()->back()->with('error','Profile locked. please contact to admin');
        }


        $student->firstname = $request['editfirstname'];
        $student->lastname = $request['editlastname'];
        $student->slug = Str::slug($request['editfirstname']);
        $student->gender_id = $request['editgender_id'];
        $student->age = $request['editage'];
        $student->dob = $request['editdob']; 
        $student->religion_id = $request['editreligion_id']; 
        $student->email = $request['editemail'];
        $student->nationalid = $request['editnational_id'];
        $student->country_id = $request['editcountry_id'];
        $student->region_id = $request['editregion_id'];
        $student->city_id = $request['editcity_id'];
        $student->township_id = $request['edittownship_id'];;
        $student->address = $request['editaddress'];
        $student->remark = $request['remark'];
        $student->user_id = $user_id;
        $student->save();

        // Create / Update New Student Phone 
        //  if(!empty($request->newphone)){

        //     // extend new phone 

        //     foreach($request['newphone'] as $key=>$phone){
        //         $phonedatas = [
        //             'student_id' => $student['id'], 
        //             'phone' => $phone
        //         ];
        //         StudentPhone::insert($phonedatas);

                
        //     }

        //     // extend new phone and update existing phone in same time 
        //     if($request['phone']){
        //         foreach($request['phone'] as $key=>$phone ){
        //             StudentPhone::findOrFail($request['studentphones'][$key])->update([
        //                 'phone' => $phone
        //             ]);
        //         }
        //     }

            
        // }else{
        //     // update existing phone 

        //     foreach($request['phone'] as $key=>$phone){
        //         StudentPhone::findOrFail($request['studentphones'][$key])->update([
        //             'phone' => $phone
        //         ]);
        //     }
        // }

        // Handling Student Phone Update / Create 

        if($request->has('newphone')){
            $newphones = $request->newphone; 

            // insert new phone numbers 
            foreach($newphones as $newphone){
                StudentPhone::create([
                    'student_id' => $student->id, 
                    'phone' => $newphone
                ]);
            }
        }

        // Update Existing Student Phone 

        if($request->has('phone') && $request->has('studentphoneid')){
            foreach($request->phone as $key=>$phone){
                if(!empty(trim($phone)) && isset($request->studentphoneid['$key'])){
                    $getphoneid = $request->studentphoneid[$key]; 
                    StudentPhone::findOrFail($request->studentphoneid[$key])->update([
                        'phone'=> $phone
                    ]);
                }
            }
        }

        // Recalculate Profile Score 
        $student->calculateProfileScore();

        session()->flash('success','Successfully Updated');
        return redirect()->route('students.index');
    }

    
    public function destroy($id)
    {
        $this->authorize('delete', Student::class);
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->back();
    }

    public function mailbox(Request $request){
        // dd($request['cmpcontent']);

        // => Method 1 (to MailBox)
        // $to = $request['cmpemail'];
        // $subject = $request['cmpsubject'];
        // $content = $request['cmpcontent'];

        //  Mail::to($to)->send(new MailBox($subject,$content));
        // Mail::to($to)->cc('admin@dlt.com')->send(new MailBox($subject,$content));
        // Mail::to($to)->cc('admin@dlt.com')->bcc("info@dlt.com")->send(new MailBox($subject,$content));

        // Using Job Method 1 (to MailBox)
        // dispatch(new MailBoxJob($to,$subject,$content));

        // => Mehtod 2 ( to StudentMailBox )
        // $data["to"] = $request['cmpemail'];
        // $data["subject"] = $request['cmpsubject'];
        // $data["content"] = $request['cmpcontent'];

        $data = [
            "to" => $request['cmpemail'],
            "subject" => $request['cmpsubject'],
            "content" => $request['cmpcontent']
        ];

        Mail::to($data['to'])->send(new StudentMailBox($data));
        // dispatch(new StudentMailBoxJob($data));

        return redirect()->back();
    }

    public function bulkdeletes(Request $request){
        try{

            $getselectedids = $request->selectedids;
            $student = Student::whereIn('id',$getselectedids)->delete();

            return response()->json(['success'=>'Selected data have been deleted successfully.']);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['status'=>'failed','message'=>$e->getMessage()]);
        }
    }

    public function quicksearch(Request $request){

        $students = "";

        if($request->keyword != ""){
            $students = Student::where("regnumber",'LIKE','%'.$request->keyword.'%')->get();                   
        }

        return response()->json(['datas'=>$students]);
    }

    public function updateprofilepicture(Request $request, $id){
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $user_id = $user['id'];

        $student = Student::findOrFail($id);

        
        if($request->hasFile('image')){

            // Single Image Upload 
            $file = $request->file('image');
            $fname = $file->getClientOriginalName();
            $imagenewname = uniqid($user_id).$student['id'].$fname;
            $file->move(public_path('assets/img/posts/'),$imagenewname);
            $filepath = "assets/img/posts/".$imagenewname;

            // Remove Old Image 
            if($student->image){
                $oldfilepath = public_path($student->image);

                if(file_exists($oldfilepath)){
                    unlink($oldfilepath);
                }
            }
            $student->image = $filepath;

            $student->save();
        }

     

        return redirect()->back()->with('success','Upload Successful');
    }

}
