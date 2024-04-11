@extends('layouts.adminindex')
@section('caption','Enroll List')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">

        <div class="col-md-12">
            <form action="{{route('attendances.store')}}" method="POST">
                {{csrf_field()}}
                <div class="row align-items-end mb-3">
                    <div class="col-md-3 form-group">
                        <label for="classdate">Class Date <span class="text-danger">*</span></label>
                        <input type="date" name="classdate" id="classdate" class="form-control form-control-sm rounded-0" value="{{old('classdate')}}" /> 
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="post_id">Class <span class="text-danger">*</span></label>
                        <select name="post_id" class="form-control form-control-sm rounded-0">
                            {{-- @foreach($posts as $post)
                                <option value="{{$post->id}}">{{$post->title}}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="attcode">Attendance Code <span class="text-danger">*</span></label>
                        <input type="text" name="attcode" id="attcode" class="form-control form-control-sm rounded-0" value="{{old('attcode')}}" /> 
                    </div>

                    <div class="col-md-3">
                        <button type="reset" class="btn btn-secondary btn-sm rounded-0">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm rounded-0">Submit</button>
                    </div>
                </div>

            </form>
        </div>

        <div class="col-md-12">
            <table id="attendedform-table" class="table table-sm table-hover border">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Student ID</th>
                        <th>Class</th>
                        <th>Stage</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($enrolls as $idx=>$enroll)
                <tr>
                        <td>{{++$idx}}</td>
                        {{-- <td>{{$enroll->student($enroll->user_id)}}</td> --}}
                        <td><a href="{{route('students.show',$enroll->studenturl())}}">{{$enroll->student($enroll->user_id)}}</a></td>
                        <td>{{$enroll->post->title}}</td> 
                        <td>{{$enroll->stage->name}}</td>
                        <td>{{$enroll->created_at->format('d M Y')}}</td>
                        <td>{{$enroll->updated_at->format('d M Y')}}</td>
                        <td>
                            <a href="javascript:void(0);" class="text-primary quickform" data-bs-toggle="modal" data-bs-target="#quickmodal" data-id="{{$enroll->id}}" data-remark="{{$enroll->remark}}" data-stageid="{{$enroll->stage_id}}"><i class="fas fa-user-check"></i></a>

                            <a href="javascript:void(0);" class="text-info editform" data-bs-toggle="modal" data-bs-target="#edit-modal" data-id="{{$enroll->id}}" data-remark="{{$enroll->remark}}" data-stageid="{{$enroll->stage_id}}"><i class="fas fa-pen"></i></a>
                        </td>
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
                            <div class="col-md-3 form-group">
                                <label for="edit_stage_id">Stage <span class="text-danger">*</span></label>
                                <select name="stage_id" id="edit_stage_id" class="form-control form-control-sm rounded-0">
                                    @foreach($stages as $stage)
                                        <option value="{{$stage->id}}">{{$stage->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="edit_remark">Remark <span class="text-danger">*</span></label>
                                <input type="text" name="remark" id="edit_remark" class="form-control form-control-sm rounded-0" value="{{old('remark')}}" /> 
                            </div>
                            <div class="col-md-2">
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
    {{-- start quick modal  --}}
    <div id="quickmodal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h6 class="modal-title">Edit Form</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="quickformaction" action="" method="POST">
                        {{csrf_field()}}
                        {{method_field('PUT')}}
                        <div class="row align-items-end">                          
                            <div class="col-md-3 form-group">
                                <label for="editstage_id">Stage <span class="text-danger">*</span></label>
                                <select name="editstage_id" id="editstage_id" class="form-control form-control-sm rounded-0">
                                    @foreach($stages as $stage)
                                        <option value="{{$stage->id}}">{{$stage->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-7 form-group">
                                <label for="editremark">Remark <span class="text-danger">*</span></label>
                                <input type="text" name="remark" id="editremark" class="form-control form-control-sm rounded-0" value="{{old('remark')}}" /> 
                            </div>
                            <div class="col-md-2">
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
    {{-- end quick modal  --}}
    {{-- END MODAL AREA  --}}

@endsection
<!--End Content Area-->

@section('scripts')
<script>
    $(document).ready(function(){

        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$("meta[name='csrf-token']").attr('content')
            }
        });

        // Start Edit Form 

        // $(document).on('click','.editform',function(e){
            
        //     // console.log($(this).attr('data-id'),$(this).data('name'));
            
        //     $("#edit_remark").val($(this).attr('data-remark'));
        //     $("#edit_stage_id").val($(this).data('stageid'));

        //     const getid = $(this).attr('data-id');
        //     $("#formaction").attr('action',`/enrolls/${getid}`);

        //     e.preventDefault();
        // })

         // End Edit Form 

          // Start Quick Form 
        $(document).on('click','.quickform',function(e){
            
            // console.log($(this).attr('data-id'),$(this).data('name'));
            
            $("#editremark").val($(this).attr('data-remark'));
            $("#editstage_id").val($(this).data('stageid'));

            const getid = $(this).attr('data-id');
            // console.log(getid);

            $("#quickformaction").attr('data-id',getid);
            console.log($("#quickformaction").attr('data-id'));
        })

        // End Quick Form 

        $("#quickformaction").submit(function(e){
            e.preventDefault();
            
            const getid = $(this).attr('data-id');

            $.ajax({
                url: `enrolls/${getid}` ,
                type: "PUT", 
                dataType: 'json', 
                data: $(this).serialize(), 
                success: function(response){
                    if(response && response.status === "success"){
                        console.log(response);
                        console.log(this.data);
                        $("#quickmodal").modal('hide');
                        console.log('i');
                    }
                }
            })
        })

        // Start Delete Item

        $('.delete-btns').click(function(){

            var getidx = $(this).data('idx');

            if(confirm(`Are you sure !!! you want to delete ${getidx}?`)){
                $("#formdelete-"+getidx).submit();
            }else{
                return false;
            }
        })

        // End Delete Item 

        $("#attendedform-table").DataTable();

    })
</script>
@endsection