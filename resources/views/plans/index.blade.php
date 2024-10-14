@extends('layouts.adminindex')
<!--Start Content Area-->
@section('content')
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Plan Management</h2>
            <p>Discover our popular services.</p>
        </div>
        <div class="loader-container">

            <div id="packagedata" class="row">

            </div>
            <div class="loader">
                <div class="loader-item"></div>
                <div class="loader-item"></div>
                <div class="loader-item"></div>
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

        // Start Passing Header Token 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        })
        // End Passing Header Token 

        // Start Fetch All Data
        function fetchallpackages(){
            $.ajax({
                url: "{{route('plans.index')}}", 
                method:"GET", 
                beforeSend: function(){
                    $('.loader').addClass('show');
                },
                success: function(response){
                    
                    $("#packagedata").html(response);
                    
                }, 
                complete: function(){
                    $('.loader').removeClass('show');
                }
            });
        }

        fetchallpackages();
        // End Fetch All Data

        // Start Add Cart Package

        $(document).on('click','.add-to-cart',function(){
            
            const packageid = $(this).data('package-id');
            const packageprice = $(this).data('package-price'); 

            $.ajax({
                url: "{{route('carts.add')}}", 
                type: 'POST', 
                data: {
                    package_id : packageid, 
                    quantity: 1, 
                    price: packageprice
                },
                success: function(response){
                    console.log(response.message);
                }
            });


        });


        // End Add Cart Package

        })
</script>
@endsection