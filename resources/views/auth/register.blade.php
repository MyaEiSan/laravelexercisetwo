

@include('layouts.adminheader')
<div id="app">
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="bg-white p-4">
            <h5>Sign In</h5>
            <form class="mt-3" action="{{route('login')}}" method="POST">
                @csrf 
                <div class="form-group mb-3">
                    <input type="text" name="firstname" class="form-control @error('firstname') is-invalid @enderror" placeholder="Email" value="{{old('firstname')}}" autofocus />
                </div>

                <div class="form-group mb-3">
                    <input type="text" name="lastname" class="form-control @error('lastname') is-invalid @enderror" placeholder="Username" value="{{old('lastname')}}" autofocus />
                </div>

                <div class="form-group mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" value="{{old('password')}}" />
                </div>

                <div class="form-group mb-3">
                    <input type="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Password Confirmation" value="{{old('password_confirmation')}}" />
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

            {{-- social login  --}}
            <div class="row">
                <small class="text-center text-muted mt-3">Sign up with</small>
                <div class="col-12 mt-2 text-center">
                    <a href="javascript:void(0);" class="" title="Login with Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="javascript:void(0);" class="" title="Login with Facebook"><i class="fab fa-google"></i></a>
                    <a href="javascript:void(0);" class="" title="Login with Facebook"><i class="fab fa-twitter"></i></a>
                    <a href="javascript:void(0);" class="" title="Login with Facebook"><i class="fab fa-github"></i></a>
                </div>
            </div>

            {{-- login  --}}
            <div class="row">
                <div class="col-12 mt-2 text-center">
                    <small>Already have an account ?<a href="{{route('login')}}" class="text-primary ms-1">Sign In</a></small>
                </div>
            </div>

            {{-- data policy  --}}
            <div class="row">
                <div class="col-12 mt-2 text-center text-muted">
                    <small>By clicking Sign Up, you agree to our <a href="{{route('login')}}" class="text-primary ms-1">Terms</a>, <a href="{{route('login')}}" class="text-primary ms-1">Data Policy</a> and <a href="{{route('login')}}" class="text-primary ms-1">Cookie Policy</a> You may receive SMS notification from us.</small>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.adminfooter')