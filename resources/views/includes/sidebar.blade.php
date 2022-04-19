<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="text-center">                    
                    <img alt="image" style="width:100%; padding: 10px;" src="{{ url('assets/img/logo2.png') }}"/>
                </div>
                <div class="dropdown profile-element mt-4">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">{{ Auth::user()->name }}</span>
                        <span class="text-muted text-xs block">{{ Auth::user()->role }} <b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <!-- <li><a class="dropdown-item" href="profile.html">Profile</a></li> -->
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </div>
                <!-- <div class="logo-element">
                    Track
                </div> -->
            </li>
            @if(Auth::user()->role == 'Admin')
                <li @if($active_main == 'user') class="active" @endif>
                    <a href="#"><i class="fa fa-user"></i> <span class="nav-label">User Management</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li @if($active_sub == 'user_create') class="active" @endif><a href="{{ route('user.create') }}">Add User</a></li>
                        <li @if($active_sub == 'user_list') class="active" @endif><a href="{{ route('user.list') }}">User List</a></li>
                    </ul>
                </li>                
                <li @if($active_main == 'machine') class="active" @endif>
                    <a href="{{ route('machine.list') }}"><i class="fa fa-flask"></i> <span class="nav-label">Machine</span></a>
                </li>
                <li @if($active_main == 'part') class="active" @endif>
                    <a href="{{ route('part.list') }}"><i class="fa fa-sitemap"></i> <span class="nav-label">Part</span> </a>
                </li>
            @endif
            <li @if($active_main == 'job') class="active" @endif>
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Job</span> </a>
                <ul class="nav nav-second-level">
                    <li @if($active_sub == 'job_progress') class="active" @endif><a href="{{ route('job.progress') }}">Job progress</a></li>
                    @if(Auth::user()->role == 'Admin')
                        <li @if($active_sub == 'job_process') class="active" @endif><a href="{{ route('job.process') }}">All Process Jobs</a></li>
                    @endif
                </ul>
            </li>
            <li @if($active_main == 'report') class="active" @endif>
                <a href="#"><i class="fa fa-files-o"></i> <span class="nav-label">Report</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li @if($active_sub == 'report_employee') class="active" @endif><a href="{{ route('report.employee') }}">Employee Production Report</a></li>
                    <li @if($active_sub == 'report_partnumber') class="active" @endif><a href="{{ route('report.partnumber') }}">Production Report</a></li>
                    <li @if($active_sub == 'report_timesheet') class="active" @endif><a href="{{ route('report.timesheet') }}">Timesheet Report</a></li>
                </ul>
            </li>
        </ul>

    </div>
</nav>