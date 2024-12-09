@extends('layouts.adminindex')
@section('caption','Permission List')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">
        <div class="col-md-12">

            <a href="{{route('permissions.create')}}" class="btn btn-primary btn-sm rounded-0">Create</a>

            <hr/>

            <div class="col-md-12">
                <form action="" method="">
                    <div class="row justify-content-end">
                        <div class="col-md-2 col-sm-6 mb-2">
                            <div class="form-group">
                                <select name="filterstatus_id" id="filterstatus_id" class="form-control form-control-sm rounded-0">
                                    {{-- <option value="" selected>Choose Status...</option> --}}
                                    @foreach($filterstatuses as $id=>$name)
                                    <option value="{{$id}}" {{$id == request('filterstatus_id')?'selected':''}}>{{$name}}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div>
                <a href="javascript:void(0);" id="bulkdelete-btn" class="btn btn-danger btn-sm rounded-0 mb-2">Bulk Delete</a>
            </div>
           <div class="col-md-12">
                <table id="role-table" class="table table-sm table-hover border">
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
                    @foreach($permissions as $idx=>$permission)
                    <tr id="delete_{{$permission->id}}">
                            {{-- <td>{{++$idx}}</td> --}}
                            <td>
                                <input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="{{$permission->id}}" />
                            </td>
                            <td>{{$idx + $permissions->firstItem()}}</td>
                            <td><a href="{{route('permissions.show',$permission->id)}}">{{$permission->name}}</a></td>
                    
                            <td>
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input change-btn" {{ $permission->status_id === 3 ? 'checked':'' }} data-id="{{$permission->id}}" />
                                </div>
                            </td>
                            <td>{{$permission->user['name']}}</td>
                            <td>{{$permission->created_at->format('d M Y')}}</td>
                            <td>{{$permission->updated_at->format('d M Y')}}</td>
                            <td>
                                {{-- <a href="{{route('permissions.show',$permission->id)}}" class="text-info "><i class="fas fa-pen"></i></a> --}}
                                <a href="{{route('permissions.edit',$permission->id)}}" class="text-info "><i class="fas fa-pen"></i></a>
                                <a href="#" class="text-danger ms-2 delete-btns" data-idx="{{$permission->id}}"><i class="fas fa-trash-alt"></i></a>
                            </td>
                            <form id="formdelete-{{$permission->id}}" action="{{route('permissions.destroy',$permission->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{$permissions->links('pagination::bootstrap-4')}}
           </div>

        </div>
    </div>
    {{-- End Page Content  --}}
@endsection
<!--End Content Area-->

@section('scripts')
<script>

     // Start Filter 

     const getfilterstatus = document.getElementById('filterstatus_id');

     getfilterstatus.addEventListener('click', function(){
        // const getstatusid = this.value;
        const getstatusid = this.value || this.options[this.selectedIndex].value;
        // console.log(getstatusid);
        let getcururl = window.location.href;

        // console.log(getcururl);
        // console.log(getcururl.split('?'));
        // console.log(getcururl.split('?')[0]);

        window.location.href = getcururl.split('?')[0] + '?filterstatus_id='+getstatusid;
        

        e.preventDefault();
    });

    // End Filter 
    $(document).ready(function(){
        $('.delete-btns').click(function(){

            var getidx = $(this).data('idx');

            if(confirm(`Are you sure !!! you want to delete ${getidx}?`)){
                $("#formdelete-"+getidx).submit();
            }else{
                return false;
            }
        })

        // $("#role-table").DataTable();

        // Start change-btn 

        $('.change-btn').change(function(){
            
            var getid = $(this).data('id');
            // console.log(getid);
            var setstatus = $(this).prop('checked') === true? 3 : 4;
            // console.log(setstatus);

            $.ajax({
                url: "permissionsstatus" ,
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
                        url:'{{route("permissions.bulkdeletes")}}',
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