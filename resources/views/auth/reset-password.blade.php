@include('layouts.auth.authheader')
<div id="app">
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="col-3 bg-white p-4">
            <h5>New Password</h5>
           <div class="row">
                
                <form class="mt-3" action="{{route('password.store')}}" method="POST">
                    @csrf 
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <div class="form-group mb-3">
                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{old('email')}}" autofocus />
                        @error('email')
                            <span class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" value="{{old('password')}}" autofocus />
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
                
                    <div class="d-grid">
                        <button type="submit" class="btn btn-info rounded-0">Reset Password</button>
                    </div>
                </form>
           </div>
        </div>
    </div>
</div>
@include('layouts.auth.authfooter')