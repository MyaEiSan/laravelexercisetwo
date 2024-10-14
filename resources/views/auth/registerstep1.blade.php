@extends('layouts.auth.authindex')
@section('caption','Access')
@section('content')

<p>owsedfji</p>

<form id="stepform"  class="mt-3" action="{{route('register.storestep1')}}" method="POST">
    @csrf 
    <div class="form-group mb-3">
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{old('email')}}" />
    </div>

    <div class="form-group mb-3">
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" value="{{old('password')}}" />
    </div>

    <div class="form-group mb-3">
        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Password Confirmation" value="{{old('password_confirmation')}}" />
    </div>
    
    <div class="d-grid">
        <button type="submit" class="btn btn-info rounded-0">Next</button>
    </div>
</form>

@endsection