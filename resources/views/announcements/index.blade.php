@extends('layouts.adminindex')
@section('caption','Post List')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">
        <div class="col-md-12">

            <a href="{{route('announcements.create')}}" class="btn btn-primary btn-sm rounded-0">Create</a>
            <div class="mt-3">
                <a href="javascript:void(0);" id="bulkdelete-btn" class="btn btn-danger btn-sm rounded-0 mb-2">Bulk Delete</a>
            </div>
            <hr/>

            <table id="mytable" class="table table-sm table-hover border">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="selectalls[]" id="selectalls"  class="form-check-input selectalls"/>
                        </th>
                        <th>ID</th>
                        <th>Title</th>
                        <td>Class</td>
                        <th>By</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($announcements as $idx=>$announcement)
                <tr id="delete_{{$announcement->id}}">
                        <td>
                            <input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="{{$announcement->id}}" />
                        </td>
                        <td>{{++$idx}}</td>
                        <td><img src="{{asset($announcement->image)}}" class="rounded-circle" alt="{{$announcement->name}}" width="20" height="20"/> <a href="{{route('announcements.show',$announcement->id)}}">{{Str::limit($announcement->title,20)}}</a></td>
                        <td><a href="{{route('posts.show',$announcement->post->id)}}">{{$announcement->post->title}}</a></td>
                        <td>{{$announcement->user['name']}}</td>
                        <td>{{$announcement->created_at->format('d M Y')}}</td>
                        <td>{{$announcement->updated_at->format('d M Y')}}</td>
                        <td>
                            <a href="{{route('announcements.edit',$announcement->id)}}" class="text-info "><i class="fas fa-pen"></i></a>
                            <a href="#" class="text-danger ms-2 delete-btns" data-idx="{{$announcement->regnumber}}"><i class="fas fa-trash-alt"></i></a>
                        </td>
                        <form id="formdelete-{{$announcement->regnumber}}" action="{{route('announcements.destroy',$announcement->id)}}" method="POST">
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

@section('css')
    {{-- <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/> --}}
@endsection

@section('scripts')
{{-- <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js" type="text/javascript"></script> --}}
<script>
    $(document).ready(function(){

        // Start delete btn 
        $('.delete-btns').click(function(){

            var getidx = $(this).data('idx');

            if(confirm(`Are you sure !!! you want to delete ${getidx}?`)){
                $("#formdelete-"+getidx).submit();
            }else{
                return false;
            }
        });

        // End delete btn 

        // for mytable 
        // let table = new DataTable('#mytable');
        $("#mytable").DataTable();

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
                        url:'{{route("announcements.bulkdeletes")}}',
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

    });
</script>
@endsection