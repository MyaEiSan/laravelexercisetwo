@extends('layouts.adminindex')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">

        <div class="col-md-12">
            <form id="createform">
                <div class="row align-items-end mb-3">
                    <div class="col-md-4 form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" placeholder="Ener Status Name" value="{{old('name')}}" /> 
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="status_id">Status <span class="text-danger">*</span></label>
                        @error('status_id')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        <select name="status_id" class="form-control form-control-sm rounded-0">
                            @foreach($statuses as $status)
                                <option value="{{$status['id']}}">{{$status['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <button type="reset" class="btn btn-secondary btn-sm rounded-0">Cancel</button>
                        <button type="button" id="change-btn" class="btn btn-primary btn-sm rounded-0">Submit</button>
                    </div>
                </div>

            </form>
        </div>

        <div class="col-md-12">
            <table id="type-table" class="table table-sm table-hover border">
                <thead>
                    <tr>
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
                @foreach($paymentmethods as $idx=>$paymentmethod)
                <tr id="delete_{{$paymentmethod->id}}">
                        <td>{{++$idx}}</td>
                        <td>{{$paymentmethod->name}}</td>
                       
                        <td>
                            <div class="form-checkbox form-switch">
                                <input type="checkbox" class="form-check-input change-btn" {{$paymentmethod->status_id === 3 ? 'checked':''}} data-id="{{$paymentmethod->id}}"/>
                            </div>
                        </td>
                        <td>{{$paymentmethod->user['name']}}</td>
                        <td>{{$paymentmethod->created_at->format('d M Y')}}</td>
                        <td>{{$paymentmethod->updated_at->format('d M Y')}}</td>
                        <td>
                            <a href="javascript:void(0);" class="text-info editform" data-bs-toggle="modal" data-bs-target="#editmodal" data-id="{{$paymentmethod->id}}" data-name="{{$paymentmethod->name}}" data-status="{{$paymentmethod->status_id}}"><i class="fas fa-pen"></i></a>
                            {{-- <a href="#" class="text-danger ms-2 delete-btns" data-idx="{{$idx}}"><i class="fas fa-trash-alt"></i></a> --}}
                            <a href="javascript:void(0);" class="text-danger ms-2 delete-btns" data-idx="{{$idx}}" data-id="{{$paymentmethod->id}}"><i class="fas fa-trash-alt"></i></a>
                        </td>
                        {{-- <form id="formdelete-{{$idx}}" action="{{route('paymentmethods.destroy',$type->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form> --}}
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
    {{-- End Page Content  --}}

    {{-- START MODAL AREA  --}}
    {{-- start edit modal  --}}
    <div id="editmodal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h6 class="modal-title">Edit Form</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formaction" action="" method="POST">
                        {{csrf_field()}}
                        {{method_field('PUT')}}
                        <div class="row align-items-end">
                            <div class="col-md-7 form-group">
                                <label for="editname">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="editname" class="form-control form-control-sm rounded-0" placeholder="Ener Status Name" value="{{old('name')}}" /> 
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="editstatus_id">Status <span class="text-danger">*</span></label>
                                <select name="status_id" id="editstatus_id" class="form-control form-control-sm rounded-0">
                                    @foreach($statuses as $status)
                                        <option value="{{$status['id']}}">{{$status['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-sm rounded-0">Submit</button>
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
{{-- END MODAL AREA  --}}

@endsection
<!--End Content Area-->

@section('scripts')
<script>
    
    $(document).ready(function(){

        // Start Passing Header Token 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        })
        // End Passing Header Token 

        // Start Create Form

        $("#change-btn").click(function(e){
            e.preventDefault();
           
            $.ajax({
                url: "{{route('paymentmethods.store')}}", 
                type: "POST", 
                dataType: "json", 
                // data: $("#createform").serialize(), 
                data: $("#createform").serializeToArray(),
                success:function(response){
                    // console.log(response);
                    // console.log(response.data);

                    const data = response.data; 

                    $("#type-table").prepend(
                        `<tr id="${'delete_'+data.id}">
                        <td>${data.id}</td>
                        <td>${data.name}</td>
                       
                        <td>
                            <div class="form-checkbox form-switch">
                                <input type="checkbox" class="form-check-input change-btn" ${data.status_id === "3"?'checked':''} data-id="${data.id}"/>
                            </div>
                        </td>
                        <td>${data.user_id}</td>
                        <td>${data.created_at}</td>
                        <td>${data.updated_at}</td>
                        <td>
                            <a href="javascript:void(0);" class="text-info editform" data-bs-toggle="modal" data-bs-target="#editmodal" data-id="${data.id}" data-name="${data.name}" data-status="${data.status_id}"><i class="fas fa-pen"></i></a>
    
                            <a href="javascript:void(0);" class="text-danger ms-2 delete-btns" data-idx="" data-id="${data.id}"><i class="fas fa-trash-alt"></i></a>
                        </td>
                
                    </tr>
                        `
                    );
                }, 
                error: function(response){
                    console.log("Error : ", response);
                }
            })
        })

        // End Create Form 
        

        // Start Edit Form 

        $(document).on('click','.editform',function(e){
            
            // console.log($(this).attr('data-id'),$(this).data('name'));
            
            $("#editname").val($(this).attr('data-name'));
            $("#editstatus_id").val($(this).data('status'));

            const getid = $(this).attr('data-id');
            $("#formaction").attr('data-id',getid);

            
        });

        $('#formaction').submit(function(e){
            e.preventDefault();

            const getid = $(this).attr('data-id');


            $.ajax({
                url: `paymentmethods/${getid}`,
                type: "PUT",
                dataType: "json",
                data: $('#formaction').serialize(), // name=kpay&status=off
                success: function(response){
                    // console.log(response.status)
                    // console.log(this.data); //// name=kpay&status=off
                    $("#editmodal").modal('hide');

                    window.location.reload(); //temp reload 

                }
            })

        })

        // End Edit Form 

        // Start Delete Item

        // $('.delete-btns').click(function(){

        //     var getidx = $(this).data('idx');

        //     if(confirm(`Are you sure !!! you want to delete ${getidx}?`)){
        //         $("#formdelete-"+getidx).submit();
        //     }else{
        //         return false;
        //     }
        // })

        // by ajax 

        $(".delete-btns").click(function(){
            const getidx = $(this).attr('data-idx');
            var getid = $(this).data('id');
            // console.log(getid);

            if(confirm(`Are you sure !!! you want to delete  ${getidx}?`)){
                
                // just ui remove 

                // data remove 
                $.ajax({
                    url: `paymentmethods/${getid}`,
                    type: "DELETE",
                    dataType: "json",
                    // data:{_token:"{{csrf_token()}}"},
                    success:function(response){
                        if(response && response.status === "success"){
                            const getdata = response.data;
                            $(`#delete_${getdata.id}`).remove();
                        }
                    }
                });

                return true;
            }else{
                return false;
            }

            
        });

        // End Delete Item 

        // for mytable 
        $("#type-table").DataTable();

        // Start change-btn 

        $('.change-btn').change(function(){
            
            var getid = $(this).data('id');
            // console.log(getid);
            var setstatus = $(this).prop('checked') === true? 3 : 4;
            // console.log(setstatus);

            $.ajax({
                url: "paymentmethodsstatus" ,
                type: "GET",
                dataType: "json",
                data: {"id":getid,"status_id": setstatus},
                success: function(response){
                    // console.log(response);
                    console.log(response.success);
                }
            });
        });

        // End change-btn 

    })
</script>
@endsection