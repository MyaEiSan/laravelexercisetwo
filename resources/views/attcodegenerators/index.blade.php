@extends('layouts.adminindex')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">

        <div class="col-md-12 mb-3">
            <form action="{{route('attcodegenerators.store')}}" method="POST">
                {{csrf_field()}}
                <div class="row align-items-end">
                    <div class="col-md-3 form-group mb-3">
                        <label for="classdate">Class Date <span class="text-danger">*</span></label>
                        @error('classdate')
                           <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="date" name="classdate" id="classdate" class="form-control form-control-sm rounded-0" value="{{$gettoday}}" /> 
                    </div>

                    <div class="col-md-3 form-group mb-3">
                        <label for="post_id">Class <span class="text-danger">*</span></label>
                        @error('post_id')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        <select name="post_id" class="form-control form-control-sm rounded-0">
                            <option selected disabled>Choose Class</option>
                            @foreach($posts as $post)
                                <option value="{{$post->id}}">{{$post->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group mb-3">
                        <label for="editstatus_id">Status <span class="text-danger">*</span></label>
                        <select name="status_id" id="editstatus_id" class="form-control form-control-sm rounded-0">
                            @foreach($statuses as $status)
                                <option value="{{$status['id']}}">{{$status['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group mb-3">
                        <label for="attcode">Attendance Code <span class="text-danger">*</span></label>
                        @error('attcode')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="text" name="attcode" id="attcode" class="form-control form-control-sm rounded-0" value="{{old('attcode')}}" /> 
                    </div>

                    <div class="col-md-3">
                        <button type="reset" class="btn btn-secondary btn-sm rounded-0">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm rounded-0">Submit</button>
                    </div>
                </div>

            </form>
        </div>

        <div class="mb-3">
            <a href="javascript:void(0);" id="bulkdelete-btn" class="btn btn-danger btn-sm rounded-0 mb-2">Bulk Delete</a>
        </div>

        <div class="col-md-12">
            <table id="attendedform-table" class="table table-sm table-hover border">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="selectalls[]" id="selectalls"  class="form-check-input selectalls"/>
                        </th>
                        <th>No</th>
                        <th>CLass</th>
                        <th>Att Code</th>
                        <th>By</th>
                        <th>Class Date</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($attcodegenerators as $idx=>$attcodegenerator)
                <tr id="delete_{{$attcodegenerator->id}}">
                        <td>
                            <input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="{{$attcodegenerator->id}}" />
                        </td>
                        <td>{{++$idx}}</td>
                        <td>{{$attcodegenerator->post->title}}</td>
                       
                        <td>{{$attcodegenerator->attcode}}</td>
                        <td>{{$attcodegenerator->user['name']}}</td>
                        <td>{{$attcodegenerator->classdate}}</td>
                        <td>{{$attcodegenerator->created_at->format('d M Y')}}</td>
                        <td>
                            <div class="form-checkbox form-switch">
                                <input type="checkbox" class="form-check-input change-btn" {{$attcodegenerator->status_id === 3 ? 'checked':''}} data-id="{{$attcodegenerator->id}}"/>
                            </div>
                        </td>
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

       // Start change-btn 

       $('.change-btn').change(function(){
            
            var getid = $(this).data('id');
            // console.log(getid);
            var setstatus = $(this).prop('checked') === true? 3 : 4;
            // console.log(setstatus);

            $.ajax({
                url: "attcodegeneratorsstatus" ,
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

        // Start Delete Item

        $('.delete-btns').click(function(){

            var getidx = $(this).data('idx');

            if(confirm(`Are you sure !!! you want to delete ${getidx}?`)){
                $("#formdelete-"+getidx).submit();
            }else{
                return false;
            }
        })

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
                        url:'{{route("attcodegenerators.bulkdeletes")}}',
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