@extends('layouts.adminindex')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">

        <div class="col-md-12 mb-3">
           <a href="javascript:void(0);" id="modal-btn" class="btn btn-primary btn-sm rounded-0">Create</a>
        </div>
        <div>
            <a href="javascript:void(0);" id="bulkdelete-btn" class="btn btn-danger btn-sm rounded-0 mb-2">Bulk Delete</a>
        </div>

        <div class="col-md-12">
            <table id="mytable" class="table table-sm table-hover border">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="selectalls[]" id="selectalls"  class="form-check-input selectalls"/>
                        </th>
                        <th>ID</th>
                        <th>Name</th>
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

            {{ $warehouses->links() }}


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
                    <form id="formaction">
                        <div class="row align-items-end px-3">
                            <div class="col-md-7 form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" placeholder="Ener Status Name" value="{{old('name')}}" /> 
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="status_id">Status <span class="text-danger">*</span></label>
                                <select name="status_id" id="status_id" class="form-control form-control-sm rounded-0">
                                    @foreach($statuses as $status)
                                        <option value="{{$status['id']}}">{{$status['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="id" id="id" />
                            <input type="hidden" name="user_id" id="user_id" value="{{$userdata['id']}}"/>
                            <div class="col-md-2">
                                <button type="submit" id="action-btn" class="btn btn-primary btn-sm rounded-0" value="action-type">Submit</button>
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
    
    {{-- END MODAL AREA  --}}

@endsection
<!--End Content Area-->

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js" type="text/javascript"></script>
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
                url:"{{route('api.warehouses.index')}}",
                method:"GET", 
                type:"JSON", 
                success: function(response){
                    const datas = response.data; 
                    let html = '';
                    datas.forEach(function(data){
                        html += `
                                <tr id="delete_${data.id}">
                                    <td>
                                        <input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="${data.id}" />
                                    </td>
                                    <td>${data.id}</td>
                                    <td>${data.name}</td>
                                
                                    <td>
                                        <div class="form-checkbox form-switch">
                                            <input type="checkbox" class="form-check-input change-btn" ${data.status_id == 3 ? 'checked':''} data-id="${data.id}"/>
                                        </div>
                                    </td>
                                    <td>${data.user['name']}</td>
                                    <td>${data.created_at}</td>
                                    <td>${data.updated_at}</td>
                                    <td>
                                        <a href="javascript:void(0);" class="text-info editform edit-btns" data-id="${data.id}" ><i class="fas fa-pen"></i></a>
                                        <a href="javascript:void(0);" class="text-danger ms-2 delete-btns" data-idx="${data.id}" data-id="${data.id}"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                `;
                            
                    })

                    $("#mytable tbody").prepend(html);
                }
            })
        }

        fetchalldatas();
        // End Fetch All Datas

        // Start Create Form

        $("#modal-btn").click(function(){

            // clear form data 
            // console.log($("#formaction"));
            // console.log($("#formaction")[0]);
            // = method 1 
            // $("#formaction")[0].reset();
            // = method 2 
            $("#formaction").trigger("reset");
            $("#createmodal .modal-title").text('Create Form');
            $("#action-btn").val("create-btn");
            $("#createmodal").modal("show");

           

        });

        $("#formaction").validate({
            rules:{
                name: "required"
            }, 
            messages:{
                name: "Please enter the application name"
            },
            submitHandler: function(form){

                let actiontype = $("#action-btn").val(); 

                if(actiontype == "create-btn"){
                    $("#action-btn").text("Sending...");

                    // let formdata =  $("#formaction").serialize();
                    // let formdata =  $(form).serialize();
                    // let formdata =  $("#formaction").serializeArray();
                    let formdata = $(form).serializeArray();

                    $.ajax({
                        data: formdata,
                        url: "{{url('api/warehouses')}}", 
                        type: "POST", 
                        dataType: 'json', 
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
                                $("#action-btn").text("Submit");

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
                }else{
                    const getid = $("#id").val();

                    $.ajax({
                        url: `api/warehouses/${getid}`,
                        type: "PUT",
                        dataType: "json",
                        data: $('#formaction').serialize(),
                        success: function(response){

                            // console.log(response);
                            
                            const data = response.data; 

                                let html = `
                                <tr id="delete_${data.id}">
                                    <td>
                                        <input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="${data.id}" />
                                    </td>
                                    <td>${data.id}</td>
                                    <td>${data.name}</td>
                                
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
                                $("#action-btn").html("Submit");
                                $("#createmodal").modal('hide');

                                Swal.fire({
                                    title: "Updated!",
                                    text: "Updated Successfully!",
                                    icon: "success"
                                });


                        }
                    })
                }
            }
        })

        // End Create Form 
        

        // Start Edit Form 

        $(document).on('click','.edit-btns', function(){
            const getid = $(this).data('id');

            $.get(`warehouses/${getid}/edit`,function(response){
                // console.log(response);

                $("#createmodal .modal-title").text("Edit Form");
                $("#action-btn").text("Update"); 
                $("action-btn").val("edit-btn"); 
                $("#createmodal").modal("show"); 

                $("#id").val(response.id);
                $("#name").val(response.name); 
                $("#status_id").val(response.status_id);
            })
        })
       
        // End Edit Form 

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
                        url: `api/warehouses/${getid}`,
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
                url: "{{url('api/warehousesstatus')}}" ,
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
                        url:'{{route("warehouses.bulkdeletes")}}',
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