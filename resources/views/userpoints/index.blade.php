@extends('layouts.adminindex')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">

        <div class="col-md-12">
           <a href="javascript:void(0);" id="createmodal-btn" class="btn btn-primary btn-sm rounded-0 me-3">Create</a>
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
                        <th>Student ID</th>
                        <th>Points</th>
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
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h6 class="modal-title">Title</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="step1">
                        <form id="verifyform">
                            <div class="row">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="student_id">Student Id <span class="text-danger">*</span></label>
                                    <input type="text" name="student_id" id="student_id" class="form-control form-control-sm rounded-0" placeholder="Ener Student ID" value="{{old('student_id')}}" /> 
                                </div>
                                
                                <div class="col-md-12 text-end">
                                    <button type="button" id="verify-btn" class="btn btn-primary btn-sm rounded-0">Next</button>
                                </div>
                            </div>
            
                        </form>
                    </div>
                    <div id="step2" style="display: none;">
                        <form id="createform">
                            <div class="row">
                                <div class="col-md-12 form-group mb-3">
                                    <ul class="list-group"></ul>
                                </div>

                               
    
                                <div class="col-md-6 form-group mb-3">
                                    <label for="points">Point <span class="text-danger">*</span></label>
                                    <input type="number" name="points" id="points" class="form-control form-control-sm rounded-0" placeholder="Ener Points" value="{{old('points')}}" /> 
                                </div>

                                <input type="hidden" name="user_id" id="user_id" />
                                <input type="hidden" name="userpointid" id="userpointid" />
                                
                                
                                
                                <div class="col-md-12 text-end">
                                    <button type="button" id="stepback-btn" class="btn btn-secondary btn-sm rounded-0 me-3">Back</button>
                                    <button type="submit" id="create-btn" class="btn btn-primary btn-sm rounded-0">Submit</button>
                                </div>
                            </div>
            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end create modal  --}}
    
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
                url: "{{route('userpoints.index')}}", 
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

            $("#step1").show();
            $("#step2").hide();

            // clear form data 
            // $("#createform")[0].reset();
            // = method 2 
            $("#createform").trigger("reset");
            $("#verifyform").trigger("reset");

            $("#createmodal .modal-title").text('Verify Student');
            $("#create-btn").html("Add New Points");
            $("#create-btn").val("action-type");
            $("#createmodal").modal("show");
        });

        // start  verify student 

        $("#verify-btn").click(function(){

            const studentid = $("#student_id").val();

                $.ajax({
                    url: "{{route('userpoint.verifystudent')}}", 
                    type: "POST", 
                    dataType: 'json', 
                    data: {
                        studentid: studentid
                    }, 
                    success:function(response){

                        // console.log(response);

                        let htmlview = '';

                        $("#step1").hide();
                        $("#step2").show();

                        $("#createmodal .modal-title").text('Adding Points');
                        $("#user_id").val(response.user.id);

                        htmlview = `<li class="list-group-item"><a href="{{URL::to('students/${response.student.id}')}}" target="_blank">${response.student.firstname} ${response.student.lastname}</a></li>`;

                        $("#createmodal .modal-body #createform ul.list-group").html(htmlview);

                    }, 
                    error:function(response){
                        console.log('Error : ', response);
                    }
                })
        }); 

        $("#stepback-btn").click(function(){
            $("#createmodal .modal-title").text('Verify Student');
            $("#step1").show(); 
            $("#step2").hide();
            $("#verifyform").trigger("reset");
        })

        // end verify student 




        // Start Edit Form 

        $(document).on('click','.edit-btns', function(){
            const getid = $(this).data('id');

            $.get(`userpoints/${getid}`,function(response){
                // console.log(response);

                $("#step1").hide(); 
                $("#step2").show(); 
                $("#step2 #stepback-btn").hide();
                $("#step2 #createform .list-group").html("");

                $("#createmodal .modal-title").text("Edit Point");
                $("#create-btn").text("Update Points"); 
                $("#create-btn").val("edit-type"); 
                $("#createmodal").modal("show"); 

                $("#userpointid").val(response.id);
                $("#user_id").val(response.user_id); 
                $("#points").val(response.points);

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
                    url: "{{route('userpoints.store')}}", 
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

                const getid = $("#userpointid").val();


                $.ajax({
                    url: `/userpoints/${getid}`, 
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
                        url: `/userpoints/${getid}`,
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
                        url:'{{route("userpoints.bulkdeletes")}}',
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
                }
                });


            });
        // End Bulk Delete 

    })
</script>
@endsection