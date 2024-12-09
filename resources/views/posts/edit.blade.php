@extends('layouts.adminindex')
@section('caption','Edit Post')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">
        <div class="col-md-12">
            <form action="{{route('posts.update',$post->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <div class="row">
                                    <div class="col-md-6 text-sm-center">
                                        <img src="{{asset($post->image)}}" alt="{{$post->image}}"  />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="image" class="gallery">Choose Images</label>
                                        <input type="file" name="image" id="image"  class="form-control form-control-sm rounded-0" value="{{$post->image}}" hidden/> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="startdate">Start Date <span class="text-danger">*</span></label>
                                @error('startdate')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                <input type="date" name="startdate" id="startdate" class="form-control form-control-sm rounded-0" placeholder="Enter Start Date" value="{{$post->startdate}}" /> 
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="enddate">End Date <span class="text-danger">*</span></label>
                                @error('enddate')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                <input type="date" name="enddate" id="enddate" class="form-control form-control-sm rounded-0" placeholder="Enter End Date" value="{{$post->enddate}}" /> 
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="starttime">Start Time <span class="text-danger">*</span></label>
                                @error('starttime')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                <input type="time" name="starttime" id="starttime" class="form-control form-control-sm rounded-0" placeholder="Enter Start Time" value="{{$post->starttime}}" /> 
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="endtime">End Time <span class="text-danger">*</span></label>
                                @error('endtime')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                <input type="time" name="endtime" id="endtime" class="form-control form-control-sm rounded-0" placeholder="Enter Start Time" value="{{$post->endtime}}" /> 
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Days</label>
                                <div class="d-flex flex-wrap">
                                    {{-- @foreach ($days as $idx=>$day )
                                    <div class="form-check form-switch mx-3">
                                        <input type="checkbox" name="day_id[]" id="day_id{{$day->id}}" class="form-check-input dayactions" value="{{$day->id}}" 

                                        @foreach ($dayables as $dayable )
                                            @if ($dayable['id'] == $day['id'])
                                                checked
                                            @endif
                                        @endforeach
                                        
                                        /><label for="day_id{{$day->id}}">{{$day->name}}</label>
                                    </div>
                                    @endforeach --}}
                                    @foreach ($days as $idx=>$day )
                                    <div class="form-check form-switch mx-3">
                                        <input type="checkbox" name="day_id[]" id="day_id{{$day->id}}" class="form-check-input dayactions" value="{{$day->id}}" 

                                       {{in_array($day->id,$post->days->pluck('id')->toArray())?'checked':''}}
                                        
                                        /><label for="day_id{{$day->id}}">{{$day->name}}</label>
                                    </div>
                                    @endforeach
                                </div>

                                {{-- start hidden field  --}}
                                <input type="hidden" name="dayable_type" id="dayable_type" value="App\Models\Post" />
                                {{-- end hidden field --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                       <div class="row">
                        <div class="col-md-12 form-group mb-3">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            @error('title')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                            <input type="text" name="title" id="title" class="form-control form-control-sm rounded-0" placeholder="Enter Post Title" value="{{$post->title}}" /> 
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="type_id">Type <span class="text-danger">*</span></label>
                            @error('type_id')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                           <select name="type_id" id="type_id" class="form-control form-control-sm rounded-0">
                                <option selected disabled>Choose Type</option>
                                @foreach ($types as $type)
                                    <option value="{{$type->id}}" 
                                        @if($type['id'] === $post['type_id'])
                                            selected 
                                        @endif
                                        >{{$type->name}}</option>
                                @endforeach
                           </select>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="fee">Fee <span class="text-danger">*</span></label>
                            @error('fee')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                            <input type="number" name="fee" id="fee" class="form-control form-control-sm rounded-0" placeholder="Class Fee" value="{{$post->fee}}" /> 
                        </div>

                        <div class="col-md-12 form-group mb-3">
                            <label for="content">Content <span class="text-danger">*</span></label>
                            @error('content')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                            <textarea name="content" id="content" class="form-control form-control-sm rounded-0" rows="5" placeholder="Say Somethings...">{{$post->content}}</textarea>
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="tag_id">Tag <span class="text-danger">*</span></label>
                            @error('tag_id')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                           <select name="tag_id" id="tag_id" class="form-control form-control-sm rounded-0">
                                <option selected disabled>Choose Tag</option>
                                @foreach ($tags as $tag)
                                    <option value="{{$tag->id}}"
                                        @if($tag['id'] === $post['tag_id'])
                                            selected 
                                        @endif
                                        >{{$tag->name}}</option>
                                @endforeach
                           </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="attshow">Show on Att Form <span class="text-danger">*</span></label>
                            @error('attshow')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                           <select name="attshow" id="attshow" class="form-control form-control-sm rounded-0">
                                @foreach ($attshows as $attshow)
                                    <option value="{{$attshow->id}}"
                                        @if($attshow['id'] === $post['attshow'])
                                            selected 
                                        @endif
                                        >{{$attshow->name}}</option>
                                @endforeach
                           </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="status_id">Status <span class="text-danger">*</span></label>
                            @error('status_id')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                           <select name="status_id" id="status_id" class="form-control form-control-sm rounded-0">
                                @foreach ($statuses as $status)
                                    <option value="{{$status->id}}" {{$status['id'] === $post['status_id']?'selected':''}}>{{$status->name}}</option>
                                @endforeach
                           </select>
                        </div>

                        <div class="col-md-3 d-flex justify-content-end align-items-end">
                            <div>
                                <a href="{{route('posts.index')}}" class="btn btn-secondary btn-sm rounded-0">Cancel</a>
                                <button type="submit" class="btn btn-primary btn-sm rounded-0 ms-3">Submit</button>
                            </div>
                        </div>
                       </div>
                    </div>
                    
                </div>

            </form>
        </div>
    </div>
    {{-- End Page Content  --}}
@endsection
<!--End Content Area-->

@section('css')
{{-- summernote css1 js1 --}}
<link href="{{asset('assets/libs/summernote-0.8.18-dist/summernote-lite.min.css')}}" rel="stylesheet" type="text/css" />
<style type="text/css">

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

		.removetxt span{
			display: none;
		}
</style>

@endsection

@section('scripts')
{{-- summernote css1 js1  --}}
<script src="{{asset('assets/libs/summernote-0.8.18-dist/summernote-lite.min.js')}}" type="text/javascript"></script>
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


             //Start text editor for content 

             $('#content').summernote({
                placeholder: 'Say Something...',
                tabsize: 2,
                height: 120,
                toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']]
                ]
            });

             //End text editor for content 



		});

        // Start Day Action 
        // $('.dayactions').click(function(){

        //     var checkboxes = $("input[type='checkbox']");
        //     // console.log(checkboxes);

        //     var checked = checkboxes.filter(':checked').map(function(){
        //         // return this.value;
        //         $(this).attr('name','newday_id[]');
        //     });

        //     var unchecked = checkboxes.not(':checked').map(function(){
        //         // return this.value;
        //         $(this).attr('name','oldday_id[]');
        //     });

        //     // check or uncheck 

        //     // if($(this).prop('checked')){
        //     //     // console.log('yes');
        //     //     console.log(checked);
        //     // }else{
        //     //     // console.log('no');
        //     //     console.log(unchecked);
        //     // }

        // })

        // End Day Action 
</script>
@endsection