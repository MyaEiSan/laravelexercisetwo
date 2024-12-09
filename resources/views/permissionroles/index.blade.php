@extends('layouts.adminindex')
@section('caption','City List')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">
        <hr/>
        <div class="col-md-12">
            <form action="{{route('permissionroles.store')}}" method="POST">
                {{csrf_field()}}
                <div class="row align-items-end">

                    <div class="col-md-3 form-group mb-3">
                        <label for="role_id">Role <span class="text-danger">*</span></label>
                        <select name="role_id" id="role_id" class="form-control form-control-sm rounded-0 country_id">
                           <option value="">Choose role</option>
                            @foreach($roles as $role)
                                <option value="{{$role['id']}}" {{old('role_id') == $role['id']?'selected':''}}>{{$role['name']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 form-group mb-3">
                        <label for="permission_id">Permission <span class="text-danger">*</span></label>
                        <select name="permission_id[]" id="permission_id" class="form-control form-control-sm rounded-0 select2" multiple>
                            <option value="" disabled>Choose permission</option>
                            @foreach($permissions as $permission)
                                <option value="{{$permission['id']}}">{{$permission['name']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 text-sm-end text-md-start mb-3">
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
            <form action="" method="">
                <div class="row justify-content-end">
                    <div class="col-md-2 col-sm-6 mb-2">
                        <div class="input-group">
                            <input type="text" name="filtername" id="filtername" class="form-control form-control-sm rounded-0" placeholder="Search..." />
                            <button type="submit" id="btn-search" class="btn btn-secondary btn-sm"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-12">
{{-- 
            <a href="{{route('countries.create')}}" class="btn btn-primary btn-sm rounded-0">Create</a>

            <hr/> --}}

            <table id="country-table" class="table table-sm table-hover border">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="selectalls[]" id="selectalls"  class="form-check-input selectalls"/>
                        </th>
                        <th>ID</th>
                        <th>Role</th>
                        <th>Permission</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($permissionroles as $idx=>$permissionrole)
                <tr id="delete_{{$permissionrole->id}}">
                        {{-- <td>{{++$idx}}</td> --}}
                        <td>
                            <input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="{{$permissionrole->id}}" />
                        </td>
                        <td>{{$idx + $permissionroles->firstItem()}}</td>
                        <td>{{$permissionrole->role->name}}</td>
                        <td>{{$permissionrole->permission->name}}</td>
                        <td>{{$permissionrole->created_at->format('d M Y')}}</td>
                        <td>{{$permissionrole->updated_at->format('d M Y')}}</td>
                        <td>
                            <a href="javascript:void(0);" class="text-info editform" data-bs-toggle="modal" data-bs-target="#edit-modal" data-id="{{$permissionrole->id}}" data-role="{{$permissionrole->role_id}}" data-permission="{{$permissionrole->permission_id}}"><i class="fas fa-pen"></i></a>
                            <a href="#" class="text-danger ms-2 delete-btns" data-idx="{{$idx}}"><i class="fas fa-trash-alt"></i></a>
                        </td>
                        <form id="formdelete-{{$idx}}" action="{{route('permissionroles.destroy',$permissionrole->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{$permissionroles->links('pagination::bootstrap-4')}}

        </div>
    </div>
    {{-- End Page Content  --}}
@endsection
<!--End Content Area-->

{{-- START MODAL AREA  --}}
    {{-- start edit modal  --}}
        <div id="edit-modal" class="modal fade">
            <div class="modal-dialog modal-dialog-centered">
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

                                <div class="col-md-6 form-group mb-3">
                                    <label for="editrole_id">Role <span class="text-danger">*</span></label>
                                    <select name="editrole_id" id="editrole_id" class="form-control form-control-sm rounded-0 role_id">
                                        @foreach($roles as $role)
                                            <option value="{{$role['id']}}">{{$role['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 form-group mb-3">
                                    <label for="editpermission_id">Permission <span class="text-danger">*</span></label>
                                    <select name="editpermission_id" id="editpermission_id" class="form-control form-control-sm rounded-0">
                                        @foreach($permissions as $permission)
                                            <option value="{{$permission['id']}}">{{$permission['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
            

                                <div class="col-md-2 text-sm-end text-start mb-3">
                                    <button type="submit" class="btn btn-primary btn-sm rounded-0">Update</button>
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

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function(){

        // select2 
        $(".select2").select2()

         // Start Edit Form 

         $(document).on('click','.editform',function(e){
            
            // console.log($(this).attr('data-id'),$(this).data('name'));
            
            $("#editrole_id").val($(this).attr('data-role'));
            $("#editpermission_id").val($(this).attr('data-permission'));
            
            const getid = $(this).attr('data-id');
            $("#formaction").attr('action',`/permissionroles/${getid}`);

            e.preventDefault();
        })

        // End Edit Form 

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
                        url:'{{route("permissionroles.bulkdeletes")}}',
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

