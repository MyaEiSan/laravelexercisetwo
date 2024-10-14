
@include('layouts.adminheader')
<div id="app">
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="col-3 bg-white p-4">
            <h6>Email Verification</h6>

            <div class="row">
                <div>
                    <p>Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>
                </div>
                @if (session('status') == 'verification-link-sent')
                    <small class="text-sm text-info mb-4 ">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </small>
                @endif

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <div class="d-grid">
                        <button type="submit" class="btn btn-info rounded-0">Resend Verification Email</button>
                    </div>
                </form>

                <div class="text-center mt-2">
                    <small>Don't have an account ?</small>
                    <form action="{{route('logout')}}" method="POST">
                        @csrf 
                        <a href="{{route('logout')}}" onclick="event.preventDefault(); this.closest('form').submit();" class="small">Sing Out</a>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@include('layouts.adminfooter')