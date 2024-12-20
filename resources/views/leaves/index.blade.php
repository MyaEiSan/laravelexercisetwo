@extends('layouts.adminindex')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">
        @can('create',App\Models\Leave::class) 
            <div class="col-md-12">
                <a href="{{route('leaves.create')}}" class="btn btn-primary btn-sm rounded-0">Create</a>
            </div>
        @endcan
        <div class="col-md-12">
            <div class="mt-3">
                <a href="javascript:void(0);" id="bulkdelete-btn" class="btn btn-danger btn-sm rounded-0 mb-2">Bulk Delete</a>
            </div>
            <div class="col-md-12">
                <form action="" method="">
                    <div class="row justify-content-end">
                        <div class="col-md-2 col-sm-6 mb-2">
                            <div class="input-group">
                                <select name="filter" id="filter" class="form-control form-control-sm rounded-0">
                                    @foreach($posts as $id=>$title)
                                        <option value="{{$id}}" @if($id == request('filter')) selected @endif>{{$title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                        </div>
                        <div class="col-md-2 col-sm-6 mb-2">
                            <div class="input-group">
                                <input type="text" name="search" id="search" class="form-control form-control-sm rounded-0" placeholder="Search..." value="{{request('search')}}"/>
                                <button type="button" id="btn-clear" class="btn btn-secondary btn-sm"><i class="fas fa-sync"></i></button>
                                <button type="submit" id="btn-search" class="btn btn-secondary btn-sm"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <table id="mytable" class="table table-sm table-hover border">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="selectalls[]" id="selectalls"  class="form-check-input selectalls"/>
                        </th>
                        <th>No</th>
                        <th>Student ID</th>
                        {{-- <th>Class</th> --}}
                        <th>Start Date</th>
                        <th>End Date</th>
                        {{-- <th>Tag</th> --}}
                        <th>Stage</th>
                        <th>By</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($leaves as $idx=>$leave)
                <tr id="delete_{{$leave->id}}">
                        <td>
                            <input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="{{$leave->id}}" />
                        </td>
                        <td>{{$idx + $leaves->firstItem()}}</td>
                        {{-- <td><a href="{{route('students.show',$leave->studenturl())}}">{{$leave->student($leave->user_id)}}</a></td> --}}
                        {{-- <td><a href="{{route('posts.show',$leave->post_id)}}">{{$leave->post['title']}}</a></td> --}}
                        <td>
                            <a href="{{route('leaves.show',$leave->id)}}">{{Str::limit($leave->title,20)}}</a>
                        </td>
                        <td>{{$leave->startdate}}</td>
                        <td>{{$leave->enddate}}</td>
                        {{-- <td>{{$leave->tagperson['name']}}</td> --}}
                        <td>{{$leave->stage['name']}}</td>
                        <td>{{$leave->user['name']}}</td>
                        <td>{{$leave->created_at->format('d M Y')}}</td>
                        <td>{{$leave->updated_at->format('d M Y')}}</td>
                        <td>
                            <a href="{{route('leaves.show',$leave->id)}}" class="text-primary "><i class="fas fa-book-reader"></i></a>
                            <a href="{{route('leaves.edit',$leave->id)}}" class="text-info ms-2"><i class="fas fa-pen"></i></a>
                            <a href="#" class="text-danger ms-2 delete-btns" data-idx="{{$leave->id}}"><i class="fas fa-trash-alt"></i></a>
                        </td>
                        <form id="formdelete-{{$leave->id}}" action="{{route('leaves.destroy',$leave->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{$leaves->appends(request()->only('filter'))->links()}}

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
    // Start Filter 

    document.getElementById('filter').addEventListener('change',function(){
        let getfilterid = this.value || this.options[this.selectedIndex].value;
        window.location.href = window.location.href.split('?')[0]+'?filter='+getfilterid;
    })

    // End Filter 

    // Start Btn Clear 

    document.getElementById('btn-clear').addEventListener('click',function(){
        const getfilter = document.getElementById('filter');
        const getsearch = document.getElementById('search');

        getfilter.selectedIndex = 0;
        getsearch.value = "";

        window.location.href = window.location.href.split('?')[0];
    })

    // End Btn Clear 

    // Start Autoshow Btn Clear 

    const autoshowbtn = function(){
        let getbtnclear = document.getElementById('btn-clear');
        let geturlquery = window.location.search;
        // console.log(geturlquery);
        let pattern = /[?&]search=/;


        if(pattern.test(geturlquery)){
            getbtnclear.style.display = "block";
        }else{
            getbtnclear.style.display = "none";
        }
    }

    autoshowbtn();

    // End Autoshow Btn Clear

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
        // $("#mytable").DataTable();

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
                        url:'{{route("leaves.bulkdeletes")}}',
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