<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Gender;
use App\Models\Lead;
use App\Models\Religion;
use App\Models\Student;
use App\Models\StudentPhone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = auth()->user(); 
        $lead = Lead::findOrFail($user->lead['id']);
        $genders = Gender::orderBy('name','asc')->get();
        $countries = Country::orderBy('name','asc')->where('status_id',3)->get();
        $religions = Religion::orderBy('name','asc')->where('status_id',3)->get();
        $cities = City::orderBy('name','asc')->where('status_id',3)->get();
        $student = null; 
        $studentphones = null; 

        // dd($user);

        if($lead->converted){
            $student = Student::findOrFail($lead->student['id']);
            $studentphones = StudentPhone::where('student_id',$student->id)->get();
        }

        return view('profile.edit', [
            'user' => $request->user(),
            'lead' => $lead, 
            'genders' => $genders, 
            'countries' => $countries, 
            'religions' => $religions,
            'cities' => $cities,
            'student' => $student,
            'studentphones' => $studentphones
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
