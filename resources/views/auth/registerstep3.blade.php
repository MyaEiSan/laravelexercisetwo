@extends('layouts.auth.authindex')
@section('caption','Access')
@section('content')

<form id="stepform"  class="mt-3" action="{{route('register.storestep3')}}" method="POST">
    @csrf 
    <div class="form-group mb-3">
        <label for="country_id">Country <span class="text-danger">*</span></label>
        <select name="country_id" id="country_id" class="form-control form-control-sm rounded-0 country_id">
            <option selected disabled>Choose a country</option>
            @foreach($countries as $country)
                <option value="{{$country['id']}}">{{$country['name']}}</option>
            @endforeach
        </select>
    </div>


    <div class="form-group mb-3">
        <label for="city_id">City <span class="text-danger">*</span></label>
        <select name="city_id" id="city_id" class="form-control form-control-sm rounded-0 city_id">
            <option selected disabled>Choose a city</option>
        </select>
    </div>
    
    <div class="d-grid">
        <button type="submit" class="btn btn-info rounded-0">Sign Up</button>
    </div>
</form>

@endsection

