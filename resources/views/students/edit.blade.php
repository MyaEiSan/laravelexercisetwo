@extends('layouts.adminindex')
@section('caption','Edit Student')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">
        <div class="col-md-12">
            <form action="/students/{{$student->id}}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-3 form-group mb-3">
                        <label for="firstname">First Name <span class="text-danger">*</span></label>
                        @error('firstname')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="text" name="firstname" id="firstname" class="form-control form-control-sm rounded-0" placeholder="Ener First name" value="{{$student->firstname}}" /> 
                    </div>
                    <div class="col-md-3 form-group mb-3">
                        <label for="lastname">Last Name <span class="text-danger">*</span></label>
                        @error('lastname')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="text" name="lastname" id="lastname" class="form-control form-control-sm rounded-0" placeholder="Ener Last Name" value="{{$student->lastname}}"/> 
                    </div>
                    <div class="col-md-3 form-group mb-3">
                        <label for="gender_id">Gender <span class="text-danger">*</span></label>
                        <select name="gender_id" id="gender_id" class="form-control form-control-sm rounded-0">
                            <option selected disabled>Choose a gender</option>
                            @foreach($genders as $gender)
                                <option value="{{$gender['id']}}" {{$gender['id'] == old('gender_id',$student->gender_id) ?'selected':''}}>{{$gender['name']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 form-group mb-3">
                        <label for="age">Age <span class="text-danger">*</span></label>
                        <input type="number" name="age" id="age" class="form-control form-control-sm rounded-0" placeholder="Ener your age" value="{{old('age',$student->age)}}"/> 
                    </div>

                    <div class="col-md-3 form-group mb-3">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control form-control-sm rounded-0" placeholder="Ener your email" value="{{old('email',$student->email)}}"/> 
                    </div>

                    <div class="col-md-3 form-group mb-3">
                        <label for="country_id">Country <span class="text-danger">*</span></label>
                        <select name="country_id" id="country_id" class="form-control form-control-sm rounded-0 country_id">
                            <option selected disabled>Choose a country</option>
                            @foreach($countries as $country)
                                <option value="{{$country['id']}}" {{$country['id'] == old('country_id',$student->country_id)?'selected':''}}>{{$country['name']}}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-3 form-group mb-3">
                        <label for="city_id">City <span class="text-danger">*</span></label>
                        <select name="city_id" id="city_id" class="form-control form-control-sm rounded-0 city_id">
                            <option selected disabled>Choose a city</option>
                            @foreach($cities as $city)
                                <option value="{{$city['id']}}" {{$city['id'] == old('city_id',$student->city_id)?'selected':''}}>{{$city['name']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 form-group mb-3">
                        <label for="regnumber">Register Number <span class="text-danger">*</span></label>
                        @error('regnumber')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="text" name="regnumber" id="regnumber" class="form-control form-control-sm rounded-0" placeholder="Ener Register Number" value="{{$student->regnumber}}"/> 
                    </div>
                    <div id="multiphone" class="col-md-3 form-group mb-3 editpage">
                        <label for="phone">Phone</label>
                        @if(count($studentphones) > 0)
                        @foreach($studentphones as $studentphone)
                            <input type="hidden" name="studentphones[]" value="{{$studentphone->id}}" />
                            <div class="input-group phonelimit">
                                <input type="text" name="phone[]" id="phone" class="form-control form-control-sm rounded-0 phone" placeholder="Enter Mobile Number" value="{{old('phone',$studentphone)}}" />
                                @if($studentphone->count() > 1) 
                                    <a class="input-group-text" href="{{route('studentphones.delete',$studentphone->id)}}">
                                        <span style="font-size: 10px;cursor: pointer; removephone"><i class="fas fa-minus-circle text-danger"></i></span>
                                    </a>
                                @endif
                                <span id="addphone" class="input-group-text" style="font-size:10px;cursor: pointer; "><i class="fas fa-plus-circle text-success"></i></span>
                            </div>
                        @endforeach 
                        @else
                        <div class="input-group phonelimit">
                            <input type="text" name="newphone[]" id="phone" class="form-control form-control-sm rounded-0 phone" placeholder="Enter Mobile Number" value="{{old('phone')}}" />
                            <span id="addphone" class="input-group-text" style="font-size:10px;cursor: pointer; "><i class="fas fa-plus-circle"></i></span>
                        </div>   
                        @endif
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="remark">Remark</label>
                        <textarea name="remark" id="remark" class="form-control rounded-0" rows="5" placeholder="Enter Remark">{{$student->remark}}</textarea> 
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                            <a href="{{route('students.index')}}" class="btn btn-secondary btn-sm rounded-0">Cancel</a>
                            <button type="submit" class="btn btn-primary btn-sm rounded-0 ms-3">Submit</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
    {{-- End Page Content  --}}
@endsection
<!--End Content Area-->

@section('scripts') 
<script type="text/javascript">
$(document).ready(function(){
    // Start Add /Remove Phone for (creagepage / editpage)
            // Note :: do not forget to put createpage or editpage / phone 

            $(document).on('click', '#addphone', function(){
                addnewinput();
            });

            function addnewinput(){
                const maxnumber = 5; 
                let getphonelimit = $(".phonlimit").length;
                let newinput; 

                if($("#multiphone").hasClass('editpage')){
                    newinput =     `
                     <div class="input-group phonelimit">
                            <input type="text" name="newphone[]" id="phone" class="form-control form-control-sm rounded-0 phone" placeholder="Enter Mobile Number" value="" />
                            <span class="input-group-text removephone" style="font-size:10px;cursor: pointer; "><i class="fas fa-minus-circle text-danger"></i></span>
                        </div>
                    `;

                    $("#multiphone").append(newinput);
                }
            }

            // remove ui for new input 
            $(document).on('click','.removephone',function(){
                $(this).parent().remove();
            })

        // End Add /Remove Phone for (creagepage / editpage)


        $(document).on('change','.country_id',function(){
            const getcountryid = $(this).val();

            let opforcity = "";

            $.ajax({
                url:   `/api/filter/cities/${getcountryid}`, 
                type: 'GET', 
                dataType: 'json', 
                success: function(response){

                    $(".city_id").empty();

                    opforcity += `<option selected disabled>Choose a city</option>`;
                    opforregion += `<option selected disabled>Choose a region</option>`;

                    for(let x = 0; x < response.data.length; x++){
                        opforcity +=`<option value="${response.data[x].id}">${response.data[x].name}</option>`;
                    }

                    $(".city_id").append(opforcity);

                }, 
                error: function(response){
                    console.log("Error : ",response);
                }
            });
        });
})
</script>
@endsection