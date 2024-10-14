@extends('layouts.adminindex')
<!--Start Content Area-->
@section('content')
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Subscription  Expired</h2>
            <p>Your subscription has expired. Please contact to admin or <a href="{{route('plans.index')}}">click here</a> to renew your subscription.</p>
        </div>
    </div>
@endsection
<!--End Content Area-->

@section('css')
 
@endsection

@section('scripts')

@endsection