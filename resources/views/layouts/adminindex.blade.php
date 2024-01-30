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
                        {{-- <h6>@yield('caption')</h6> --}}
                        {{-- <h6>{{ucfirst(Request::path())}}</h6> --}}

                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{Request::root()}}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{url()->previous()}}">{{Str::title(preg_replace('/[[:punct:]]+[[:alnum:]]+/','',str_replace(Request::root().'/','',url()->previous())))}}</a></li>
                                <li class="breadcrumb-item active">{{ucfirst(Request::path())}}</li>
                            </ol>
                        </nav>

                        {{-- http://localhost:8000/edulinks?filter=4&search=19 --}}

                        {{-- {{str_replace(Request::root().'/','',url()->previous())}}  --}}
                        {{--edulinks?filter=4&search=19 --}}

                        {{-- {{Str::title(preg_replace('/[[:punct:]]+[[:alnum:]]+/','',str_replace(Request::root().'/','',url()->previous())))}} --}}
                         {{-- Edulinks --}}

                        {{-- Str::title() = ucfirst() --}}


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


{{--<p>{{Request::root()}}</p>http://localhost:8000--}}
                            {{--<p>{{Request::fullUrl()}}</p>http://localhost:8000/edulinks?filter=5 url တစ်ခုလုံးပါမှာ အကုန်လုံး--}}
                            {{--<p>{{Request::url()}}</p>http://localhost:8000/edulinks ? နောက်ကဟာတွေမပါဘူး --}}
                            {{--<p>{{Request::getRequestUri()}}</p>/edulinks?filter=3 root domain name လွဲလို့ နောက်ကဟာတွေ အကုန်ပါမှာ --}}
                            {{--<p>{{Request::getPathInfo()}}</p>/posts/3/edit inc all request uri the address behind root but not inc query string behind ? --}}
                            {{--<p>{{Request::path()}}</p> posts/3/edit inc all request uri the address behind root but not inc query string behind ? not contain / in front , same as getPathInfo--}}


                            {{--<p>{{request()->root()}}</p>http://localhost:8000--}}
                            {{--<p>{{request()->fullUrl()}}</p>http://localhost:8000/edulinks?filter=5 url တစ်ခုလုံးပါမှာ အကုန်လုံး--}}
                            {{--<p>{{request()->url()}}</p>http://localhost:8000/edulinks ? နောက်ကဟာတွေမပါဘူး --}}
                            {{--<p>{{request()->getRequestUri()}}</p>/edulinks?filter=3 root domain name လွဲလို့ နောက်ကဟာတွေ အကုန်ပါမှာ --}}
                            {{--<p>{{request()->getPathInfo()}}</p>/posts/3/edit inc all request uri the address behind root but not inc query string behind ? --}}
                            {{--<p>{{request()->path()}}</p> posts/3/edit inc all request uri the address behind root but not inc query string behind ? not contain / in front , same as getPathInfo--}}


                            {{-- <p>{{url()->full()}}</p>http://localhost:8000/edulinks?filter=5 url တစ်ခုလုံးပါမှာ အကုန်လုံး fullUrl() နဲ့တူတယ် --}}
                            {{-- <p>{{url()->current()}}</p>http://localhost:8000/edulinks ? နောက်ကဟာတွေမပါဘူး url() နဲ့တူတယ် --}}
                            {{-- <p>{{url()->previous()}}</p>recent links previous link ကို ရမှာ back ပြန်တဲ့အခါမျိုးမှာသုံးလို့ရတယ် --}}