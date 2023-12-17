@extends('layouts.adminindex')
@section('caption','Role List')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">
        <div class="col-md-12">

            <a href="{{route('roles.create')}}" class="btn btn-primary btn-sm rounded-0">Create</a>

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
    })
</script>
@endsection