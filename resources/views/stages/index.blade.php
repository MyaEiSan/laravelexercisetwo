@extends('layouts.adminindex')
@section('caption','Stage List')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">

        <div class="col-md-12">
            <a href="#createmodal" class="btn btn-primary btn-sm rounded-0" data-bs-toggle="modal">Create</a>
            <hr/>
            <table class="table table-sm table-hover border">
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
                @foreach($stages as $idx=>$stage)
                <tr>
                        <td>{{++$idx}}</td>
                        <td>{{$stage->name}}</td>
                       
                        <td>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" {{ $stage->status_id === 3 ? 'checked':'' }} />
                            </div>
                        </td>
                        <td>{{$stage->user['name']}}</td>
                        <td>{{$stage->created_at->format('d M Y')}}</td>
                        <td>{{$stage->updated_at->format('d M Y')}}</td>
                        <td>
                            <a href="javascript:void(0);" class="text-info editform" data-bs-toggle="modal" data-bs-target="#edit-modal" data-id="{{$stage->id}}" data-name="{{$stage->name}}" data-status="{{$stage->status_id}}"><i class="fas fa-pen"></i></a>
                            <a href="#" class="text-danger ms-2 delete-btns" data-idx="{{$idx}}"><i class="fas fa-trash-alt"></i></a>
                        </td>
                        <form id="formdelete-{{$idx}}" action="{{route('stages.destroy',$stage->id)}}" method="POST">
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

    {{-- START MODAL AREA  --}}
            {{-- start create modal  --}}
            <div id="createmodal" class="modal fade">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-0">
                        <div class="modal-header">
                            <h6 class="modal-title">Create Form</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('stages.store')}}" method="POST">
                                {{csrf_field()}}
                                <div class="row align-items-end">
                                    <div class="col-md-7 form-group">
                                        <label for="name">Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" placeholder="Ener Status Name" value="{{old('name')}}" /> 
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="status_id">Status <span class="text-danger">*</span></label>
                                        <select name="status_id" id="status_id" class="form-control form-control-sm rounded-0">
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
            $("#formaction").attr('action',`/stages/${getid}`);

            e.preventDefault();
        })

        // End Edit Form 

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

    })
</script>
@endsection