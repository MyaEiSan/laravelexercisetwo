@extends('layouts.adminindex')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">

        <div class="col-md-12">
           <a href="javascript:void(0);" id="createmodal-btn" class="btn btn-primary btn-sm rounded-0 me-3">Create</a>
           <a href="javascript:void(0);" id="setmodal-btn" class="btn btn-info btn-sm rounded-0">Set To User</a>
        </div>

        <div class="mt-3">
            <a href="javascript:void(0);" id="bulkdelete-btn" class="btn btn-danger btn-sm rounded-0 mb-2">Bulk Delete</a>
        </div>

        <div class="col-md-12 loader-container">
            <table id="mytable" class="table table-sm table-hover border">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="selectalls[]" id="selectalls"  class="form-check-input selectalls"/>
                        </th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Duration/Day</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tabledata">

                </tbody>
            </table>

            <div class="loader">
                <div class="loader-item"></div>
                <div class="loader-item"></div>
                <div class="loader-item"></div>
            </div>

        </div>
    </div>
    {{-- End Page Content  --}}

    {{-- START MODAL AREA  --}}

    {{-- start create modal  --}}
    <div id="createmodal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h6 class="modal-title">Title</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="createform">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" placeholder="Ener Name" value="{{old('name')}}" /> 
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="price">Price <span class="text-danger">*</span></label>
                                <input type="number" name="price" id="price" class="form-control form-control-sm rounded-0" placeholder="Ener Price" value="{{old('price')}}" /> 
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="duration">Duration <span class="text-danger">*</span></label>
                                <input type="number" name="duration" id="duration" class="form-control form-control-sm rounded-0" placeholder="Ener Duration" value="{{old('duration')}}" /> 
                            </div>
                            
                            <input type="hidden" name="packageid" id="packageid" />
                            
                            <div class="col-md-12 text-end">
                                <button type="submit" id="create-btn" class="btn btn-primary btn-sm rounded-0" value="action-type">Submit</button>
                            </div>
                        </div>
        
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    {{-- end create modal  --}}

    {{-- start set modal  --}}
    <div id="setmodal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h6 class="modal-title">Title</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="setform">
                        <div class="row align-items-end px-3">
                            <div class="col-md-12 form-group">
                                <label for="setuser_id">User Id <span class="text-danger">*</span></label>
                                <input type="text" name="setuser_id" id="setuser_id" class="form-control form-control-sm rounded-0" placeholder="Ener User Id" value="{{old('setuser_id')}}" /> 
                            </div>

                            <div class="col-md-12 form-group mb-3">
                                <label for="package_id">Package Id <span class="text-danger">*</span></label>
                                <input type="number" name="package_id" id="package_id" class="form-control form-control-sm rounded-0" placeholder="Ener Package Id" value="{{old('package_id')}}" /> 
                            </div>
                            
                            <div class="col-md-12 text-end">
                                <button type="submit" id="set-btn" class="btn btn-primary btn-sm rounded-0">Submit</button>
                            </div>
                        </div>
        
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    {{-- end set modal  --}}
    
    {{-- END MODAL AREA  --}}

@endsection
<!--End Content Area-->

@section('css')
 <link href="{{asset('assets/dist/css/loader.css')}}" rel="stylesheet" />
