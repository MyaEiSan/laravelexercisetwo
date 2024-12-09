@extends('layouts.adminindex')
@section('caption','City List')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">
        <hr/>
        <div class="col-md-12">
            <form id="createform">
                <div class="row align-items-end">
                    <div class="col-md-3 form-group mb-3">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        {{-- @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror --}}
                        <input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" placeholder="Ener City Name" value="{{old('name')}}" /> 
                    </div>
                    <div class="col-md-3 form-group mb-3">
                        <label for="region_id">Region <span class="text-danger">*</span></label>
                        <select name="region_id" id="region_id" class="form-control form-control-sm rounded-0">
                            @foreach($regions as $region)
                                <option value="{{$region['id']}}">{{$region['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group mb-3">
                        <label for="status_id">Status <span class="text-danger">*</span></label>
                        <select name="status_id" id="status_id" class="form-control form-control-sm rounded-0">
                            @foreach($statuses as $status)
                                <option value="{{$status['id']}}">{{$status['name']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" name="user_id" id="user_id" value="{{$userdata['id']}}" />

                    <div class="col-md-3 text-sm-end text-md-start mb-3">
                        <button type="reset" class="btn btn-secondary btn-sm rounded-0">Cancel</button>
                        <button type="submit" id="create-btn" class="btn btn-primary btn-sm rounded-0">Submit</button>
                    </div>
                </div>

            </form>
        </div>

        <hr/>

        <div class="col-md-12">

            <div>
                {{-- <a href="javascript:void(0);" id="bulkdelete-btn" class="btn btn-danger btn-sm rounded-0 me-3">Bulk Delete</a> --}}
                <a href="javascript:void(0);" id="generateotp-btn" class="btn btn-danger btn-sm rounded-0">Bulk Delete</a>
            </div>
            <div>
                <form action="" method="">
                    <div class="row justify-content-end">
                        <div class="col-md-2 col-sm-6 mb-2">
                            <div class="input-group">
                                <input type="text" name="filtername" id="filtername" class="form-control form-control-sm rounded-0" placeholder="Search..." value="{{request('filtername')}}"/>
                                <button type="button" id="btn-search" class="btn btn-secondary btn-sm"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-12 loader-container">

            {{-- <a href="{{route('cities.create')}}" class="btn btn-primary btn-sm rounded-0">Create</a>

            <hr/> --}}

            <table id="mytable" class="table table-sm table-hover border">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="selectalls[]" id="selectalls"  class="form-check-input selectalls"/>
                        </th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Region</th>
                        <th>Status</th>
                        <th>By</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
               
                </tbody>
            </table>

            <div class="loader">
                <div class="loader-item"></div>
                <div class="loader-item"></div>
                <div class="loader-item"></div>
            </div>
            {{$cities->links('pagination::bootstrap-4')}}

        </div>
    </div>
    {{-- End Page Content  --}}
    <!--End Content Area-->

{{-- START MODAL AREA  --}}
    {{-- start edit modal  --}}
    <div id="editmodal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Edit Form</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editform">
                        {{csrf_field()}}
                        {{method_field('PUT')}}
                        <div class="row align-items-end">

                            <div class="col-md-5 form-group mb-3">
                                <label for="editname">Name <span class="text-danger">*</span></label>
                                <input type="text" name="editname" id="editname" class="form-control form-control-sm rounded-0" placeholder="Ener City Name" value="{{old('name')}}" /> 
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="edit_regionid">Region <span class="text-danger">*</span></label>
                                <select name="edit_regionid" id="edit_regionid" class="form-control form-control-sm rounded-0">
                                    @foreach($regions as $region)
                                        <option value="{{$region['id']}}">{{$region['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="editstatus_id">Status <span class="text-danger">*</span></label>
                                <select name="editstatus_id" id="editstatus_id" class="form-control form-control-sm rounded-0">
                                    @foreach($statuses as $status)
                                        <option value="{{$status['id']}}">{{$status['name']}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" name="id" id="id" />
                            <input type="hidden" name="user_id" id="user_id" value="{{$userdata['id']}}" />

                            <div class="col-md-2 text-end mb-3">
                                <button type="submit" id="edit-btn" class="btn btn-primary btn-sm rounded-0">Update</button>
                            </div>
                        </div>
        
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
{{-- end edit modal  --}}

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
{{-- END MODAL AREA  --}}

@endsection
@section('css')
 <link href="{{asset('assets/dist/css/loader.css')}}" rel="stylesheet" />
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">

    // Start Filter 

    const getfilterbtn = document.getElementById('btn-search');

    getfilterbtn.addEventListener('click', function(e){
        const getfiltername = document.getElementById('filtername').value;
        const getcururl = window.location.href;

        console.log(getcururl);
        console.log(getcururl.split('?'));
        console.log(getcururl.split('?')[0]);

        window.location.href = getcururl.split('?')[0] + '?filtername='+getfiltername;
        

        e.preventDefault();
    });

    // End Filter 

    $(document).ready(function(){

         // Start Passing Header Token 
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        })
        // End Passing Header Token 
        
        const gettbody = document.querySelector("#mytable tbody");
        const getloader = document.querySelector('.loader');
        let page = 1;


        // Start Fetch All Datas by paginate 
        async function fetchalldatasbypaginate(){

            const url = `api/cities?page=${page}`;
            let results;

            await fetch(url).then(response=>{
                console.log(response); 
                return response.json();
            }).then(data=>{
                // console.log(data); //object

                results = data.data; 
                // console.log(results);
            }).catch(err=>{
                console.log(err);
            }); 

            return results; 
        }

        async function alldatastodom(){
            const getresults = await fetchalldatasbypaginate();

            getresults.forEach((data)=>{
                const newtr = document.createElement('tr');
                newtr.id = `delete_${data.id}`;
                newtr.innerHTML = `
                <td>
                                        <input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="${data.id}" />
                                    </td>
                                    <td>${data.id}</td>
                                    <td>${data.name}</td>
                                    <td>${data.region.name}</td>
                                    <td>
                                        <div class="form-checkbox form-switch">
                                            <input type="checkbox" class="form-check-input change-btn" ${data.status_id == 3 ? 'checked':''} data-id="${data.id}"/>
                                        </div>
                                    </td>
                                    
                                    <td>${data.user.name}</td>
                                    <td>${data.created_at}</td>
                                    <td>${data.updated_at}</td>
                                    <td>
                                        <a href="javascript:void(0);" class="text-info editform edit-btns" data-id="${data.id}" ><i class="fas fa-pen"></i></a>
                                        <a href="javascript:void(0);" class="text-danger ms-2 delete-btns" data-idx="${data.id}" data-id="${data.id}"><i class="fas fa-trash-alt"></i></a>
                                    </td>`;
                gettbody.appendChild(newtr);
            });
        }

        alldatastodom();

        document.addEventListener('scroll', ()=>{
            // console.log(document.documentElement.scrollTop);
            // console.log(document.documentElement.scrollHeight);
            // console.log(document.documentElement.clientHeight);

            const {scrollTop,scrollHeight,clientHeight} = document.documentElement; 

            if(scrollTop + clientHeight >= scrollHeight){
                console.log('hay');
                showloader();
            }


        })

        // Show loader & fetch more datas; 
        function showloader(){
            getloader.classList.add('show'); 

            setTimeout(() => {
                getloader.classList.remove('show');

                setTimeout(()=>{
                    page++;
                    alldatastodom();
                },300);
            }, 1000);
        }
        // Show loader & fetch more datas; 

        // End Fetch All Datas by paginate

        // Start Create Form

       

        $("#createform").validate({
            rules:{
                name: "required"
            }, 
            messages:{
                name: "Please enter the city name"
            },
            submitHandler: function(form){
                
                    $("#create-btn").text("Sending...");

                    let formdata = $(form).serializeArray();

                    $.ajax({
                        url: "{{url('api/cities')}}", 
                        type: "POST", 
                        dataType: 'json', 
                        data: formdata,
                        success: function(response){
                            // console.location(response);
                            // console.log(response.status);

                            if(response){
                                $("#createmodal").modal("hide");

                                const data = response.data; 

                                let html = `
                                <tr id="delete_${data.id}">
                                    <td>
                                        <input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="${data.id}" />
                                    </td>
                                    <td>${data.id}</td>
                                    <td>${data.name}</td>
                                    <td>${data.region.name}</td>
                                    <td>
                                        <div class="form-checkbox form-switch">
                                            <input type="checkbox" class="form-check-input change-btn" ${data.status_id == 3 ? 'checked':''} data-id="${data.id}"/>
                                        </div>
                                    </td>
                                    
                                    <td>${data.user.name}</td>
                                    <td>${data.created_at}</td>
                                    <td>${data.updated_at}</td>
                                    <td>
                                        <a href="javascript:void(0);" class="text-info editform edit-btns" data-id="${data.id}" ><i class="fas fa-pen"></i></a>
                                        <a href="javascript:void(0);" class="text-danger ms-2 delete-btns" data-idx="${data.id}" data-id="${data.id}"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                `;
                            
                                $("#mytable tbody").prepend(html);
                                $("#create-btn").text("Submit");
                                $("#createform").trigger("reset");

                                Swal.fire({
                                    title: "Added!",
                                    text: "Added Successfully!",
                                    icon: "success"
                                });
                            }
                        }, 
                        error: function(response){
                            console.log("Error : ", response);
                        }
                    })
                
            }
        })

        // End Create Form 
        

        // Start Edit Form 

        $(document).on('click','.edit-btns', function(){
    
            const getid = $(this).data('id');

            $.get(`cities/${getid}/edit`,function(response){
                // console.log(response);

                $("#editmodal").modal("show"); 

                $("#id").val(response.id);
                $("#editname").val(response.name); 
                $("#editcountry_id").val(response.country_id);
                $("#editstatus_id").val(response.status_id);
            })
        })
       
        // End Edit Form 

         // Start Edit Modal

       

         $("#editform").validate({
            rules:{
                editname: "required"
            }, 
            messages:{
                editname: "Please enter the city name"
            },
            submitHandler: function(form){

                const getid = $("#id").val();


                
                    $("#edit-btn").text("Sending...");

                    let formdata = $(form).serializeArray();

                    $.ajax({
                        url: `api/cities/${getid}`, 
                        type: "PUT", 
                        dataType: 'json', 
                        data: formdata,
                        success: function(response){
                            // console.location(response);
                            // console.log(response.status);

                            if(response){

                                const data = response.data; 

                                let html = `
                                <tr id="delete_${data.id}">
                                    <td>
                                        <input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="${data.id}" />
                                    </td>
                                    <td>${data.id}</td>
                                    <td>${data.name}</td>
                                    <td>${data.region.name}</td>
                                    <td>
                                        <div class="form-checkbox form-switch">
                                            <input type="checkbox" class="form-check-input change-btn" ${data.status_id == 3 ? 'checked':''} data-id="${data.id}"/>
                                        </div>
                                    </td>
                                    
                                    <td>${data.user.name}</td>
                                    <td>${data.created_at}</td>
                                    <td>${data.updated_at}</td>
                                    <td>
                                        <a href="javascript:void(0);" class="text-info editform edit-btns" data-id="${data.id}" ><i class="fas fa-pen"></i></a>
                                        <a href="javascript:void(0);" class="text-danger ms-2 delete-btns" data-idx="${data.id}" data-id="${data.id}"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                `;
                            
                                $("#delete_"+data.id).replaceWith(html);
                                $("#editmodal").modal("hide");
                                $("#edit-btn").text("Update");
                                $("#editform").trigger("reset");

                                Swal.fire({
                                    title: "Added!",
                                    text: "Added Successfully!",
                                    icon: "success"
                                });
                            }
                        }, 
                        error: function(response){
                            console.log("Error : ", response);
                            $("#edit-btn").text("Try Again");
                        }
                    })
                
            }
        })

        // End Edit Modal




        // Start Delete Item

        // by ajax 

        $(document).on('click',".delete-btns",function(){
            const getidx = $(this).attr('data-idx');
            var getid = $(this).data('id');
            // console.log(getid);

            Swal.fire({
                title: "Are you sure?",
                text: `You won't be able to revert id ${getid}!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                if (result.isConfirmed) {

                     // data remove 
                    $.ajax({
                        url: `api/cities/${getid}`,
                        type: "DELETE",
                        dataType: "json",
                        success:function(response){
                            // console.log(response);
                            if(response){
                                $(`#delete_${getid}`).remove();
                                
                                Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success"
                                });
                            }
                        }, 
                        error:function(){
                            console.log("Error : ", response);
                        }
                    });
                }
                });
                
                // just ui remove 


            
        });

        // End Delete Item 


        // Start change-btn 

        $(document).on('change','.change-btn',function(){
            
            var getid = $(this).data('id');
            // console.log(getid);
            var setstatus = $(this).prop('checked') === true? 3 : 4;
            // console.log(setstatus);

            $.ajax({
                url: "{{url('api/citiesstatus')}}" ,
                type: "PUT",
                dataType: "json",
                data: {"id":getid,"status_id": setstatus},
                success: function(response){
                    // console.log(response);
                    // console.log(response.success);
                    Swal.fire({
                        title: "Updated!",
                        text: "Updated Successfully!",
                        icon: "success"
                    });
                }
            });
        });

        // End change-btn 

        // Start Bulk Delete 
            // $("#selectalls").click(function(){
            //     $(".singlechecks").prop('checked',$(this).prop('checked'));
            // });

            // $("#bulkdelete-btn").click(function(){

            //     let getselectedids = []; 

            //     // console.log($("input:checkbox[name='singlechecks']:checked"));

            //     $("input:checkbox[name='singlechecks']:checked").each(function(){
            //         getselectedids.push($(this).val());
            //     })

            //     // console.log(getselectedids);

            //     // $.ajax({
            //     //     url:'{{route("cities.bulkdeletes")}}',
            //     //     type: "DELETE", 
            //     //     dataType: "json",
            //     //       data:{
            //     //          selectedids: getselectedids, 
            //     //            _token: '{{csrf_token()}}'
            //     //      }, 
            //     //     success:function(response){
            //     //         // console.log(response);
            //     //         if(response){
            //     //             $.each(getselectedids,function(key,value){
            //     //                 $(`#delete_${value}`).remove();
            //     //             });
            //     //         }
            //     //     }, 
            //     //     error: function(response){
            //     //         const.log('Error : ',response);
            //     //     }
            //     // })

            //     Swal.fire({
            //     title: "Are you sure?",
            //     text: `You won't be able to revert!`,
            //     icon: "warning",
            //     showCancelButton: true,
            //     confirmButtonColor: "#3085d6",
            //     cancelButtonColor: "#d33",
            //     confirmButtonText: "Yes, delete it!"
            //     }).then((result) => {
            //     if (result.isConfirmed) {

            //          // data remove 
            //         $.ajax({
            //             url:'{{route("cities.bulkdeletes")}}',
            //             type: "DELETE",
            //             dataType: "json",
            //             data:{
            //                     selectedids: getselectedids, 
            //                     _token: '{{csrf_token()}}'
            //                 },
            //             success:function(response){
            //                 // console.log(response);
            //                 if(response){
            //                     $.each(getselectedids,function(key,value){
            //                         $(`#delete_${value}`).remove();
            //                     });
                                
            //                     Swal.fire({
            //                         title: "Deleted!",
            //                         text: "Your file has been deleted.",
            //                         icon: "success"
            //                     });
            //                 }
            //             }, 
            //             error:function(){
            //                 console.log("Error : ", response);
            //             }
            //         });
            //     }
            //     });


            // });
        // End Bulk Delete 

        // Start OTP 
           $("#generateotp-btn").on('click',function(){
            // console.log('hay');

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
           });

        //    Method 1
        //    function startotptimer(duration){
        //         // let minutes,seconds; 
        //         // let timer = duration; 
        //         // console.log(timer,minutes,seconds);

        //         let timer = duration,minutes,seconds; 
        //         console.log(timer,minutes,seconds);

        //         let setinv = setInterval(dectimer,1000); 
                
        //         function dectimer(){
        //             minutes = parseInt(timer/60); 
        //             seconds = parseInt(timer%60); 
        //             console.log(minutes,seconds);

        //             minutes = minutes < 10 ? "0"+minutes : minutes; 
        //             seconds = seconds < 10 ? "0"+seconds : seconds;
                    
        //             $("#otptimer").text(`${minutes}:${seconds}`);

        //             if(timer-- < 0){
        //                 clearInterval(setinv);
        //                 $("#otpmodal").modal('hide');
        //             }
        //         }

        //    } 


        // Method 2 

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

                            let getselectedids = []; 

                            $("input:checkbox[name='singlechecks']:checked").each(function(){
                                getselectedids.push($(this).val());
                            });

                            $.ajax({
                                url:'{{route("cities.bulkdeletes")}}',
                                type: "DELETE",
                                dataType: "json",
                                data:{
                                        selectedids: getselectedids, 
                                        _token: '{{csrf_token()}}'
                                    },
                                success:function(response){
                                    // console.log(response);
                                    if(response){
                                        $.each(getselectedids,function(key,value){
                                            $(`#delete_${value}`).remove();
                                        });
                                        
                                        Swal.fire({
                                            title: "Deleted!",
                                            text: "Your file has been deleted.",
                                            icon: "success"
                                        });
                                    }
                                }, 
                                error:function(){
                                    console.log("Error : ", response);
                                }
                            });

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
        // End OTP 

    })
</script>
@endsection

