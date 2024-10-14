@extends('layouts.adminindex')
@section('caption','Student List')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">
        <div class="col-md-12">
            <a href="{{route('leads.index')}}" class="btn btn-primary btn-sm rounded-0">Lead</a>
            <a href="{{route('students.create')}}" class="btn btn-primary btn-sm rounded-0">Create</a>

            <hr/>
            <div>
                <a href="javascript:void(0);" id="bulkdelete-btn" class="btn btn-danger btn-sm rounded-0 mb-2">Bulk Delete</a>
            </div>

            <table id="student-table" class="table table-sm table-hover border">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="selectalls[]" id="selectalls"  class="form-check-input selectalls"/>
                        </th>
                        <th>ID</th>
                        <th>Reg Number</th>
                        <th>Name</th>
                        <th>Remark</th>
                        <th>Status</th>
                        <th>By</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($students as $idx=>$student)

    
                <tr id="delete_{{$student->id}}">
                        <td>
                            <input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="{{$student->id}}" />
                        </td>
                        <td>{{++$idx}}</td>
                        <td><a href="{{route('students.show',$student->id)}}">{{$student->regnumber}}</a></td>
                        <td>{{$student->firstname}} {{$student->lastname}}</td>
                        <td>{{Str::limit($student->remark,10)}}</td>
                        <td>{{$student->status->name}}</td>
                        <td>{{$student->user['name']}}</td>
                        <td>{{$student->created_at->format('d M Y')}}</td>
                        <td>{{$student->updated_at->format('d M Y')}}</td>
                        <td>
                            {{-- <a href="{{route('students.show',$student->id)}}" class="text-info "><i class="fas fa-pen"></i></a> --}}
                            <a href="{{route('students.edit',$student->id)}}" class="text-info "><i class="fas fa-pen"></i></a>
                            <a href="#" class="text-danger ms-2 delete-btns" data-idx="{{$student->regnumber}}"><i class="fas fa-trash-alt"></i></a>
                        </td>
                        <form id="formdelete-{{$student->regnumber}}" action="{{route('students.destroy',$student->id)}}" method="POST">
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

@section('scripts')
<script>
    $(document).ready(function(){
        $('.delete-btns').click(function(){

            var getidx = $(this).data('idx');

            if(confirm(`Are you sure !!! you want to delete ${getidx}?`)){
                $("#formdelete-"+getidx).submit();
            }else{
                return false;
            }
        })

        $("#student-table").DataTable();

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
                        url:'{{route("students.bulkdeletes")}}',
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