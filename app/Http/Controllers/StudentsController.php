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
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class StudentsController extends Controller
{
   
    public function index()
    {
        $students = Student::all();
        return view('students.index',compact('students'));
    }

   
    public function create()
    {
        return view('students.create');
    }

   
    public function store(Request $request)
    {
        
        $this->validate($request,[
            'regnumber' => 'required|unique:students,regnumber',
            'firstname' => 'required',
            'lastname' => 'required',
            'remark' => 'max:1000'
        ],[
            'regnumber.required' => 'Register number is required',
            'firstname.required' => 'First name is required',
            'lastname.required' => 'Last name is required'
        ]);

        $user = Auth::user();
        $user_id = $user->id;

        $student = new Student();
        $student->regnumber = $request['regnumber'];
        $student->firstname = $request['firstname'];
        $student->lastname = $request['lastname'];
        $student->slug = Str::slug($request['firstname']);
        $student->remark = $request['remark'];
        $student->user_id = $user_id;
        $student->save();

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
        $student = Student::findOrFail($id);
        return view('students.edit')->with("student",$student);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'regnumber' => 'required|unique:students,regnumber,'.$id,
            'firstname' => 'required',
            'lastname' => 'required',
            'remark' => 'max:1000'
        ],[
            'regnumber.required' => 'Register number is required',
            'firstname.required' => 'First name is required',
            'lastname.required' => 'Last name is required'
        ]);

        $user = Auth::user();
        $user_id = $user->id;

        $student = Student::findOrFail($id);
        $student->regnumber = $request['regnumber'];
        $student->firstname = $request['firstname'];
        $student->lastname = $request['lastname'];
        $student->slug = Str::slug($request['firstname']);
        $student->remark = $request['remark'];
        $student->user_id = $user_id;
        $student->save();

        return redirect(route('students.index'));
    }

    
    public function destroy($id)
    {
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

        // Mail::to($data['to'])->send(new StudentMailBox($data));
        dispatch(new StudentMailBoxJob($data));

        return redirect()->back();
    }
}
