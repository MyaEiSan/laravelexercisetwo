@extends('layouts.adminindex')
@section('content')

    <!-- Start Page Content Area -->

    <div class="container-fluid">

   

        <div class="col-md-12">

            <a href="javascript:void(0);" id="btn-back" class="btn btn-secondary btn-sm rounded-0">Back</a>
            <a href="{{route('announcements.index')}}" class="btn btn-secondary btn-sm rounded-0">Close</a>

            <hr/>

            <div class="row">
                
            <div class="col-md-4 col-lg-3 mb-2">   
                <h6>Info</h6>
                <div class="card border-0 rounded-0 shadow">

                    <div class="card-body">

                        <div class="d-flex flex-column align-items-center mb-3">
                            <div class="h5 mb-1">{{$announcement->title}}</div>
                            <div class="text-muted">
                                <span>{{$announcement->post["title"]}}</span>
                            </div>
                            <img src="{{asset($announcement->image)}}" alt="{{$announcement->title}}" width="200" />
                        </div>   
                        
                        <div class="w-100 d-flex flex-row justify-content-between mb-3"> 
                            <a href="#createmodal" class="w-100 btn btn-primary btn-sm rounded-0 me-2" data-bs-toggle="modal">Enroll</a>
                            <button type="button" class="w-100 btn btn-outline-primary btn-sm rounded-0">Follow</button>
                        </div>

                        <div class="mb-5">

                            
                            <div class="row g-0 mb-2">
                                <div class="col-auto">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="col ps-3">
                                    <div class="row">
                                        <div class="col">
                                            <div>By</div>
                                        </div>
                                        <div class="col-auto">
                                            <div>{{$announcement['user']['name']}}</div>
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
                                            <div>{{date('d M Y',strtotime($announcement->created_at))}} | {{date('h:i:s A',strtotime($announcement->created_at))}}</div>
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
                                            <div>{{date('d M Y',strtotime($announcement->updated_at))}} | {{date('h:i:s A',strtotime($announcement->updated_at))}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

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

                <h6>Comments</h6>
                <div class="card border-0 rounded-0 shadow mb-4">
                    <div class="card-body d-flex flex-wrap gap-3">
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
                                                    <span class="small fw-bold float-end">{{$comment->user['name']}} | {{$comment->created_at->diffForHumans()}}</span>
                                                </div>
                                                
                                                
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="card-body border-top">
                                    <form action="{{route('comments.store')}}" method="POST">
                                        @csrf
        
                                        <div class="col-md-12 d-flex justify-between">
                                            <textarea name="description" id="description" class="form-control border-0 rounded-0" rows="1" style="resize:none;" placeholder="Comment here..." ></textarea>
                                            <button type="submit" class="btn btn-info btn-sm text-light ms-3"><i class="fas fa-paper-plane"></i></button>
                                        </div>
                                        
        
                                        <!-- Start Hidden Fields -->
                                        <input type="hidden" name="commentable_id" id="commentable_id" value="{{$announcement->id}}" />
                                        <input type="hidden" name="commentable_type" id="commentable_type" value="App\Models\Announcement" />
                                        <!-- End Hidden Fields -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <h6>Additional Info</h6>
                <div class="card border-0 rounded-0 shadow mb-4">
                        <ul class="nav"> 
                            <li class="nav-item">
                                <button type="button" id="autoclick" class="tablinks active" onclick="gettab(event,'content')">Follower</button>
                            </li>
                        </ul>
                
                        <div class="tab-content">
                
                            <div id="content" class="tab-panel">
                                <p>{!! $announcement->content !!}</p>
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

            <form action="{{route('enrolls.store')}}" method="POST" enctype="multipart/form-data">
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
                    <input type="hidden" name="announcement_id" value="{{$announcement->id}}" />
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

        /* start comment */
        .chat-boxs{
            height: 200px;
            overflow-y:scroll;
        }
        /* end comment */


        /* Start Tab Box */
        .nav{
                display: flex;

                padding: 0;
                margin: 0;
            }

            .nav .nav-item{
                list-style-type: none;
            }

            .nav .tablinks{
                border: none;
                outline: none;
                cursor: pointer;

                padding: 14px 16px;

                transition: background-color 0.3s;
            }

            .nav .tablinks:hover{
                background-color: #f3f3f3;
            }

            .nav .tablinks.active{
                color: blue;
            }


            .tab-panel{
                padding: 6px 12px;
                display: none;
            }

        /* End Tab Box */


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
    
    </script>
@endsection