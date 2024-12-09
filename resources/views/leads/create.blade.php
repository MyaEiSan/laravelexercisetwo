@extends('layouts.adminindex')
@section('caption','Create Lead')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">
        <div class="col-md-12">
            <form action="/leads" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-3 form-group mb-3">
                        <label for="firstname">First Name <span class="text-danger">*</span></label>
                        <input type="text" name="firstname" id="firstname" class="form-control form-control-sm rounded-0" placeholder="Ener First name" value="{{old('firstname')}}" /> 
                    </div>
                    <div class="col-md-3 form-group mb-3">
                        <label for="lastname">Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="lastname" id="lastname" class="form-control form-control-sm rounded-0" placeholder="Ener Last Name" value="{{old('lastname')}}"/> 
                    </div>   

                    <div class="col-md-3 form-group mb-3">
                        <label for="gender_id">Gender <span class="text-danger">*</span></label>
                        <select name="gender_id" id="gender_id" class="form-control form-control-sm rounded-0">
                            <option selected disabled>Choose a gender</option>
                            @foreach($genders as $gender)
                                <option value="{{$gender['id']}}" {{old('gender_id') == $gender['id']?'selected':''}}>{{$gender['name']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 form-group mb-3">
                        <label for="age">Age <span class="text-danger">*</span></label>
                        <input type="number" name="age" id="age" class="form-control form-control-sm rounded-0" placeholder="Ener your age" value="{{old('age')}}"/> 
                    </div>

                    <div class="col-md-3 form-group mb-3">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control form-control-sm rounded-0" placeholder="Ener your email" value="{{old('email')}}"/> 
                    </div>

                    <div class="col-md-3 form-group mb-3">
                        <label for="country_id">Country <span class="text-danger">*</span></label>
                        <select name="country_id" id="country_id" class="form-control form-control-sm rounded-0 country_id">
                            <option selected disabled>Choose a country</option>
                            @foreach($countries as $country)
                                <option value="{{$country['id']}}" {{old('country_id') == $country['id']?'selected':''}}>{{$country['name']}}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-3 form-group mb-3">
                        <label for="city_id">City <span class="text-danger">*</span></label>
                        <select name="city_id" id="city_id" class="form-control form-control-sm rounded-0 city_id">
                            <option selected disabled>Choose a city</option>
                            {{-- @foreach($cities as $city)
                                <option value="{{$city['id']}}">{{$city['name']}}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                            <a href="{{route('leads.index')}}" class="btn btn-secondary btn-sm rounded-0">Cancel</a>
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
    });
    </script>
@endsection