@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    
    $(document).ready(function(){

        // Start Passing Header Token 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        })
        // End Passing Header Token 

        // Start Fetch All Datas 
        function fetchalldatas(){
            $.ajax({
                url: "{{route('packages.index')}}", 
                method:"GET", 
                beforeSend: function(){
                    $('.loader').addClass('show');
                },
                success: function(response){
                    // const datas = response; 
                    $("#tabledata").html(response);
                    
                }, 
                complete: function(){
                    $('.loader').removeClass('show');
                }
            });
        }

        fetchalldatas();
        // End Fetch All Datas

        // End Create  & Update Package

        $("#createmodal-btn").click(function(){

            // clear form data 
            // $("#createform")[0].reset();
            // = method 2 
            $("#createform").trigger("reset");

            $("#createmodal .modal-title").text('Create Package');
            $("#create-btn").html("Add New Package");
            $("#create-btn").val("action-type");
            $("#createmodal").modal("show");
        });

        // Start Edit Form 

        $(document).on('click','.edit-btns', function(){
            const getid = $(this).data('id');

            $.get(`packages/${getid}`,function(response){
                // console.log(response);

                $("#createmodal .modal-title").text("Edit Form");
                $("#create-btn").text("Update Package"); 
                $("#create-btn").val("edit-type"); 
                $("#createmodal").modal("show"); 

                $("#packageid").val(response.id);
                $("#name").val(response.name); 
                $("#price").val(response.price);
                $("#duration").val(response.duration);

            })
        })
       
        // End Edit Form 

        $("#create-btn").click(function(e){
            e.preventDefault();
            
            let actiontype = $("#create-btn").val(); 
            $(this).html('Sending...'); 

            if(actiontype === "action-type"){
                // Do Create 

                $.ajax({
                    url: "{{route('packages.store')}}", 
                    type: "POST", 
                    dataType: 'json', 
                    data: $("#createform").serialize(), 
                    success:function(response){

                        // $("#createform")[0].reset();
                        $("#createform").trigger('reset')
                        
                        $("#createmodal").modal('hide');
                        $("#create-btn").html('Save Change'); 

                        fetchalldatas();

                        Swal.fire({
                            title: "Added!", 
                            text: "Added Successfully!", 
                            icon: "success"
                        }); 
                    }, 
                    error:function(response){
                        console.log('Error : ', response);
                        $("#create-btn").html('Save Change');
                    }
                })

            }else if(actiontype === "edit-type"){

                // Do Edit

                const getid = $("#packageid").val();


                $.ajax({
                    url: `/packages/${getid}`, 
                    type: "PUT", 
                    dataType: 'json', 
                    data: $("#createform").serialize(), 
                    success:function(response){

                        // $("#createform")[0].reset();
                        $("#createform").trigger('reset')
                        
                        $("#createmodal").modal('hide');
                        $("#create-btn").html('Save Change'); 

                        fetchalldatas();

                        Swal.fire({
                            title: "Updated!", 
                            text: "Updated Successfully!", 
                            icon: "success"
                        }); 
                    }, 
                    error:function(response){
                        console.log('Error : ', response);
                        $("#create-btn").html('Save Change');
                    }
                })
            }
        })


        // End Create  & Update Package 

        // Start Set Package

        $("#setmodal-btn").click(function(){

        // clear form data 
        // $("#setform")[0].reset();
        // = method 2 
        $("#setform").trigger("reset");

        $("#setmodal .modal-title").text('Create Package');
        $("#set-btn").html("Add New Package");
        $("#set-btn").val("action-type");
        $("#setmodal").modal("show");
        });


        $("#set-btn").click(function(e){
            e.preventDefault();
            
            $(this).html('Sending...'); 

                $.ajax({
                    url: "{{route('packages.setpackage')}}", 
                    type: "POST", 
                    dataType: 'json', 
                    data: $("#setform").serialize(), 
                    success:function(response){

                        // $("#setform")[0].reset();
                        $("#setform").trigger('reset')
                        
                        $("#setmodal").modal('hide');
                        $("#set-btn").html('Save Change'); 

                        fetchalldatas();

                        Swal.fire({
                            title: "Added!", 
                            text: "Added Successfully!", 
                            icon: "success"
                        }); 
                    }, 
                    error:function(response){
                        console.log('Error : ', response);
                        $("#set-btn").html('Save Change');
                    }
                })

        })


        // End Set Package

        

        

        // Start Single Delete

        $(document).on('click',".delete-btns",function(){
            
            var getid = $(this).data('id');
            const getidx = $(this).attr('data-idx');
            

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
                        url: `/packages/${getid}`,
                        type: "DELETE",
                        dataType: "json",
                        success:function(response){
                            if(response){
                                
                                fetchalldatas();
                                
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
                url: "socialapplicationsstatus" ,
                type: "GET",
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
        $("#selectalls").click(function(){
                $(".singlechecks").prop('checked',$(this).prop('checked'));
            });

            $("#bulkdelete-btn").click(function(){

                let getselectedids = []; 

                // console.log($("input:checkbox[name='singlechecks']:checked"));

                $("input:checkbox[name='singlechecks']:checked").each(function(){
                    getselectedids.push($(this).val());
                })

                Swal.fire({
                title: "Are you sure?",
                text: `You won't be able to revert!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                if (result.isConfirmed) {

                     // data remove 
                    $.ajax({
                        url:'{{route("packages.bulkdeletes")}}',
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
                                    text: "Your packages has been deleted.",
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


            });
        // End Bulk Delete 

    })
</script>
@endsection