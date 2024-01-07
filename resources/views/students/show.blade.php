@extends('layouts.adminindex')
@section('caption','Student List')
<!--Start Content Area-->
@section('content')
    {{-- Start Page Content  --}}
    <div class="container-fluid">
        <div class="col-md-12">

            <a href="javascript:void(0);" id="btn-back" class="btn btn-secondary btn-sm rounded-0">Back</a>
            <a href="{{route('students.index')}}" class="btn btn-primary btn-sm rounded-0">Close</a>

            <hr/>

            <div class="row">
                <div class="col-md-4 col-lg-3 mb-2">
                    <div class="card border-0 rounded-0 shadow">

                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center mb-3">
                                <div class="h5 mb-1">{{$student->firstname}} {{$student->lastname}}</div>
                                <div class="text-muted">
                                    <span>{{$student->regnumber}}</span>
                                </div>
                            </div>

                            <div class="w-100 d-flex flex-row justify-content-between mb-3">
                                <button type="button" class="w-100 btn btn-primary btn-sm rounded-0 me-2">Like</button>
                                <button type="button" class="w-100 btn btn-outline-primary btn-sm rounded-0">Follow</button>
                            </div>

                            <div  class="mb-5">
                                <div class="row g-0 mb-2">
                                    <div class="col-auto">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="col ps-3">
                                        <div class="row">
                                            <div class="col">
                                                <div class="">Status</div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="">{{ $student->status['name'] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-0 mb-2">
                                    <div class="col-auto">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="col ps-3">
                                        <div class="row">
                                            <div class="col">
                                                <div class="">Authorize</div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="">{{ $student['user']['name'] }}</div>
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
                                                <div class="">Created</div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="">{{date('d M Y',strtotime($student->created_at))}} | {{date('h:i:s A',strtotime($student->created_at))}}</div>
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
                                                <div class="">Created</div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="">{{date('d M Y',strtotime($student->updated_at))}} | {{date('h:i:s A',strtotime($student->updated_at))}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div  class="mb-5">
                                <p class="text-small text-muted text-uppercase mb-2">Personal Info</p>
                                <div class="row g-0 mb-2">
                                    <div class="col-auto me-2">
                                        <i class="fas fa-info"></i>
                                    </div>
                                    <div class="col">Sample Data</div>
                                </div>
                                <div class="row g-0 mb-2">
                                    <div class="col-auto me-2">
                                        <i class="fas fa-info"></i>
                                    </div>
                                    <div class="col">Sample Data</div>
                                </div>
                                <div class="row g-0 mb-2">
                                    <div class="col-auto me-2">
                                        <i class="fas fa-info"></i>
                                    </div>
                                    <div class="col">Sample Data</div>
                                </div>
                                <div class="row g-0 mb-2">
                                    <div class="col-auto me-2">
                                        <i class="fas fa-info"></i>
                                    </div>
                                    <div class="col">Sample Data</div>
                                </div>

                            </div>

                            <div  class="mb-5">
                                <p class="text-small text-muted text-uppercase mb-2">Contact Info</p>
                                <div class="row g-0 mb-2">
                                    <div class="col-auto me-2">
                                        <i class="fas fa-info"></i>
                                    </div>
                                    <div class="col">Sample Data</div>
                                </div>
                                <div class="row g-0 mb-2">
                                    <div class="col-auto me-2">
                                        <i class="fas fa-info"></i>
                                    </div>
                                    <div class="col">Sample Data</div>
                                </div>
                                <div class="row g-0 mb-2">
                                    <div class="col-auto me-2">
                                        <i class="fas fa-info"></i>
                                    </div>
                                    <div class="col">Sample Data</div>
                                </div>
                                <div class="row g-0 mb-2">
                                    <div class="col-auto me-2">
                                        <i class="fas fa-info"></i>
                                    </div>
                                    <div class="col">Sample Data</div>
                                </div>

                            </div>


                        </div>

                        
                    </div>
                </div>
                <div class="col-md-8 col-lg-9">
                    <h6>Enrolls</h6>
                    <div class="card border-0 rounded-0 shadow mb-4">
                        <div class="card-body d-flex flex-wrap gap-3">

                            @foreach ($enrolls as $enroll)

                            <div class="border shadow p-3 mb-3 enrollboxes">
                                <a href="javascript:void(0);">{{$enroll->post['title']}}</a>
                                <div class="text-muted">{{$enroll->stage['name']}}</div>
                                <div class="text-muted">{{date('d M Y'), strtotime($enroll->created_at)}} | {{date('h:i:s A'), strtotime($enroll->created_at)}}</div>
                                <div class="text-muted">{{$enroll->updated_at->format('d M Y | h:i:s A')}}</div>
                                {{-- <div class="mt-1" title="{{$enroll->remark}}">{{Str::limit($enroll->remark,20)}}</div> --}}
                                {{-- <div class="mt-1" title="{{$enroll->remark}}">{{Str::limit($enroll->remark,20,'...')}}</div> --}}
                                {{-- <div class="mt-1" title="{{$enroll->remark}}">{{Str::of($enroll->remark)->limit(20)}}</div> --}}
                                {{-- <div class="mt-1" title="{{$enroll->remark}}">{{Str::of($enroll->remark)->words(4)}}</div> --}}
                                {{-- <div class="mt-1" title="{{$enroll->remark}}">{{Str::of($enroll->remark)->words(4,'---')}}</div> --}}
                                {{-- <div class="mt-1" title="{{$enroll->remark}}">{{Str::words($enroll->remark,4)}}</div> --}}
                                <div class="mt-1" title="{{$enroll->remark}}">{{Str::words($enroll->remark,4,'---')}}</div>
                            </div>
                                
                            @endforeach
                           
                        </div>
                    </div>

                    <h6>Additional Info</h6>
                    <div class="card border-0 rounded-0 shadow mb-4">
                        <ul class="nav">
                            <li class="nav-item">
                                <button type="button" id="autoclick" class="tablinks" onclick="gettab(event,'follower')">Follower</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="tablinks" onclick="gettab(event,'following')">Following</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="tablinks" onclick="gettab(event,'liked')">Liked</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="tablinks" onclick="gettab(event,'remark')">Remark</button>
                            </li>
                        </ul>
                
                        <div class="tab-content">
                
                            <div id="follower" class="tab-pane">
                                <h3>This is Home information.</h3>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            </div>
                
                            <div id="following" class="tab-pane">
                                <h3>This is Profile information.</h3>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            </div>
                
                            <div id="liked" class="tab-pane">
                                <h3>This is Contact information.</h3>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            </div>
                
                            <div id="remark" class="tab-pane">
                                
                                <p>{{$student->remark}}</p>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>
    {{-- End Page Content  --}}
@endsection

@section('css')
<style type="text/css">
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
    const getbtnback = document.getElementById('btn-back');
    getbtnback.addEventListener('click',function(){
        // window.history.back();
        window.history.go(-1);
    });
// End Back Btn 

// Start Tab Box 

var gettablinks = document.getElementsByClassName('tablinks'); //HTML Collection
var gettabpanes = document.getElementsByClassName('tab-pane');

var tabpanes = Array.from(gettabpanes);

function gettab(evn,linkid){

	// console.log(evn.target);
	// console.log(linkid);

	tabpanes.forEach(function(tabpane){
		tabpane.style.display = "none";
	});

	for(var x=0; x < gettablinks.length; x++){
		gettablinks[x].className = gettablinks[x].className.replace(" active","");
	}

	document.getElementById(linkid).style.display = "block";

	// evn.target.className += " active";
	// evn.target.className = evn.target.className.replace("tablinks","tablinks active");
	// evn.target.classList.add('active');

	// console.log(evn);
	// console.log(evn.target);
	// console.log(evn.currentTarget);
	evn.currentTarget.className += " active";
}

document.getElementById('autoclick').click();

// End Tab Box 



</script>

@endsection

<!--End Content Area-->
