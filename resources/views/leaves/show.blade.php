@extends('layouts.adminindex')
@section('caption','leave Show')
@section('content')

    <!-- Start Page Content Area -->

    <div class="container-fluid">

   

        <div class="col-md-12">

            <a href="javascript:void(0);" id="btn-back" class="btn btn-secondary btn-sm rounded-0">Back</a>
            <a href="{{route('leaves.index')}}" class="btn btn-secondary btn-sm rounded-0">Close</a>

            <hr/>

            <div class="row">
                
            <div class="col-md-4 col-lg-3 mb-2">   
                <h6>Info</h6>
                <div class="card border-0 rounded-0 shadow">

                    <div class="card-body">

                        <div class="d-flex flex-column align-items-center mb-3">
                            <div class="h5 mb-1">{{$leave->title}}</div>
                            <div class="text-muted">
                                <span>{{$leave["stage"]["name"]}} : {{$leave->fee}}</span>
                            </div>
                            <img src="{{asset($leave->image)}}" alt="{{$leave->title}}" width="200" />
                        </div>   
                        
                        <div class="w-100 d-flex flex-row justify-content-between mb-3">
                           
                            <a href="#createmodal" class="w-100 btn btn-primary btn-sm rounded-0 me-2" data-bs-toggle="modal">Enroll</a>
                            <button type="button" class="w-100 btn btn-outline-primary btn-sm rounded-0">Follow</button>
                        </div>

                        <div class="mb-5">

                            <div class="row g-0 mb-2">
                                <div class="col-auto">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="col ps-3">
                                    <div class="row">
                                        <div class="col">
                                            <div>Authorize</div>
                                        </div>
                                        <div class="col-auto">
                                            <div>
                                                @foreach($leave->tagpersons($leave->tag) as $id=>$name) 
                                                    <a href="{{route('students.show',$leave->tagpersonurl($id))}}">{{$name}}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-0 mb-2">
                                <div class="col-auto">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="col ps-3">
                                    <div class="row">
                                        <div class="col">
                                            <div>Created</div>
                                        </div>
                                        <div class="col-auto">
                                            <div>{{date('d M Y',strtotime($leave->created_at))}} | {{date('h:i:s A',strtotime($leave->created_at))}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-0 mb-2">
                                <div class="col-auto">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div class="col ps-3">
                                    <div class="row">
                                        <div class="col">
                                            <div>Updated</div>
                                        </div>
                                        <div class="col-auto">
                                            <div>{{date('d M Y',strtotime($leave->updated_at))}} | {{date('h:i:s A',strtotime($leave->updated_at))}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="mb-5">
                            <p class="text-small text-muted text-uppercase mb-2">Class Day</p>
                            
                            {{-- @foreach($dayables as $dayable) --}}
                                 <div class="row g-0 mb-2">
                                    <div class="col-auto me-2">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    {{-- <div class="col ">{{$dayable['name']}}</div> --}}
                                </div>
                            {{-- @endforeach --}}
                            
                        </div>


                        <div class="mb-5">
                            <p class="text-small text-muted text-uppercase mb-2">Contact Info</p>
                            <div class="row g-0 mb-2">
                                <div class="col-auto me-2">
                                    <i class="fas fa-info"></i>
                                </div>
                                <div class="col ">Sample Data</div>
                            </div>
                            
                            <div class="row g-0 mb-2">
                                <div class="col-auto me-2">
                                    <i class="fas fa-info"></i>
                                </div>
                                <div class="col ">Sample Data</div>
                            </div>

                            <div class="row g-0 mb-2">
                                <div class="col-auto me-2">
                                    <i class="fas fa-info"></i>
                                </div>
                                <div class="col ">Sample Data</div>
                            </div>

                            <div class="row g-0 mb-2">
                                <div class="col-auto me-2">
                                    <i class="fas fa-info"></i>
                                </div>
                                <div class="col ">Sample Date</div>
                            </div>

                        </div>


                    </div>

                </div>

            </div>

            <div class="col-md-8 col-lg-9">  
                <h6>Compose</h6>
                <div class="card border-0 rounded-0 shadow mb-4">
                    <div class="card-body">
                        <div class="accordion">
                            <div class="acctitle">Email</div>
                            <div class="acccontent">
                                <div class="col-md-12 py-3">
                                    <form action="{{route('students.mailbox')}}" method="POST">
                                        @csrf 
                                        <div class="row">
                                            <div class="col-md-6 from-group mb-3">
                                                <input type="email" name="cmpemail" id="cmpemail" class="form-control from-control-sm rounded-0" placeholder="To:" value="{{$leave->user["email"]}}" readonly/>
                                            </div>
                                            <div class="col-md-6 from-group mb-3">
                                                <input type="text" name="cmpsubject" id="cmpsubject" class="form-control from-control-sm rounded-0" placeholder="Subject:" value=""/>
                                            </div>
                                            <div class="col-md-12 from-group mb-2">
                                                <textarea  name="cmpcontent" id="cmpcontent" class="form-control from-control-sm rounded-0" rows="3" style="resize:none;" placeholder="Your message here..."></textarea>
                                            </div>
                                            <div class="col d-flex justify-content-end align-items-end">
                                                <button type="submit" class="btn btn-secondary btn-sm rounded-0">Send</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h6>Class</h6>
                <div class="card border-0 rounded-0 shadow mb-4">
                    <div class="card-body d-flex flex-wrap gap-3">
                        @foreach ($leave->tagposts($leave->post_id) as $id=>$title)
                        <div class="border shadow p-3 mb-3 enrollboxes">
                            <a href="{{route('posts.show',$id)}}">{{$title}}</a>
                        </div>  
                        @endforeach
                    </div>
                </div>

                <h6>Additional Info</h6>
                <div class="card border-0 rounded-0 shadow mb-4">
                        <ul class="nav"> 
                            <li class="nav-item">
                                <button type="button" id="autoclick" class="tablinks active" onclick="gettab(event,'follower')">Content</button>
                            </li>
                            
                        </ul>
                
                        <div class="tab-content">
                
                            <div id="follower" class="tab-panel">
                                <h6>This is Home informations</h6>
                                <p>{!! $leave->content !!}</p>
                            </div>
                        </div>

                </div>




            </div>

            </div>



        </div>

    </div>


	<!-- End Page Content Area -->


    <!-- START MODAL AREA  -->


    <!-- start create modal  -->
    <div id="createmodal" class="modal fade ">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content rounded-0">

            <div class="modal-header">
                <h6 class="modal-title">Enroll Form</h6>
                <button type="type" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

            <form action="{{route('enrolls.store')}}" method="leave" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="row align-items-end">

                    <div class="col-md-12 form-group mb-3">
                        <label for="image" class="gallery"><span>Choose Images</span></label>
                        <input type="file" name="image" id="image" class="form-control form-control-sm rounded-0"value="{{old('image')}}" hidden />
                    </div>

                    <div class="col-md-10 form-group">
                        <label for="remark">Remark <span class="text-danger">*</span></label>
                        <textarea name="remark" id="remark" class="form-control form-control-sm rounded-0" rows="3" placeholder="Enter Remark">{{old('remark')}}</textarea>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-sm rounded-0">Submit</button>
                    </div>

                    <!-- Start Hidden Fields -->
                    <input type="hidden" name="leave_id" value="{{$leave->id}}" />
                    <!-- End Hidden Fields -->

                </div>

            </form>

            </div>

            <div class="modal-footer">
            </div>

            </div>
        </div>
    </div>
<!-- end create modal  -->

<!-- END MODAL AREA  -->


    
@endsection

@section('css')
    <style type="text/css">
    .accordion{
	width: 100%;
}

.acctitle{
	font-size: 14px;
	user-select: none;

	padding: 5px;
	margin: 0;

	cursor: pointer;

	position: relative;
}


.acctitle::after{
	content: '\f0e0'; /* + */
	font-family: "Font Awesome 5 Free";

	/*position: absolute;
	right: 15px;
	top: 50%;
	transform: translateY(-50%);*/

	float: right;
}

.shown.acctitle::after{
	content: '\f2b6';
}

/* .active::after{
	content: '\f068';
} */

.acccontent{
	height: 0;
	background-color: #f4f4f4;
	
	text-align: justify;
	font-size: 14px;

	padding: 0 10px;

	overflow: hidden;

	transition: height 0.3s ease-in-out;
}
/* End Accordion  */
    .nav{
        display: flex;
        background-color: #f1f1f1;
        border: 1px solid #ccc;

        padding: 0;
        margin: 0;
    }

    .nav .nav-item{
        list-style-type: none;
    }

    .nav .tablinks{
        border: none;
        padding: 15px 20px;
        cursor: pointer;

        transition: background-color .3s ease-in;
    }

    .nav .tablinks:hover{
        background-color: #f3f3f3;
    }

    .nav .tablinks.active{
        color: blue;
    }


    .tab-pane{
        padding: 5px 15px;

        display: none;
    }

    /* End Tab Box  */
    </style>
@endsection

@section('scripts')
<script type="text/javascript">

        // Start Back Btn
            const getbtnback =  document.getElementById('btn-back');
            getbtnback.addEventListener('click',function(){
                // window.history.back();
                window.history.go(-1);
            });
        // End Back Btn 

        // Start Tab Box
            let gettablinks = document.getElementsByClassName('tablinks'),
                gettabpanels = document.getElementsByClassName('tab-panel');

            // console.log(gettablinks);
            // console.log(gettablinks[0]);

            // console.log(gettabpanels);

        let tabpanels = Array.from(gettabpanels);
        // console.log(tabpanels);


        function gettab(evn,link){
            // console.log(evn.target);
            // console.log(evn.currentTarget);
            // console.log(link);

            // Remove Active 
            for(var x=0; x < gettablinks.length; x++){
                // console.log(x); //0 to 3

                // remove active 
                gettablinks[x].className = gettablinks[x].className.replace(' active','');
            }

            // Add active 

            // evn.target.className = "tablinks active";
            // evn.target.className += " active";
            // evn.currentTarget.className += " active";
            // evn.target.className = evn.target.className.replace('tablinks','tablinks active');
            evn.target.classList.add('active');

            // Hide Panel 
            tabpanels.forEach(function(tabpanel){
                tabpanel.style.display = "none";
            });

            // Show Panel
            document.getElementById(link).style.display= "block";
        }


        document.getElementById('autoclick').click();
        // End Tab Box

        // End Tab Box 

// Start Accordion
var getacctitles = document.getElementsByClassName("acctitle");
// console.log(getacctitles); //HTML Collection
var getacccontents = document.querySelectorAll(".acccontent");
// console.log(getacccontent); //NodeList


for(var x = 0; x < getacctitles.length; x++){
	// console.log(x);

	getacctitles[x].addEventListener('click',function(e){
		// console.log(e.target);
		// console.log(this);

		this.classList.toggle("shown");
		var getcontent = this.nextElementSibling;
		// console.log(getcontent);

		if(getcontent.style.height){
			getcontent.style.height = null; //beware can't set 0
		}else{
			// console.log(getcontent.scrollHeight);
			getcontent.style.height= getcontent.scrollHeight + "px";
		}
		
	});

	if(getacctitles[x].classList.contains("shown")){
		getacccontents[x].style.height = getacccontents[x].scrollHeight+"px";
	}

}
// End Accordion 
    
    </script>
@endsection