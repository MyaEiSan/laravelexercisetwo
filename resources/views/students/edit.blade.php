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
                        <label for="editage">Age <span class="text-danger">*</span></label>
                        <input type="number" name="editage" id="editage" class="form-control form-control-sm rounded-0" placeholder="Ener your age" value="{{old('editage',$student->age)}}"/> 
                    </div>

                    <div class="col-md-3 form-group mb-3">
                        <label for="editemail">Email <span class="text-danger">*</span></label>
                        <input type="email" name="editemail" id="editemail" class="form-control form-control-sm rounded-0" placeholder="Ener your email" value="{{old('editemail',$student->email)}}"/> 
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
                        <select name="editregion_id" id="editregion_id" class="form-control form-control-sm rounded-0 editregion_id">
                            <option selected disabled>Choose a region</option>
                            @foreach($regions as $region)
                                <option value="{{$region['id']}}" {{$region['id'] == old('editregion_id',$student->region_id)?'selected':''}}>{{$region['name']}}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-3 form-group mb-3">
                        <label for="editcity_id">City <span class="text-danger">*</span></label>
                        <select name="editcity_id" id="editcity_id" class="form-control form-control-sm rounded-0 editcity_id">
                            <option selected disabled>Choose a city</option>
                            @foreach($cities as $city)
                                <option value="{{$city['id']}}" {{$city['id'] == old('editcity_id',$student->city_id)?'selected':''}}>{{$city['name']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 form-group mb-3">
                        <label for="edittownship_id">Township <span class="text-danger">*</span></label>
                        <select name="edittownship_id" id="edittownship_id" class="form-control form-control-sm rounded-0 edittownship_id">
                            <option selected disabled>Choose a township</option>
                            @foreach($townships as $township)
                                <option value="{{$township['id']}}" {{$township['id'] == old('edittownship_id',$student->township_id)?'selected':''}}>{{$township['name']}}</option>
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
})
</script>
@endsection