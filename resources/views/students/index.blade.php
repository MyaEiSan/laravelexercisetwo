@extends('layouts.adminindex')
@section('caption','Student List')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">
        <div class="col-md-12">

            <a href="{{route('students.create')}}" class="btn btn-primary btn-sm rounded-0">Create</a>

            <hr/>

            <table class="table table-sm table-hover border">
                <thead>
                    <tr>
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
                <tr>
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
    })
</script>
@endsection