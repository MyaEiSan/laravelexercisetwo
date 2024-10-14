<?php

namespace App\Http\Controllers;

use App\Mail\StudentMailBox;
use App\Models\City;
use App\Models\Country;
use App\Models\Gender;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class LeadsController extends Controller
{
    
   
    public function index()
    {
        $leads = Lead::all();
        return view('leads.index',compact('leads'));
    }

   
    public function create()
    {
        $genders = Gender::orderBy('name','asc')->get();
        $countries = Country::orderBy('name','asc')->where('status_id',3)->get(); 
        return view('leads.create',compact('genders','countries'));
    }

   
    public function store(Request $request)
    {
        
        $this->validate($request,[
            'firstname' => 'required',
            'lastname' => 'required',
            'gender_id' => 'required|exists:genders,id', 
            'age' => 'required|numeric', 
            'email' => 'required|string|email|max:100|unique:leads', 
            'country_id' => 'required|exists:countries,id', 
            'city_id' => 'required|exists:cities,id'
            
        ]);

        $user = Auth::user();
        $user_id = $user->id;

        $lead = new Lead();
        $lead->firstname = $request['firstname'];
        $lead->lastname = $request['lastname'];
        
        $lead->gender_id = $request['gender_id'];
        $lead->age = $request['age'];
        $lead->email = $request['email'];
        $lead->country_id = $request['country_id'];
        $lead->city_id = $request['city_id'];
        $lead->user_id = $user_id;
        $lead->save();

       
        return redirect(route('leads.index'));

    }

    
    public function show($id)
    {
        $lead = Lead::findOrFail($id);
        // $enrolls = $lead->enrolls();
        return view('leads.show',["lead"=>$lead]);
    }

   
    public function edit($id)
    {
        $lead = Lead::findOrFail($id);
        $genders = Gender::orderBy('name','asc')->get();
        $countries = Country::orderBy('name','asc')->where('status_id',3)->get();
        $cities = City::orderBy('name','asc')->where('country_id',$lead->country_id)->where('status_id',3)->get(); 
        return view('leads.edit')->with("lead",$lead)->with("genders",$genders)->with("countries",$countries)->with("cities",$cities);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'firstname' => 'required',
            'lastname' => 'required',
            'gender_id' => 'required|exists:genders,id', 
            'age' => 'required|numeric', 
            'email' => 'required|string|email|max:100|unique:leads,email,'.$id, 
            'country_id' => 'required|exists:countries,id', 
            'city_id' => 'required|exists:cities,id'
            
        ]);

        $user = Auth::user();
        $user_id = $user->id;

        $lead = Lead::findOrFail($id);
        $lead->firstname = $request['firstname'];
        $lead->lastname = $request['lastname'];
        
        $lead->gender_id = $request['gender_id'];
        $lead->age = $request['age'];
        $lead->email = $request['email'];
        $lead->country_id = $request['country_id'];
        $lead->city_id = $request['city_id'];
        $lead->user_id = $user_id;

        if($lead->isconverted()){
            return redirect()->back()->with('error','Editing is disabled.');
        }


        $lead->save();

       

        session()->flash('success','Update Successfully');
        return redirect(route('leads.index'));
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

   

    public function quicksearch(Request $request){

        $students = "";

        if($request->keyword != ""){
            $students = Lead::where("regnumber",'LIKE','%'.$request->keyword.'%')->get();                   
        }

        return response()->json(['datas'=>$students]);
    }

    public function converttostudent($id){
        $lead = Lead::findOrFail($id); 
        $lead->coverttostudent(); 

        session()->flash('success','Pipe Successfully');
        return redirect()->back();
    }

}
