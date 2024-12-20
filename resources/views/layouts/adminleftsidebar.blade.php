 <!--Start Left Navbar-->
   
 <div class="wrappers">
    <nav class="navbar navbar-expand-md navbar-light">
        <button type="button" class="navbar-toggler ms-auto mb-2" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="nav" class="navbar-collapse collapse">
            <div class="container-fluid">
                <div class="row">
                    <!-- Start Left Sidebar -->
                    <div class="col-lg-2 col-md-3 fixed-top vh-100 overflow-auto sidebars">
                        <ul class="navbar-nav flex-column mt-4">
                            <li class="nav-item nav-categories">Main</li>

                            <li class="nav-item"><a href="javascript:void(0);" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-tachometer-alt fa-md me-3"></i>Dashboard</a></li>

                            @if(auth()->user()->hasRoles(['Admin','Teacher','Student']))
                                <li class="nav-item"><a href="javascript:void(0);" class="nav-link text-white p-3 mb-2 sidebarlinks currents" data-bs-toggle="collapse" data-bs-target="#pagelayout"><i class="fas fa-cloud-download-alt fa-md me-3"></i> Download <i class="fas fa-angle-left mores"></i></a>
                                
                                    <ul id="pagelayout" class="collapse ps-2">
                                        <li><a href="{{route('edulinks.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Education</a></li>
                                        <li><a href="javascript:void(0);" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Software</a></li>
                                    </ul>

                                </li>

                                <li class="nav-item"><a href="javascript:void(0);" class="nav-link text-white p-3 mb-2 sidebarlinks" data-bs-toggle="collapse" data-bs-target="#sidebarlayout"><i class="fas fa-file-alt fa-md me-3"></i> Form <i class="fas fa-angle-left mores"></i></a>
                                
                                    <ul id="sidebarlayout" class="collapse ps-2">
                                        <li><a href="{{route('attendances.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Att Form</a></li>
                                        <li><a href="{{route('leaves.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Leave Form</a></li>
                                        <li><a href="{{route('enrolls.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i>Enroll</a></li>
                                    </ul>
        
                                </li>

                                <li class="nav-item"><a href="javascript:void(0);" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-file-alt fa-md me-3"></i>Widgets</a></li>

                            @endif

                            <li class="nav-item nav-categories">UI Features</li>

                            @if(auth()->user()->hasRoles(['Admin','Teacher']))
                                <li class="nav-item"><a href="javascript:void(0);" class="nav-link text-white p-3 mb-2 sidebarlinks" data-bs-toggle="collapse" data-bs-target="#basicui"><i class="fas fa-file-alt fa-md me-3"></i> Articles <i class="fas fa-angle-left mores"></i></a>
                                
                                    <ul id="basicui" class="collapse ps-2">
                                        <li><a href="{{route('posts.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Post</a></li>
                                        <li><a href="{{route('announcements.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Announcement</a></li>
                                    </ul>
        
                                </li>
                                <li class="nav-item"><a href="javascript:void(0);" class="nav-link text-white p-3 mb-2 sidebarlinks" data-bs-toggle="collapse" data-bs-target="#basicui"><i class="fas fa-file-alt fa-md me-3"></i> Leads <i class="fas fa-angle-left mores"></i></a>
                                
                                    <ul id="basicui" class="collapse ps-2">
                                        <li><a href="{{route('leads.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Lead</a></li>
                                        
                                    </ul>
        
                                </li>

                                <li class="nav-item"><a href="javascript:void(0);" class="nav-link text-white p-3 mb-2 sidebarlinks" data-bs-toggle="collapse" data-bs-target="#advanceui"><i class="fas fa-users-group fa-md me-3"></i>Students <i class="fas fa-angle-left mores"></i></a>
                                
                                    <ul id="advanceui" class="collapse ps-2">
                                        <li><a href="javascript:void(0);" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i>Clipboard</a></li>
                                        <li><a href="javascript:void(0);" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i>Sliders</a></li>
                                        <li><a href="javascript:void(0);" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i>Carousel</a></li>
                                        <li><a href="javascript:void(0);" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i>Loaders</a></li>
                                        <li><a href="javascript:void(0);" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i>Tree Views</a></li>
                                        
                                    </ul>
        
                                </li>
                                <li class="nav-item"><a href="{{route('attcodegenerators.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-file-alt fa-md me-3"></i>All Generator</a></li>
                                <li class="nav-item"><a href="{{route('students.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-file-alt fa-md me-3"></i>All Students</a></li>

                            @endif
                           
                            @if(auth()->user()->hasRoles(['Admin','Teacher','Student']))
                                <li class="nav-item"><a href="javascript:void(0);" class="nav-link text-white p-3 mb-2 sidebarlinks" data-bs-toggle="collapse" data-bs-target="#iconelement"><i class="fas fa-share-alt-square fa-md me-3"></i>Apps <i class="fas fa-angle-left mores"></i></a>
                                
                                    <ul id="iconelement" class="collapse ps-2">
                                        <li><a href="{{route('contacts.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i>Contacts</a></li>
                                        <li><a href="javascript:void(0);" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i>Todo</a></li>
                                        
                                        
                                    </ul>
        
                                </li>
                                
                                <li class="nav-item"><a href="{{route('pointtransfers.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-exchange-alt fa-md me-3"></i>Transfer</a></li>

                                <li class="nav-item"><a href="javascript:void(0);" class="nav-link text-white p-3 mb-2 sidebarlinks" data-bs-toggle="collapse" data-bs-target="#shopping"><i class="fas fa-shopping-cart fa-md me-3"></i>Shopping <i class="fas fa-angle-left mores"></i></a>
                                
                                    <ul id="shopping" class="collapse ps-2">
                                        <li><a href="{{route('plans.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i>Plans</a></li>
                                        <li><a href="javascript:void(0);" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i>Billing</a></li>
                                        <li><a href="javascript:void(0);" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i>Payment</a></li>
                                        
                                    </ul>
        
                                </li>

                            @endif

                           @if(auth()->user()->hasRoles(['Admin','Teacher']))
                                <li class="nav-item nav-categories">Data Representation</li>

                                <li class="nav-item"><a href="javascript:void(0);" class="nav-link text-white p-3 mb-2 sidebarlinks" data-bs-toggle="collapse" data-bs-target="#chartelement"><i class="fas fa-file-alt fa-md me-3"></i>Fixed Analysis <i class="fas fa-angle-left mores"></i></a>
                                
                                    <ul id="chartelement" class="collapse ps-2">
                                        <li><a href="{{route('countries.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Country</a></li>
                                        <li><a href="{{route('regions.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Region</a></li>
                                        <li><a href="{{route('cities.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> city</a></li>
                                        <li><a href="{{route('townships.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Township</a></li>
                                        <li><a href="{{route('days.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Days</a></li>
                                        <li><a href="{{route('categories.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Categories</a></li>
                                        <li><a href="{{route('stages.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Stages</a></li>
                                        <li><a href="{{route('genders.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Gender</a></li>
                                        <li><a href="{{route('userpoints.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Points</a></li>
                                        <li><a href="{{route('paymenttypes.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Payment Type</a></li>
                                        <li><a href="{{route('statuses.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Status</a></li>
                                        <li><a href="{{route('tags.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Tags</a></li>
                                        <li><a href="{{route('types.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Types</a></li>
                                        
                                    </ul>
        
                                </li>

                                <li class="nav-item"><a href="javascript:void(0);" class="nav-link text-white p-3 mb-2 sidebarlinks" data-bs-toggle="collapse" data-bs-target="#tableelement"><i class="fas fa-file-alt fa-md me-3"></i>Addon <i class="fas fa-angle-left mores"></i></a>
                                
                                    <ul id="tableelement" class="collapse ps-2">
                                        <li><a href="{{route('permissionroles.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Permission</a></li>
                                        <li><a href="{{route('paymentmethods.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Payment Method</a></li>
                                        <li><a href="{{route('relatives.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Relatives</a></li>
                                        <li><a href="{{route('roles.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Roles</a></li>
                                        <li><a href="{{route('permissions.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Permissions</a></li>
                                        <li><a href="{{route('socialapplications.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Social App</a></li>
                                        <li><a href="{{route('warehouses.index')}}" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i>Warehouses</a></li>
                                    </ul>
        
                                </li>
                            @endif

                            <li class="nav-item"><a href="javascript:void(0);" class="nav-link text-white p-3 mb-2 sidebarlinks" data-bs-toggle="collapse" data-bs-target="#mapelement"><i class="fas fa-file-alt fa-md me-3"></i>Maps <i class="fas fa-angle-left mores"></i></a>
                            
                                <ul id="mapelement" class="collapse ps-2">
                                    <li><a href="javascript:void(0);" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i>Google Map</a></li>
                                    <li><a href="javascript:void(0);" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i>Vector Map</a></li>
                                </ul>
    
                            </li>

                        </ul>
                    </div>
                    <!-- End Left Sidebar -->

                    <!-- Start Top Sidebar -->
                    @include('layouts.adminnavbar')
                    <!-- End Top Sidebar -->
                </div>
            </div>
        </div>
    </nav>
</div>


<!--End Left Navbar-->