@extends('layouts.adminindex')
<!--Start Content Area-->
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <h6><a href="{{route('plans.index')}}" class="nav-link">Continue Shopping</a></h6>
                <hr/>
                <div class="text-center">
                    <span>You have {{$userdata->carts()->count()}} items in your cart</span>
                </div>

                @foreach ($carts as $idx=>$cart)
                    <div data-packageid="{{$cart->package['id']}}" class="d-flex justify-content-between align-items-center p-2 mt-3 package" data-packageid="{{$cart->package->name}}">
                        <div class="">
                            <span>{{++$idx}}</span>
                            <span>{{$cart->package['name']}}</span>
                            <span>{{$cart->package['duration']}} days</span>
                        </div>
                        <div class="">
                            <span class="quantity">{{$cart->quantity}} qty</span>
                        </div>
                        <div class="">
                            <span class="me-5">{{$cart->price}}</span>
                            <a href="javascript:void(0);" id="removefromcart" data-packageid="{{$cart->package['id']}}">
                                <i class="fas fa-trash-alt text-danger"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-md-4">
                <h6>Payment details</h6>
                <hr/>

                <div class="d-flex justify-content-between">
                    <span>Total</span>
                    <span>{{$totalcost}}</span>
                </div>

                <div class="d-flex justify-content-between">
                    <span>Payment Method</span>
                    <span>Point Pay</span>
                </div>
                
                <div class="d-grid mt-3">
                    <button type="button" id="paybypoints" class="btn btn-primary btn-sm rounded-0">Pay Now</button>
                </div>

            </div>
        </div>
    </div>

    <div id="otpmodal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form id="verifyform" action="" method="">
                        <div class="row">

                            <div class="form-group col-md-12 mb-3">
                                <label for="otpcode">OTP Code <span class="text-danger">*</span></label>
                                <input type="text" name="otpcode" id="otpcode" class="form-control form-control-sm rounded-0" placeholder="Ener your OTP" /> 
                            </div>

                            <input type="hidden" name="otpuser_id" id="otpuser_id" value="{{$userdata['id']}}" />

                            <div class="col-md-2 text-end mb-3">
                                <button type="submit" class="btn btn-primary btn-sm rounded-0">Submit</button>
                            </div>
                            
                        </div>
                        <p id="otpmessage">Expires in : <span id="otptimer"></span> seconds</p>
        
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

@endsection
<!--End Content Area-->

@section('css')
<link href="{{asset('assets/dist/css/loader.css')}}" rel="stylesheet" />
 
@endsection

@section('scripts')
    <script type="text/javascript">
        
        $(document).ready(function(){


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                }
            })
           
            // Remove from cart 
            $(document).on('click', '#removefromcart', function(){
                
                const packageid = $(this).data('packageid');

                $.ajax({
                    url: "{{route('carts.remove')}}", 
                    type: 'POST', 
                    data: {
                        _token: "{{csrf_token()}}", 
                        packageid: packageid
                    }, 
                    success: function(response){
                        console.log(response.message);

                        // UI remove 
                        // $('#package_'+packageid).remove();
                        $('div[id="package_'+packageid+'"]').remove()
                    },
                    error:function(response){
                        console.log(response);
                    }
                });
            });
        });

         // Start Pay by Points 

                $("#paybypoints").click(function(){

                    Swal.fire({
                        title: "Processing...",
                        text: "Please wait while we send your otp",
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: '/generateotps', 
                        type: 'POST', 
                        success: function(response){
                            console.log(response);

                            // $("#otpmessage").text('Your OTP  code is : '+response.otp);

                            $("#otpmodal").modal('show');

                            startotptimer(60); // OTP will expires in 300 (5 minutes)

                            Swal.close();

                        }, 
                        error: function(response){
                            console.log("Error :",response);
                        }
                    });

                    function startotptimer(duration){

                        let timeleft = duration; 

                        let setinv = setInterval(dectimer,1000); 

                        function dectimer(){
                            timeleft--; 

                            $("#otptimer").text(timeleft); 

                            if(timeleft <= 0){
                                clearInterval(setinv);
                                $("#otpmodal").modal('hide');
                            }
                        }

                     } 

                    $("#verifyform").on('submit', function(e){
                        e.preventDefault(); 
                        $.ajax({
                            url: '/verifyotps', 
                            type: 'POST', 
                            data: $(this).serialize(), 
                            success: function(response){

                                if(response.message){

                                    let packageid;

                                    $('.package').each(function(){
                                        packageid = $(this).data('packageid');
                                        
                                        $.ajax({
                                            url: "{{route('carts.paybypoints')}}", 
                                            type: 'POST', 
                                            data:{
                                                _token: $('meta[name="csrf-token"]').attr('content'),
                                                packageid: packageid
                                            }, 
                                            success: function(response){
                                                window.alert(response.message);
                                                Swal.fire({
                                                    title: "Deleted!",
                                                    text: "Your file has been deleted.",
                                                    icon: "success"
                                                });
                                                location.reload();
                                            }, 
                                            error: function(error){
                                                console.log(error);
                                            }
                                        })
                                    })

                                    $("#otpmodal").modal('hide');

                                }else{
                                    console.log('Invalid OTP');
                                }
                                
                            }, 
                            error: function(response){
                                console.log('Error OTP :', response);
                            }
                        });
                    });

                })

        // End Pay by Points 

        
    </script>
@endsection