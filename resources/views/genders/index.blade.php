@extends('layouts.adminindex')
@section('caption','Gender List')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">
        <hr/>
        <div class="col-md-12">
            <form action="{{route('genders.store')}}" method="POST">
                {{csrf_field()}}
                <div class="row align-items-end">
                    <div class="col-md-6 form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        @error('name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="text" name="name" id="name" class="form-control form-control-sm rounded-0 @error('name') is-invalid @enderror" placeholder="Ener Gender Name" value="{{old('name')}}" /> 
                        {{-- @error('name')
                        <span class="invalid-feedback">{{$message}}</span>
                        @enderror --}}
                    </div>
                    <div class="col-md-6">
                        <button type="reset" class="btn btn-secondary btn-sm rounded-0">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm rounded-0">Submit</button>
                    </div>
                </div>

            </form>
        </div>

        <hr/>

        <div>
            <a href="javascript:void(0);" id="bulkdelete-btn" class="btn btn-danger btn-sm rounded-0 mb-2">Bulk Delete</a>
        </div>

        <div class="col-md-12">

            {{-- <a href="{{route('genders.create')}}" class="btn btn-primary btn-sm rounded-0">Create</a>

            <hr/> --}}
            <table id="gender-table" class="table table-sm table-hover border">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="selectalls[]" id="selectalls"  class="form-check-input selectalls"/>
                        </th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>By</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($genders as $idx=>$gender)
                <tr id="delete_{{$gender->id}}">
                        <td>
                            <input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="{{$gender->id}}" />
                        </td>
                        <td>{{++$idx}}</td>
                        <td>{{$gender->name}}</td>
                        <td>{{$gender->user['name']}}</td>
                        <td>{{$gender->created_at->format('d M Y')}}</td>
                        <td>{{$gender->updated_at->format('d M Y')}}</td>
                        <td>
                            <a href="javascript:void(0);" class="text-info editform" data-bs-toggle="modal" data-bs-target="#edit-modal" data-id="{{$gender->id}}" data-name="{{$gender->name}}"><i class="fas fa-pen"></i></a>
                            <a href="#" class="text-danger ms-2 delete-btns" data-idx="{{$idx}}"><i class="fas fa-trash-alt"></i></a>
                        </td>
                        <form id="formdelete-{{$idx}}" action="{{route('genders.destroy',$gender->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
    {{-- End Page Content  --}}
@endsection
<!--End Content Area-->

{{-- START MODAL AREA  --}}
    {{-- start edit modal  --}}
        <div id="edit-modal" class="modal fade">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">Edit Form</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formaction" action="" method="POST">
                            {{csrf_field()}}
                            {{method_field('PUT')}}
                            <div class="row align-items-end">
                                <div class="col-md-8 form-group">
                                    <label for="editname">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="editname" class="form-control form-control-sm rounded-0" placeholder="Ener Gender Name" value="{{old('name')}}" /> 
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

@section('scripts')
<script>
    $(document).ready(function(){

        // Start Delete item 

        $('.delete-btns').click(function(){

            var getidx = $(this).data('idx');

            if(confirm(`Are you sure !!! you want to delete ${getidx}?`)){
                $("#formdelete-"+getidx).submit();
            }else{
                return false;
            }
        })

        // ENd Delete Item 

        // Start Edit Form 

        $(document).on('click','.editform',function(e){
            
            // console.log($(this).attr('data-id'),$(this).data('name'));
            
            $("#editname").val($(this).data('name'));

            const getid = $(this).attr('data-id');
            $("#formaction").attr('action',`/genders/${getid}`);

            e.preventDefault();
        })

        // End Edit Form 

        $("#gender-table").DataTable();

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
                        url:'{{route("genders.bulkdeletes")}}',
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

