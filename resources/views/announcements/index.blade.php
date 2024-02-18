@extends('layouts.adminindex')
@section('caption','Post List')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">
        <div class="col-md-12">

            <a href="{{route('announcements.create')}}" class="btn btn-primary btn-sm rounded-0">Create</a>

            <hr/>

            <table id="mytable" class="table table-sm table-hover border">
                <thead>
                    <tr>
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
                <tr>
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

    });
</script>
@endsection