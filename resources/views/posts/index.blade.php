@extends('layouts.adminindex')
@section('caption','Post List')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">
        <div class="col-md-12">

            <a href="{{route('posts.create')}}" class="btn btn-primary btn-sm rounded-0">Create</a>

            <hr/>

            <table class="table table-sm table-hover border">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Fee</th>
                        <th>Type</th>
                        <th>Tag</th>
                        <th>Att Form</th>
                        <th>Status</th>
                        <th>By</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($posts as $idx=>$post)
                <tr>
                        <td>{{++$idx}}</td>
                        <td><img src="{{asset($post->image)}}" class="rounded-circle" alt="{{$post->name}}" width="20" height="20"/> <a href="{{route('posts.show',$post->id)}}">{{Str::limit($post->title,20)}}</a></td>
                        <td>{{$post->startdate}}</td>
                        <td>{{$post->enddate}}</td>
                        <td>{{$post->starttime}}</td>
                        <td>{{$post->endtime}}</td>
                        <td>{{$post->fee}}</td>
                        <td>{{$post->type->name}}</td>
                        <td>{{$post->tag->name}}</td>
                        <td>{{$post->attstatus->name}}</td>
                        <td>{{$post->status->name}}</td>
                        <td>{{$post->user['name']}}</td>
                        <td>{{$post->created_at->format('d M Y')}}</td>
                        <td>{{$post->updated_at->format('d M Y')}}</td>
                        <td>
                            <a href="{{route('posts.edit',$post->id)}}" class="text-info "><i class="fas fa-pen"></i></a>
                            <a href="#" class="text-danger ms-2 delete-btns" data-idx="{{$post->regnumber}}"><i class="fas fa-trash-alt"></i></a>
                        </td>
                        <form id="formdelete-{{$post->regnumber}}" action="{{route('posts.destroy',$post->id)}}" method="POST">
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