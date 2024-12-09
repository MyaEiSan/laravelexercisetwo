{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}


@extends('layouts.adminindex')
@section('caption','Student List')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">
        <div class="col-md-12">

            <a href="javascript:void(0);" id="btn-back" class="btn btn-secondary btn-sm rounded-0">Back</a>
            <a href="#" class="btn btn-primary btn-sm rounded-0">Close</a>

            <hr/>

            <div class="row">
                <div class="col-md-4 col-lg-3 mb-2">
                    <h6>Info</h6>
                    <div class="card border-0 rounded-0 shadow">

                        <div class="card-body">
                           
                            <div class="d-flex flex-column align-items-center mb-3">
                                @if($user->lead['converted'])
                                    <form action="{{route('students.updateprofilepicture',$user->student->id)}}" method="post" enctype="multipart/form-data">
    
                                    @csrf 
                                    @method('put')
    
                                        
                                    <div class="form-group col-md-12 text-center">
                                        <label for="image" class="gallery">
                                            @if ($user->student['image']) 
                                                <img src="{{asset($user->student->image)}}" alt="{{$user->name}}" class="img-thumbnail" width="100" height="100" />
                                            @else
                                                <span>Choose Images</span>
                                            @endif
                                        </label>
                                        <input type="file" name="image" id="image"  class="form-control form-control-sm rounded-0" value="{{old('image',$user->student->image)}}" hidden/> 
                                        <button type="submit" id="uploadbtn" class="btn btn-primary btn-sm text-ms rounded-0">Upload</button>
                                    </div>
                                    </form>
                                @endif
                                <h6 class="my-1">{{$user->name}}</h6>
                            </div>

                            <div  class="mb-5">
                                <div class="row g-0 mb-2">
                                    <div class="col-auto">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="col ps-3">
                                        <div class="row">
                                            <div class="col">
                                                <div class="">Pipe Status</div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="">
                                                    <span class="badge {{$user->lead['converted']? 'bg-success': 'bg-danger'}}">Pipeline</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                @if($user->lead['converted']) 
                                    <div class="row g-0 mb-2">
                                        <div class="col-auto">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="col ps-3">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="">Account Status</div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="">
                                                        <span class="badge {{$user->lead['converted']? 'bg-success': 'bg-danger'}}">Pipeline</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-0">
                                        <div class="progress" style="height: 9px" aria-valuenow="{{$user->student['profile_score']}}">
                                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width: {{$user->student['profile_score']}}%">{{$user->student['profile_score']}}%</div>
                                        </div>
                                    </div>
                                @endif

                            </div>

                            <div  class="mb-5">
                                <p class="text-small text-muted text-uppercase mb-2">Personal Info</p>
                               
                                <div class="row g-0 mb-2">
                                    <div class="col-auto me-2">
                                        <i class="fas fa-address-card"></i>
                                    </div>
                                    <div class="col">{{$user->email}}</div>
                                </div>
                                <div class="row g-0 mb-2">
                                    <div class="col-auto me-2">
                                        <i class="fas fa-info"></i>
                                    </div>
                                    <div class="col">{{$user->lead->leadnumber}}</div>
                                </div>
                                <div class="row g-0 mb-2">
                                    <div class="col-auto me-2">
                                        <i class="fas fa-venus"></i>
                                    </div>
                                    <div class="col">{{$user->gender}}</div>
                                </div>
                                <div class="row g-0 mb-2">
                                    <div class="col-auto me-2">
                                        <i class="fas fa-flag"></i>
                                    </div>
                                    <div class="col">{{$user->lead->city['name']}} | {{$user->lead->country['name']}}</div>
                                </div>

                                <div class="row g-0 mb-2">
                                    <div class="col-auto me-2">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                    <div class="col">{{date('d M Y h:i:s A',strtotime($user->lead['created_at']))}}</div>
                                </div>

                                <div class="row g-0 mb-2">
                                    <div class="col-auto me-2">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div class="col">{{date('d M Y h:i:s A',strtotime($user->lead['updated_at']))}}</div>
                                </div>

                            </div>
                        </div>

                        
                    </div>
                </div>
                <div class="col-md-8 col-lg-9">
                    <h6>Compose</h6>
                    <div class="card border-0 rounded-0 shadow mb-4">
                        <div class="card-body">
                            <div class="accordion">
                                <div class="acctitle">Email</div>
                                <div class="acccontent">
                                    <div class="col-md-12 py-3">
                                        <form action="" method="POST">
                                            @csrf 
                                            <div class="row">
                                                <div class="col-md-6 from-group mb-3">
                                                    <input type="email" name="cmpemail" id="cmpemail" class="form-control from-control-sm border-0 rounded-0" placeholder="To:" value="" readonly/>
                                                </div>
                                                <div class="col-md-6 from-group mb-3">
                                                    <input type="text" name="cmpsubject" id="cmpsubject" class="form-control from-control-sm border-0 rounded-0" placeholder="Subject:" value=""/>
                                                </div>
                                                <div class="col-md-12 from-group mb-2">
                                                    <textarea  name="cmpcontent" id="cmpcontent" class="form-control from-control-sm border-0 rounded-0" rows="3" style="resize:none;" placeholder="Your message here..."></textarea>
                                                </div>
                                                <div class="col d-flex justify-content-end align-items-end">
                                                    <button type="submit" class="btn btn-secondary btn-sm rounded-0">Send</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                
                    <h6>Enrolls</h6>
                    <div class="card border-0 rounded-0 shadow mb-4">
                        <div class="card-body d-flex flex-wrap gap-3">

                           
                        </div>
                    </div>

                    <h6>Additional Info</h6>
                    <div class="card border-0 rounded-0 shadow mb-4">
                        <ul class="nav">
                            <li class="nav-item">
                                <button type="button" id="autoclick" class="tablinks" onclick="gettab(event,'personaltab')">Personal</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" id="autoclick" class="tablinks" onclick="gettab(event,'leadtab')">Lead</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="tablinks" onclick="gettab(event,'studenttab')">Student</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="tablinks" onclick="gettab(event,'linktab')">Linked</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="tablinks" onclick="gettab(event,'signintab')">Sign In</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="tablinks" onclick="gettab(event,'logtab')">Log</button>
                            </li>
                        </ul>
                
                        <div class="tab-content">
                
                            <div id="personaltab" class="tab-pane">
                                <h3>This is Home information.</h3>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            </div>

                            <div id="leadtab" class="tab-pane">
                                <h3>Lead Information</h3>
                                <form action="/leads/{{$lead->id}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-3 form-group mb-3">
                                            <label for="firstname">First Name <span class="text-danger">*</span></label>
                                           
                                            <input type="text" name="firstname" id="firstname" class="form-control form-control-sm rounded-0" placeholder="Ener First name" value="{{$lead->firstname}}" /> 
                                        </div>
                                        <div class="col-md-3 form-group mb-3">
                                            <label for="lastname">Last Name <span class="text-danger">*</span></label>
                                            
                                            <input type="text" name="lastname" id="lastname" class="form-control form-control-sm rounded-0" placeholder="Ener Last Name" value="{{$lead->lastname}}"/> 
                                        </div>
                                        <div class="col-md-3 form-group mb-3">
                                            <label for="gender_id">Gender <span class="text-danger">*</span></label>
                                            <select name="gender_id" id="gender_id" class="form-control form-control-sm rounded-0">
                                                <option selected disabled>Choose a gender</option>
                                                @foreach($genders as $gender)
                                                    <option value="{{$gender['id']}}" {{$gender['id'] == old('gender_id',$lead->gender_id) ?'selected':''}}>{{$gender['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                    
                                        <div class="col-md-3 form-group mb-3">
                                            <label for="age">Age <span class="text-danger">*</span></label>
                                            <input type="number" name="age" id="age" class="form-control form-control-sm rounded-0" placeholder="Ener your age" value="{{old('age',$lead->age)}}"/> 
                                        </div>
                    
                                        <div class="col-md-3 form-group mb-3">
                                            <label for="email">Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" id="email" class="form-control form-control-sm rounded-0" placeholder="Ener your email" value="{{old('email',$lead->email)}}"/> 
                                        </div>
                    
                                        <div class="col-md-3 form-group mb-3">
                                            <label for="country_id">Country <span class="text-danger">*</span></label>
                                            <select name="country_id" id="country_id" class="form-control form-control-sm rounded-0 country_id">
                                                <option selected disabled>Choose a country</option>
                                                @foreach($countries as $country)
                                                    <option value="{{$country['id']}}" {{$country['id'] == old('country_id',$lead->country_id)?'selected':''}}>{{$country['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                    
                    
                                        <div class="col-md-3 form-group mb-3">
                                            <label for="city_id">City <span class="text-danger">*</span></label>
                                            <select name="city_id" id="city_id" class="form-control form-control-sm rounded-0 city_id">
                                                <option selected disabled>Choose a city</option>
                                                @foreach($cities as $city)
                                                    <option value="{{$city['id']}}" {{$city['id'] == old('city_id',$lead->city_id)?'selected':''}}>{{$city['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                    
                                        @if($lead->isconverted())
                                            <small class="text-danger">This lead have already been converted to a student. Editing is disabled.</small>
                                        @endif
                                       
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary btn-sm rounded-0 ms-3" {{$lead->isconverted()?'disabled':''}}>Update</button>
                                            </div>
                                        </div>
                                    </div>
                    
                                </form>
                            </div>

                            <div id="studenttab" class="tab-pane">
                                <h3>Student Information</h3>
                                @if($lead['converted'])
                                    <form action="/students/{{$student->id}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-3 form-group mb-3">
                                                <label for="editfirstname">First Name <span class="text-danger">*</span></label>
                                                @error('editfirstname')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                                <input type="text" name="editfirstname" id="editfirstname" class="form-control form-control-sm rounded-0" placeholder="Ener First name" value="{{$student->firstname}}" /> 
                                            </div>
                                            <div class="col-md-3 form-group mb-3">
                                                <label for="editlastname">Last Name <span class="text-danger">*</span></label>
                                                @error('editlastname')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                                <input type="text" name="editlastname" id="editlastname" class="form-control form-control-sm rounded-0" placeholder="Ener Last Name" value="{{$student->lastname}}"/> 
                                            </div>
                                            <div class="col-md-3 form-group mb-3">
                                                <label for="editgender_id">Gender <span class="text-danger">*</span></label>
                                                <select name="editgender_id" id="editgender_id" class="form-control form-control-sm rounded-0">
                                                    <option selected disabled>Choose a gender</option>
                                                    @foreach($genders as $gender)
                                                        <option value="{{$gender['id']}}" {{$gender['id'] == old('editgender_id',$student->gender_id) ?'selected':''}}>{{$gender['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                        
                                            <div class="col-md-3 form-group mb-3">
                                                <label for="editage">editage <span class="text-danger">*</span></label>
                                                <input type="number" name="editage" id="editage" class="form-control form-control-sm rounded-0" placeholder="Ener your age" value="{{old('editage',$student->age)}}"/> 
                                            </div>

                                            <div class="col-md-3 form-group mb-3">
                                                <label for="editdob">Date of Birth <span class="text-danger">*</span></label>
                                                <input type="date" name="editdob" id="editdob" class="form-control form-control-sm rounded-0" placeholder="Ener your dob" value="{{old('editdob',$student->dob)}}" /> 
                                            </div>

                                            <div class="col-md-3 form-group mb-3">
                                                <label for="editreligion_id">Religion <span class="text-danger">*</span></label>
                                                <select name="editreligion_id" id="editreligion_id" class="form-control form-control-sm rounded-0 editreligion_id">
                                                    <option selected disabled>Choose a religion</option>
                                                    @foreach($religions as $religion)
                                                        <option value="{{$religion['id']}}" {{$religion['id'] == old('editreligion_id',$student->religion_id)?'selected':''}}>{{$religion['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                        
                                            <div class="col-md-3 form-group mb-3">
                                                <label for="editemail">Email <span class="text-danger">*</span></label>
                                                <input type="email" name="editemail" id="editemail" class="form-control form-control-sm rounded-0" placeholder="Ener your email" value="{{old('editemail',$student->email)}}" readonly/> 
                                            </div>

                                            <div class="col-md-3 form-group mb-3">
                                                <label for="editnational_id">National Id <span class="text-danger">*</span></label>
                                                <input type="text" name="editnational_id" id="editnational_id" class="form-control form-control-sm rounded-0" placeholder="Ener your national" value="{{old('editnational_id',$student->nationalid)}}"/> 
                                            </div>
                        
                                            <div class="col-md-3 form-group mb-3">
                                                <label for="editcountry_id">Country <span class="text-danger">*</span></label>
                                                <select name="editcountry_id" id="editcountry_id" class="form-control form-control-sm rounded-0 editcountry_id">
                                                    <option selected disabled>Choose a country</option>
                                                    @foreach($countries as $country)
                                                        <option value="{{$country['id']}}" {{$country['id'] == old('editcountry_id',$student->country_id)?'selected':''}}>{{$country['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3 form-group mb-3">
                                                <label for="editregion_id">Region <span class="text-danger">*</span></label>
                                                <select name="editregion_id" id="editregion_id" class="form-control form-control-sm rounded-0 editregion_id" data-selected="{{old('editregion_id',$student->region_id)}}">
                                                    <option selected disabled>Choose a region</option>
                                                    {{-- @foreach($regions as $region)
                                                        <option value="{{$region['id']}}" {{$region['id'] == old('region_id',$student->region_id)?'selected':''}}>{{$region['name']}}</option>
                                                    @endforeach --}}
                                                </select>
                                            </div>
                        
                                            <div class="col-md-3 form-group mb-3">
                                                <label for="editcity_id">City <span class="text-danger">*</span></label>
                                                <select name="editcity_id" id="editcity_id" class="form-control form-control-sm rounded-0 editcity_id" data-selected="{{old('editcity_id',$student->city_id)}}">
                                                    <option selected disabled>Choose a city</option>
                                                    {{-- @foreach($cities as $city)
                                                        <option value="{{$city['id']}}" {{$city['id'] == old('editcity_id',$student->city_id)?'selected':''}}>{{$city['name']}}</option>
                                                    @endforeach --}}
                                                </select>
                                            </div>

                                            <div class="col-md-3 form-group mb-3">
                                                <label for="edittownship_id">Township <span class="text-danger">*</span></label>
                                                <select name="edittownship_id" id="edittownship_id" class="form-control form-control-sm rounded-0 edittownship_id" data-selected="{{old('edittownship_id',$student->township_id)}}">
                                                    <option selected disabled>Choose a township</option>
                                                    {{-- @foreach($townships as $township)
                                                        <option value="{{$township['id']}}" {{$township['id'] == old('edittownship_id',$student->township_id)?'selected':''}}>{{$township['name']}}</option>
                                                    @endforeach --}}
                                                </select>
                                            </div>
                        
                                            <div class="col-md-3 form-group mb-3">
                                                <label for="editregnumber">Register Number <span class="text-danger">*</span></label>
                                                @error('regnumber')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                                <input type="text" name="editregnumber" id="editregnumber" class="form-control form-control-sm rounded-0" placeholder="Ener Register Number" value="{{$student->regnumber}}"/> 
                                            </div>

                                            <div class="col-md-3 form-group mb-3">
                                                <label for="editaddress">Address <span class="text-danger">*</span></label>
                                                <input type="text" name="editaddress" id="editaddress" class="form-control form-control-sm rounded-0" placeholder="Ener your address" value="{{old('editaddress',$student->address)}}"/> 
                                            </div>

                                            <div id="multiphone" class="col-md-3 form-group mb-3 editpage">
                                                <label for="phone">Phone</label>
                                                @if($studentphones->isEmpty())
                                                <div class="input-group phonelimit">
                                                    <input type="text" name="newphone[]" id="phone" class="form-control form-control-sm rounded-0 phone" placeholder="Enter Mobile Number" value="{{old('phone')}}" />
                                                    <span id="addphone" class="input-group-text" style="font-size:10px;cursor: pointer; "><i class="fas fa-plus-circle"></i></span>
                                                </div>  
                                                @else
                                            
                                                @foreach($studentphones as $studentphone)
                                                
                                                    <input type="hidden" name="studentphones[]" value="{{$studentphone->id}}" />
                                                    <div class="input-group phonelimit">
                                                        <input type="text" name="phone[]" id="phone" class="form-control form-control-sm rounded-0 phone" placeholder="Enter Mobile Number" value="{{old('phone',$studentphone->phone)}}" />
                                                        <a class="input-group-text" href="{{route('studentphones.delete',$studentphone->id)}}">
                                                            <span style="font-size: 10px;cursor: pointer; remove-phone-btn"><i class="fas fa-minus-circle text-danger"></i></span>
                                                        </a>
                                                        <span id="addphone" class="input-group-text" style="font-size:10px;cursor: pointer; "><i class="fas fa-plus-circle text-success"></i></span>
                                                    </div>
                                                @endforeach 

                                                @endif
                                            </div>
                                            <div class="col-md-12 form-group mb-3">
                                                <label for="remark">Remark</label>
                                                <textarea name="remark" id="remark" class="form-control rounded-0" rows="5" placeholder="Enter Remark">{{$student->remark}}</textarea> 
                                            </div>

                                            @if($user->student->isProfileLocked())
                                                <small class="text-danger">This profile is locked because profile score is 100%.</small>
                                            @endif
                                            
                                            <div class="col-md-12">
                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary btn-sm rounded-0 ms-3" {{$user->student->isProfileLocked()?'disabled':''}}>Submit</button>
                                                </div>
                                            </div>
                                        </div>
                        
                                    </form>
                                @else  
                                    <div>No Data</div>      
                                @endif
                            </div>
                
                            <div id="linktab" class="tab-pane">
                                <h3>Linked App</h3>
                                <div class="card rounded-0">
                            
                                    <div id="displayone" class="card-body">
                                        <img src="https://www.pngall.com/wp-content/uploads/5/User-Profile-PNG.png" class="rounded-circle" alt="user" style="width:150px;height:150px;" />
                                        <h3 class="card-title">User Name</h3>
                                        <p class="card-subtitle">Hello World...</p>
                                        <ul class="list-group">
                                            <li class="list-group-item">Repositories : <span>100</span></li>
                                            <li class="list-group-item">Follower : <span>200</span></li>
                                            <li class="list-group-item">Following : <span>300</span></li>
                                        </ul>
                                    </div>
                                    <div id="displaytwo" class="card-footer">
                                        <div class="dropdown float-end">
                                            <a href="javascript:void(0);" class="btn btn-success btn-sm rounded-0 dropdown-toggle" data-bs-toggle="dropdown">Repository Link</a>
                                            <ul id="displaylistgroup" class="dropdown-menu">
                                                <!-- <li><a href="#" class="dropdown-item" target="_blank">Sample Link</a></li> -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="signintab" class="tab-pane">
                                <h3>Sign-in Password</h3>
                                <div class="col-md-4 mx-auto">
                                    <form class="mt-3" action="{{ route('password.update') }}" method="POST">
                                        @csrf 
                                        @method('put')
                                       
                                        <div class="form-group mb-3">
                                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Current Password" value="{{old('current_password')}}" autofocus />
                                            @error('current_password')
                                                <span class="invalid-feedback">
                                                    <strong>{{$message}}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="New Password" value="{{old('password')}}" autofocus />
                                            @error('password')
                                                <span class="invalid-feedback">
                                                    <strong>{{$message}}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password" value="{{old('password_confirmation')}}" autofocus />
                                            @error('password_confirmation')
                                                <span class="invalid-feedback">
                                                    <strong>{{$message}}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    
                                        <div class="float-end ">
                                            <button type="submit" class="btn btn-info rounded-0">Save Change</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div id="logtab" class="tab-pane">
                                <h3>This is Contact information.</h3>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            </div>
                
                            <div id="remark" class="tab-pane">
                                
                                
                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>
    {{-- End Page Content  --}}
@endsection

@section('css')
<style type="text/css">
/* Start Accordion  */
.accordion{
	width: 100%;
}

.acctitle{
	font-size: 14px;
	user-select: none;

	padding: 5px;
	margin: 0;

	cursor: pointer;

	position: relative;
}


.acctitle::after{
	content: '\f0e0'; /* + */
	font-family: "Font Awesome 5 Free";

	/*position: absolute;
	right: 15px;
	top: 50%;
	transform: translateY(-50%);*/

	float: right;
}

.shown.acctitle::after{
	content: '\f2b6';
}

/* .active::after{
	content: '\f068';
} */

.acccontent{
	height: 0;
	background-color: #f4f4f4;
	
	text-align: justify;
	font-size: 14px;

	padding: 0 10px;

	overflow: hidden;

	transition: height 0.3s ease-in-out;
}
/* End Accordion  */
    .nav{
        display: flex;
        background-color: #f1f1f1;
        border: 1px solid #ccc;

        padding: 0;
        margin: 0;
    }

    .nav .nav-item{
        list-style-type: none;
    }

    .nav .tablinks{
        border: none;
        padding: 15px 20px;
        cursor: pointer;

        transition: background-color .3s ease-in;
    }

    .nav .tablinks:hover{
        background-color: #f3f3f3;
    }

    .nav .tablinks.active{
        color: blue;
    }


    .tab-pane{
        padding: 5px 15px;

        display: none;
    }

    /* End Tab Box  */

    /* Start profile image  */

    .gallery{
			width: 100%;
            height: 100%;
			background-color: #eee;
			color: #aaa;
            
            display: flex;
            justify-content: center;
            align-items: center;

			text-align: center;
			padding: 10px;
		}

		.gallery img{
			width: 100px;
			height: 100px;
			border: 2px dashed #aaa;
			border-radius: 10px;
			object-fit: cover;

			padding: 5px;
			margin: 0 5px;
		}

        #uploadbtn{
            display: none;
        }

		.removetxt span{
			display: none;
		}

    /* End Profile Image  */


</style>
@endsection

@section('scripts')

<script type="text/javascript">

$(document).ready(function(){

    // get regions by country 
    $(document).on('change','.editcountry_id',function(){
        const getcountryid = $(this).val();

        let opforregion = "";
        let opforcity = "";
        let opfortownship = "";

        $.ajax({
            url:   `/api/filter/regions/${getcountryid}`, 
            type: 'GET', 
            dataType: 'json', 
            success: function(response){

                $(".editregion_id").empty();
                $(".editcity_id").empty();
                $(".edittownship_id").empty();

                opforregion += `<option selected disabled>Choose a region</option>`;
                opforcity += `<option selected disabled>Choose a city</option>`;
                opfortownship += `<option selected disabled>Choose a township</option>`;

                
                for(let x = 0; x < response.data.length; x++){
                    opforregion +=`<option value="${response.data[x].id}">${response.data[x].name}</option>`;
                }

                $(".editregion_id").append(opforregion);
                $(".editcity_id").append(opforcity);
                $(".edittownship_id").append(opfortownship);

            }, 
            error: function(response){
                console.log("Error : ",response);
            }
        });
    });

    
    // get city by region 
    $(document).on('change','.editregion_id',function(){
        const getregionid = $(this).val();

        let opforcity = "";
        let opfortownship = "";

        $.ajax({
            url:   `/api/filter/cities/${getregionid}`, 
            type: 'GET', 
            dataType: 'json', 
            success: function(response){

                $(".editcity_id").empty();
                $(".edittownship_id").empty();

                opforcity += `<option selected disabled>Choose a city</option>`;
                opfortownship += `<option selected disabled>Choose a township</option>`;

                
                for(let x = 0; x < response.data.length; x++){
                    opforcity +=`<option value="${response.data[x].id}">${response.data[x].name}</option>`;
                }

                $(".editcity_id").append(opforcity);
                $(".edittownship_id").append(opfortownship);

            }, 
            error: function(response){
                console.log("Error : ",response);
            }
        });
    });

    // get township by city 
    $(document).on('change','.editcity_id',function(){
        const getcityid = $(this).val();

        let opfortownship = "";

        $.ajax({
            url:   `/api/filter/townships/${getcityid}`, 
            type: 'GET', 
            dataType: 'json', 
            success: function(response){

                $(".edittownship_id").empty();

                opfortownship += `<option selected disabled>Choose a township</option>`;

                
                for(let x = 0; x < response.data.length; x++){
                    opfortownship +=`<option value="${response.data[x].id}">${response.data[x].name}</option>`;
                }

                $(".edittownship_id").append(opfortownship);

            }, 
            error: function(response){
                console.log("Error : ",response);
            }
        });
    });

    // Start Auto Selected Dynamic Select 

    const countryid = $('#editcountry_id').val(); 
    const regionid = $("#editregion_id").data('selected');
    const cityid = $("#editcity_id").data('selected');
    const townshipid = $("#edittownship_id").data('selected');

    // console.log(countryid,regionid,cityid,townshipid);

    if(countryid){
        loadregions(countryid,regionid,cityid,townshipid);
    }

    function loadregions(countryid,regionid,cityid,townshipid){
        let opforregion = "";

        $.ajax({
            url:   `/api/filter/regions/${countryid}`, 
            type: 'GET', 
            dataType: 'json', 
            success: function(response){

                $(".editregion_id").empty();

                opforregion += `<option selected disabled>Choose a region</option>`;

                for(let x = 0; x < response.data.length; x++){
                    opforregion +=`<option value="${response.data[x].id}" ${response.data[x].id == regionid? 'selected':''}>${response.data[x].name}</option>`;
                }

                $(".editregion_id").html(opforregion);

                loadcities(regionid,cityid,townshipid)

            }, 
            error: function(response){
                console.log("Error : ",response);
            }
        });
    }

    function loadcities(regionid,cityid,townshipid){
        let opforcity = "";

        $.ajax({
            url:   `/api/filter/cities/${regionid}`, 
            type: 'GET', 
            dataType: 'json', 
            success: function(response){

                $(".editcity_id").empty();

                opforcity += `<option selected disabled>Choose a city</option>`;

                for(let x = 0; x < response.data.length; x++){
                    opforcity +=`<option value="${response.data[x].id}" ${response.data[x].id == cityid? 'selected':''}>${response.data[x].name}</option>`;
                }

                $(".editcity_id").html(opforcity);

                if(cityid){
                    loadtownships(cityid,townshipid)
                }

            }, 
            error: function(response){
                console.log("Error : ",response);
            }
        });
    }

    function loadtownships(cityid,townshipid){
        let opfortownship = "";

        $.ajax({
            url:   `/api/filter/townships/${cityid}`, 
            type: 'GET', 
            dataType: 'json', 
            success: function(response){

                $(".edittownship_id").empty();

                opfortownship += `<option selected disabled>Choose a city</option>`;

                // for(let x = 0; x < response.data.length; x++){
                //     opfortownship +=`<option value="${response.data[x].id}" ${response.data[x].id == townshipid? 'selected':''}>${response.data[x].name}</option>`;
                // }

                response.data.forEach(township=>{
                    opfortownship +=`<option value="${township.id}" ${township.id == townshipid? 'selected':''}>${township.name}</option>`;
                });

                $(".edittownship_id").html(opfortownship);

            }, 
            error: function(response){
                console.log("Error : ",response);
            }
        });
    }

    // End Auto Selected Dynamic Select 

})

// Start Back Btn 
    const getbtnback = document.getElementById('btn-back');
    getbtnback.addEventListener('click',function(){
        // window.history.back();
        window.history.go(-1);
    });
// End Back Btn 

// Start Tab Box 

    var gettablinks = document.getElementsByClassName('tablinks'); //HTML Collection
    var gettabpanes = document.getElementsByClassName('tab-pane');

    var tabpanes = Array.from(gettabpanes);

    function gettab(evn,linkid){

        // console.log(evn.target);
        // console.log(linkid);

        tabpanes.forEach(function(tabpane){
            tabpane.style.display = "none";
        });

        for(var x=0; x < gettablinks.length; x++){
            gettablinks[x].className = gettablinks[x].className.replace(" active","");
        }

        document.getElementById(linkid).style.display = "block";

        // evn.target.className += " active";
        // evn.target.className = evn.target.className.replace("tablinks","tablinks active");
        // evn.target.classList.add('active');

        // console.log(evn);
        // console.log(evn.target);
        // console.log(evn.currentTarget);
        evn.currentTarget.className += " active";
    }

    document.getElementById('autoclick').click();

// End Tab Box 

// Start Accordion
    var getacctitles = document.getElementsByClassName("acctitle");
    // console.log(getacctitles); //HTML Collection
    var getacccontents = document.querySelectorAll(".acccontent");
    // console.log(getacccontent); //NodeList


    for(var x = 0; x < getacctitles.length; x++){
        // console.log(x);

        getacctitles[x].addEventListener('click',function(e){
            // console.log(e.target);
            // console.log(this);

            this.classList.toggle("shown");
            var getcontent = this.nextElementSibling;
            // console.log(getcontent);

            if(getcontent.style.height){
                getcontent.style.height = null; //beware can't set 0
            }else{
                // console.log(getcontent.scrollHeight);
                getcontent.style.height= getcontent.scrollHeight + "px";
            }
            
        });

        if(getacctitles[x].classList.contains("shown")){
            getacccontents[x].style.height = getacccontents[x].scrollHeight+"px";
        }

    }
// End Accordion 

// Note :: do not forget to put createpage or editpage / phone 

    $(document).on('click', '#addphone', function(){addnewinput();});

    function addnewinput(){
        const maxnumber = 5; 
        let getphonelimit = $(".phonlimit").length;
        let newinput; 

        if($("#multiphone").hasClass('editpage')){
            newinput =     `
                <div class="input-group phonelimit">
                    <input type="text" name="newphone[]" class="form-control form-control-sm rounded-0 phone" placeholder="Enter Mobile Number" value="" />
                    <span class="input-group-text remove-phone-btn" style="font-size:10px;cursor: pointer; "><i class="fas fa-minus-circle text-danger"></i></span>
                </div>
            `;

            $("#multiphone").append(newinput);
        }
    }

    // remove ui for new input 
    $(document).on('click','.remove-phone-btn',function(){
        $(this).parent().remove();
    })


    var previewimages = function(input,output){

        // console.log(input.files);
        if(input.files){
            var totalfiles = input.files.length;
            console.log(totalfiles);

            if(totalfiles > 0){
                $(output).addClass("removetxt");
            }else{
                $(output).removeClass("removetxt");
            }

            for(var i = 0; i< totalfiles; i++){
                var filereader = new FileReader();

                filereader.onload = function(e){
                    $(output).html('');
                    $($.parseHTML("<img/>")).attr("src",e.target.result).appendTo(output);
                }

                filereader.readAsDataURL(input.files[i]);
            }

            $("#uploadbtn").show();
        }
    };

    $("#image").change(function(){
        previewimages(this,'.gallery');
    });

     // End Add /Remove Phone for (creagepage / editpage)
        const getdisplayone = document.getElementById("displayone");
        const getdisplaytwo = document.getElementById("displaytwo");
        const getdisplaylistgroup = document.getElementById("displaylistgroup");

        const baseurl = `https://api.github.com`;

        emailtouser("myaeisan722@gmail.com");

        async function emailtouser(email){

            try{
                const response = await axios.get(`${baseurl}/search/commits?q=author-email:${email}`); 
                const datas = response.data.items;

                if(datas.length > 0){
                    const username = datas[0].author.login;
                    // console.log(username);
                    getresult(username);

                }else{
                    getdisplayone.innerHTML = `<div class="alert alert-danger text-center">No data found for this email !</div>`;
                }

            }catch(err){
                // console.log(err);
                getdisplayone.innerHTML = `<div class="alert alert-danger text-center">No data found for this email !</div>`;
            }

            
        }


        
        const url = `https://api.github.com/users/`;

        async function getresult(username){

            try{
                const response = await axios.get(`${baseurl}/users/${username}`);

                const {data} = response; 
                // console.log(data);
                cardbodytodom(data);
                await resultrepos(username);

            }catch(err){
                // console.log(err); 
                if(err.response && err.response.status === 404){
                    getdisplayone.innerHTML = `
                    <div class="alert alert-danger text-center">No Data Found</div>
                    `;
                    getdisplaylistgroup.innerHTML = `
                    <li><a href="javascript:void(0);" class="dropdown-item">No Data</a></li>
                    `;
                }
            }

            
        }

        function cardbodytodom(user){
            getdisplayone.innerHTML = `
                    <img src="${user.avatar_url}" class="rounded-circle" alt="user" />
                    <h3 class="card-title">${user.name}</h3>
                    <p class="card-subtitle">${user.bio}</p>
                    <ul class="list-group">
                        <li class="list-group-item">Repositories : <span>${user.public_repos}</span></li>
                        <li class="list-group-item">Follower : <span>${user.followers}</span></li>
                        <li class="list-group-item">Following : <span>${user.following}</span></li>
                    </ul>
            `;
        }

        async function resultrepos(username){

            try{
                const response = await axios.get(`${baseurl}/users/${username}/repos`);
                const data = response.data;
                cardfootertodom(data);
            }catch(err){
                console.log('Error fetching repositories',err);
            }
        }

        function cardfootertodom(repositories){

            getdisplaylistgroup.innerHTML = '';

            repositories.forEach(repository=>{
                getdisplaylistgroup.innerHTML += `
                <li><a href="${repository.html_url}" class="dropdown-item" target="_blank">${repository.name}</a></li>
                `;
            })
        }


            
</script>

@endsection

<!--End Content Area-->
