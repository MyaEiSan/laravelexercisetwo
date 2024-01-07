@extends('layouts.adminindex')
@section('caption','Role List')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">
        <div class="col-md-12">

            <a href="{{route('roles.create')}}" class="btn btn-primary btn-sm rounded-0">Create</a>

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

           <div class="col-md-12">
                <table id="role-table" class="table table-sm table-hover border">
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
                    @foreach($roles as $idx=>$role)
                    <tr>
                            <td>{{++$idx}}</td>
                            <td><img src="{{asset($role->image)}}" class="rounded-circle" alt="{{$role->name}}" width="20" height="20"/> <a href="{{route('roles.show',$role->id)}}">{{$role->name}}</a></td>
                        
                            <td>{{$role->status->name}}</td>
                            <td>{{$role->user['name']}}</td>
                            <td>{{$role->created_at->format('d M Y')}}</td>
                            <td>{{$role->updated_at->format('d M Y')}}</td>
                            <td>
                                {{-- <a href="{{route('roles.show',$role->id)}}" class="text-info "><i class="fas fa-pen"></i></a> --}}
                                <a href="{{route('roles.edit',$role->id)}}" class="text-info "><i class="fas fa-pen"></i></a>
                                <a href="#" class="text-danger ms-2 delete-btns" data-idx="{{$role->regnumber}}"><i class="fas fa-trash-alt"></i></a>
                            </td>
                            <form id="formdelete-{{$role->regnumber}}" action="{{route('roles.destroy',$role->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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
    })
</script>
@endsection