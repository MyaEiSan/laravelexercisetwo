@extends('layouts.adminindex')
@section('caption','Type List')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">

        <div class="col-md-12">
            <form action="{{route('types.store')}}" method="POST">
                {{csrf_field()}}
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
                        <button type="submit" class="btn btn-primary btn-sm rounded-0">Submit</button>
                    </div>
                </div>

            </form>
        </div>

        <div>
            <a href="javascript:void(0);" id="bulkdelete-btn" class="btn btn-danger btn-sm rounded-0 mb-2">Bulk Delete</a>
        </div>

        <div class="col-md-12">
            <table id="type-table" class="table table-sm table-hover border">
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
                @foreach($types as $idx=>$type)
                <tr id="delete_{{$type->id}}">
                        <td>
                            <input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="{{$type->id}}" />
                        </td>
                        <td>{{++$idx}}</td>
                        <td>{{$type->name}}</td>
                       
                        <td>
                            <div class="form-checkbox form-switch">
                                <input type="checkbox" class="form-check-input change-btn" {{$type->status_id === 3 ? 'checked':''}} data-id="{{$type->id}}"/>
                            </div>
                        </td>
                        <td>{{$type->user['name']}}</td>
                        <td>{{$type->created_at->format('d M Y')}}</td>
                        <td>{{$type->updated_at->format('d M Y')}}</td>
                        <td>
                            <a href="javascript:void(0);" class="text-info editform" data-bs-toggle="modal" data-bs-target="#edit-modal" data-id="{{$type->id}}" data-name="{{$type->name}}" data-status="{{$type->status_id}}"><i class="fas fa-pen"></i></a>
                            {{-- <a href="#" class="text-danger ms-2 delete-btns" data-idx="{{$idx}}"><i class="fas fa-trash-alt"></i></a> --}}
                            <a href="javascript:void(0);" class="text-danger ms-2 delete-btns" data-idx="{{$idx}}" data-id="{{$type->id}}"><i class="fas fa-trash-alt"></i></a>
                        </td>
                        {{-- <form id="formdelete-{{$idx}}" action="{{route('types.destroy',$type->id)}}" method="POST">
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
    <div id="edit-modal" class="modal fade">
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

        // Start Edit Form 

        $(document).on('click','.editform',function(e){
            
            // console.log($(this).attr('data-id'),$(this).data('name'));
            
            $("#editname").val($(this).attr('data-name'));
            $("#editstatus_id").val($(this).data('status'));

            const getid = $(this).attr('data-id');
            $("#formaction").attr('action',`/types/${getid}`);

            e.preventDefault();
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
                $(this).parent().parent().remove();

                // data remove 
                $.ajax({
                    url: "typesdelete",
                    type: "GET",
                    dataType: "json",
                    data: {"id":getid},
                    success:function(response){
                        window.alert(response.success);
                        // console.log(response);
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
                url: "typesstatus" ,
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
                        url:'{{route("types.bulkdeletes")}}',
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