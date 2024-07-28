@php
    $id = Auth::user()->id;
    $adminData = App\Models\User::find($id);

@endphp
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!-- User details -->
        <div class="user-profile text-center mt-3">
            <div class="">
                <img src="{{ !empty($adminData->profile_image) ? url('uploads/admin_images/' . $adminData->profile_image) : url('uploads/no_image.jpg') }}"
                    alt="" class="avatar-md rounded-circle">
            </div>
            <div class="mt-3">
                <h4 class="font-size-16 mb-1">{{ $adminData->username }}</h4>
                <span class="text-muted"><i class="ri-record-circle-line align-middle font-size-14 text-success"></i>
                    Online</span>
            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="#" class="waves-effect">
                        <i class="ri-dashboard-line"></i><span class="badge rounded-pill bg-success float-end">3</span>
                        <span>Home Hero</span>
                    </a>

                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('home.slide')}}">Home Slide</a></li>
                    </ul>

                </li>

                <li>
                    <a href="#" class="waves-effect">
                        <i class="ri-dashboard-line"></i><span class="badge rounded-pill bg-success float-end">3</span>
                        <span>About Page SetUp</span>
                    </a>

                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('about.page')}}">About Page</a></li>
                        <li><a href="{{route('about.item')}}">Add About Items</a></li>
                        <li><a href="{{route('all.item')}}">All About Items</a></li>
                        
                    </ul>

                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Projects Section Setup</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('all.project.category')}}">All Project Categories</a></li>
                        <li><a href="{{route('add.project.category')}}">Add Project Categories</a></li>

                        <li><a href="{{route('all.projects')}}">All Projects</a></li>
                        <li><a href="{{route('add.project')}}">Add Projects</a></li>
                    </ul>
                </li>


                
                

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Services Section Setup</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('all.service.category')}}">All Service Categories</a></li>
                        <li><a href="{{route('add.service.category')}}">Add Service Categories</a></li>

                        <li><a href="{{route('all.services')}}">All Services</a></li>
                        <li><a href="{{route('add.service')}}">Add Service</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Features Section Setup</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('all.features')}}">All Features</a></li>
                        <li><a href="{{route('add.feature')}}">Add Feature</a></li>
                    </ul>
                </li>

                
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Feedbacks Comments Section </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('get.feedbacks')}}">All Feedbacks</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{route('summary.page')}}" class=" waves-effect">
                        <i class="ri-calendar-2-line"></i>
                        <span>Summary Programs</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('section.page')}}" class=" waves-effect">
                        <i class="ri-calendar-2-line"></i>
                        <span>Section Setting</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('get.messages')}}" class=" waves-effect">
                        <i class="ri-calendar-2-line"></i>
                        <span>All Contact Messages</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Our Teams</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('all.members')}}">All Team Members</a></li>
                        <li><a href="{{route('add.member')}}">Add Team Member</a></li>
                    </ul>
                </li>

               

                <li class="menu-title">Settings</li>
                <li>
                    <a href="{{route('logos.index')}}" class=" waves-effect">
                        <i class="ri-calendar-2-line"></i>
                        <span>Logos</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Footer SetUp</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="#">Footer Help Links</a></li>
                        <li><a href="#">Footer Usefull Links</a></li>
                        <li><a href="#">Footer Information</a></li>
                        <li><a href="#">Footer Social Links</a></li>


                    </ul>
                </li>


                


            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
