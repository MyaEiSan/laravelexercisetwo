@extends('layouts.adminindex')
@section('caption','Post List')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">
        <div class="col-md-12">
            <a href="{{route('posts.index')}}" class="btn btn-secondary btn-sm rounded-0">Close</a>
            @if(!$post->checkenroll($userdata->id))
            <a href="#createmodal" class="btn btn-primary btn-sm rounded-0" data-bs-toggle="modal">Enroll</a>
            @endif

            <hr/>

            <div class="row">
                <div class="col-md-4">
                    <div class="card rounded-0">
                        <div class="card-body">
                            <h5 class="card-title">{{$post->title}} | <span class="text-muted">{{$post->status->name}}</span></h5>
                        </div>
                        <ul class="list-group">
                            <li class="list-group-item fw-bold"><img src="{{asset($post->image)}}" alt="{{$post->title}}" width="200" /></li>
                        </ul>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <i class="fas fa-user fa-sm"></i> <span>{{$post["tag"]["name"]}}</span>
                                    <br/>
                                    <i class="fas fa-user fa-sm"></i> <span>{{$post["type"]["name"]}} : {{$post["fee"]}}</span>
                                    <br/>
                                    <i class="fas fa-user fa-sm"></i> <span>{{$post["user"]["name"]}}</span>
                                </div>
                                <div class="col-md-6">
                                    <i class="fas fa-file fa-sm"></i> <span>{{$post["attstatus"]["name"]}}</span>
                                    <br/>
                                    <i class="fas fa-calendar-alt fa-sm"></i> <span>{{date('d M Y',strtotime($post->created_at))}} | {{date('h:i:s A',strtotime($post->created_at))}}</span>
                                    <br/>
                                    <i class="fas fa-edit fa-sm"></i> <span>{{date('d M Y h:i:s A',strtotime($post->updated_at))}}</span>
                                </div>
                                <div class="col-md-6">
                                    <i class="fas fa-calendar fa-sm"></i>
                                   <span>
                                        @foreach ($dayables as $dayable )
                                            {{$dayable->name}} ,
                                        @endforeach
                                   </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="rounded-0">
                        <ul class="list-group text-center rounded-0">
                            <li class="list-group-item active">Information</li>
                        </ul>

                        {{-- start remark  --}}
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Remark Here</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$post->content}}</td>
                                </tr>
                            </tbody>
                        </table>

                        {{-- end remark  --}}
                    </div>
                   
                    <div class="col-md-12">
                        <div class="card rounded-0">
                            <div class="card-body">
                                <ul class="list-group chat-boxs">
                                    @foreach($comments as $comment)
                                        <li class="list-group-item mt-2">
                                            <div>
                                                <p>{{$comment->description}}</p>
                                            </div>
                                            <div>
                                                <span class="small fw-bold float-end">{{$comment->user->name}} | {{$comment->created_at->diffForHumans()}}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="card-body border-top">
                                <form action="{{route('comments.store')}}" method="POST">
                                    @csrf
                                    <div class="col-md-12 d-flex jsutify-between">
                                        <textarea name="description" id="description" class="form-control border-0 rounded-0" rows="1" style="resize: none;" placeholder="Comment here..."></textarea>
                                        <button type="submit" class="btn btn-info btn-sm text-light ms-3"><i class="fas fa-paper-plane"></i></button>
                                    </div>

                                    {{-- Start Hidden Fields  --}}

                                    <input type="hidden" name="commentable_id" id="commentable_id" value="{{$post->id}}" />
                                    <input type="hidden" name="commentable_type" id="commentable_type" value="App\Models\Post" />

                                    {{-- End Hidden Fields  --}}

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {{-- End Page Content  --}}

      {{-- START MODAL AREA  --}}
            {{-- start create modal  --}}
            <div id="createmodal" class="modal fade">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-0">
                        <div class="modal-header">
                            <h6 class="modal-title">Enroll Form</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('enrolls.store')}}" method="POST" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="row align-items-end">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="image" class="gallery">Choose Images</label>
                                        <input type="file" name="image" id="image"  class="form-control form-control-sm rounded-0" value="{{old('image')}}" hidden/> 
                                    </div>
                                    <div class="col-md-7 form-group">
                                        <label for="remark">Remark <span class="text-danger">*</span></label>
                                        <textarea name="remark" id="remark" class="form-control form-control-sm rounded-0" placeholder="Ener Remark">{{old('remark')}}</textarea> 
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary btn-sm rounded-0">Submit</button>
                                    </div>

                                     {{-- Start Hidden Fields  --}}

                                     <input type="hidden" name="post_id" value="{{$post->id}}" />
 
                                     {{-- End Hidden Fields  --}}

                                </div>
                
                            </form>
                        </div>
                        <div class="modal-footer">
    
                        </div>
                    </div>
                </div>
            </div>
            {{-- end create modal  --}}
    {{-- END MODAL AREA  --}}


@endsection
<!--End Content Area-->

@section('css')
    <style type="text/css">
        .chat-boxs{
            height: 200px;
            overflow-y: scroll;
        }

        /* start for image preview  */
        .gallery{
			width: 100%;
            height: 100%;
			background-color: #eee;
			color: #aaa;
            
            display: flex;
            justify-content: center;
            align-items: center;

			text-align: center;
			padding: 10px;
		}

		.gallery img{
			width: 100px;
			height: 100px;
			border: 2px dashed #aaa;
			border-radius: 10px;
			object-fit: cover;

			padding: 5px;
			margin: 0 5px;
		}

        /* end image preview  */

    </style>
@endsection 

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
			// console.log('hi');

			var previewimages = function(input,output){

				// console.log(input.files);
				if(input.files){
					var totalfiles = input.files.length;
					console.log(totalfiles);

					if(totalfiles > 0){
						$(output).addClass("removetxt");
					}else{
						$(output).removeClass("removetxt");
					}

					for(var i = 0; i< totalfiles; i++){
						var filereader = new FileReader();

						filereader.onload = function(e){
                            $(output).html('');
							$($.parseHTML("<img/>")).attr("src",e.target.result).appendTo(output);
						}

						filereader.readAsDataURL(input.files[i]);
					}
				}
			};

			$("#image").change(function(){
				previewimages(this,'.gallery');
			});

		});
</script>
@endsection