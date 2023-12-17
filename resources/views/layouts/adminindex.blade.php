@include('layouts.adminheader')


<div>
    <!--Start Site Setting-->
    <div id="sitesettings" class="sitesettings">
    	<div class="sitesettings-item"><a href="javascript:void(0);" id="sitetoggle" class="sitetoggle"><i class="fas fa-cog ani-rotates"></i></a></div>
    </div>
    <!--End Site Setting-->
    
    {{-- Start Left Sidebar  --}}

        @include('layouts.adminleftsidebar')

   {{-- End Left Sidebar --}}

   <!--Start Content Area-->
   <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10 col-md-9 ms-auto  pt-md-5 mt-md-3">
                    {{-- Start Inner Content Area --}}
                    <div class="row">
                        <h5>@yield('caption')</h5>
                        @yield('content')
                    </div>
                    {{-- End Inner Content Area  --}}
                </div>
            </div>
        </div>
   </section>
   <!--Start Content Area-->
</div>

@include('layouts.adminfooter')