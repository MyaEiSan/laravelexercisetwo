@extends('layouts.adminindex')
@section('caption','Create Post')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">
        <div class="col-md-12">
            <form action="/announcements" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12 form-group mb-5">
                                <label for="image" class="gallery">Choose Images</label>
                                <input type="file" name="image" id="image"  class="form-control form-control-sm rounded-0" value="{{old('image')}}" hidden /> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                       <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="title">Title <span class="text-danger">*</span></label>
                                @error('title')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                <input type="text" name="title" id="title" class="form-control form-control-sm rounded-0" placeholder="Enter Post Title" value="{{old('title')}}" /> 
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="post_id">Class <span class="text-danger">*</span></label>
                                @error('post_id')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                <select name="post_id" id="post_id" class="form-control form-control-sm rounded-0">
                                        <option selected disabled>Choose class</option>
                                        @foreach ($posts as $id=>$title)
                                            <option value="{{$id}}">{{$title}}</option>
                                        @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 form-group mb-3">
                                <label for="content">Content <span class="text-danger">*</span></label>
                                @error('content')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                <textarea name="content" id="content" class="form-control form-control-sm rounded-0" rows="5" placeholder="Say Somethings...">{{old('content')}}</textarea>
                            </div>

                            <div class="offset-md-9 mt-3 col-md-3 d-flex justify-content-end align-items-end">
                                <div>
                                    <a href="{{route('announcements.index')}}" class="btn btn-secondary btn-sm rounded-0">Cancel</a>
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

            //Start Single Image Preview 
			$("#image").change(function(){
				previewimages(this,'.gallery');
			});

            //End Single Image Preview 

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
</script>
@endsection