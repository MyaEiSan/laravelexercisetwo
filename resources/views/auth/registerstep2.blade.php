@extends('layouts.auth.authindex')
@section('caption','Personal Info')
@section('content')

<form id="stepform" class="mt-3" action="{{route('register.storestep2')}}" method="POST">
    @csrf 
    <div class="form-group mb-3">
        <input type="text" name="firstname" class="form-control @error('firstname') is-invalid @enderror" placeholder="First name" value="{{old('firstname')}}" autofocus />
    </div>

    <div class="form-group mb-3">
        <input type="text" name="lastname" class="form-control @error('lastname') is-invalid @enderror" placeholder="Last name" value="{{old('lastname')}}" autofocus />
    </div>

    <div class="form-group mb-3">
        <label for="gender_id">Gender <span class="text-danger">*</span></label>
        <select name="gender_id" id="gender_id" class="form-control form-control-sm rounded-0">
            <option selected disabled>Choose a gender</option>
            @foreach($genders as $gender)
                <option value="{{$gender['id']}}">{{$gender['name']}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="age">Age <span class="text-danger">*</span></label>
        <input type="number" name="age" id="age" class="form-control form-control-sm rounded-0" placeholder="Ener your age" value="{{old('age')}}"/> 
    </div>
    
    <div class="d-grid">
        <button type="submit" class="btn btn-info rounded-0">Next</button>
    </div>
</form>

@endsection