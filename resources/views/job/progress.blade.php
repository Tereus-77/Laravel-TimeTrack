@extends('layouts.app')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- <link href="http://webapplayers.com/inspinia_admin-v2.9.4/css/plugins/select2/select2.min.css" rel="stylesheet">
<link href="http://webapplayers.com/inspinia_admin-v2.9.4/css/plugins/select2/select2-bootstrap4.min.css" rel="stylesheet"> -->
<link href="{{ url('assets/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('assets/css/plugins/select2/select2-bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Select a Job</h2>
    </div>
    <div class="col-lg-2">
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Select a Job </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="form-group row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div class="form-group mt-3">
                                <select class="select2_demo_1 form-control" id="select">
                                <!-- <select id="select" data-placeholder="Select a Job In Progress..." class="chosen-select"  tabindex="2"> -->
                                    <option value="">-- Select a Job In Progress --</option>
                                    @foreach($jobs as $job)
                                        <option value="{{ $job->id }}" @if($job->active == 'Yes') selected @endif >
                                            {{ $job->user->username }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ date('Y:m:d', strtotime($job->started_date)) }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ $job->machine->machinename }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                            {{ $job->part->partnumber }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mt-3" style="border-bottom-width: 2px; border-bottom-style: solid; border-bottom-color:#e7eaec; padding: 5px;">
                                <h1 class="d-inline">Total Time : </h1>
                                <h1 class="float-right" id="total_time">{{ $total_time }}</h1>
                            </div>
                            <div class="form-group mt-3" >
                                <a class="btn btn-custom btn-lg btn-rounded btn-block" href="{{ route('job.start') }}"><h2> Start Job</h2></a>
                            </div>
                            <div class="@if(count($jobs) <= 0) d-none @endif">
                                <div class="form-group mt-3 @if(count($active_job) <= 0) d-none @endif">
                                    <button class="btn btn-warning btn-lg btn-rounded btn-block" href="#"><h2> Pause Job</h2></button>
                                </div>
                                <div class="form-group mt-3 d-none">
                                    <button class="btn btn-info btn-lg btn-rounded btn-block" href="#"><h2> Continue Job</h2></button>
                                </div>
                                <div class="form-group mt-3 @if(count($active_job) <= 0) d-none @endif">
                                    <button id="complete_job" class="btn btn-success btn-lg btn-rounded btn-block"><h2> Complete Job</h2></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" id="modal" class="btn btn-custom d-none" data-toggle="modal" data-target="#myModal4">
                    Basic fadeIn effect
                </button>
                <div class="modal inmodal" id="myModal4" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content animated fadeIn">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h5 class="modal-title">Would you like to change your password?</h5>
                            </div>
                            <div class="modal-body">
                                <p class="text-danger d-none text-center" id="modal_psw">Invalid Password</p>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" id="password" placeholder="Enter password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" id="password_confirmation" placeholder="Enter confirm_password" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="cancel_btn" class="btn btn-white" data-dismiss="modal">Cancel</button>
                                <button type="button" id="save_btn" class="btn btn-custom">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ url('assets/js/plugins/select2/select2.full.min.js') }}"></script>
<!-- <script src="http://webapplayers.com/inspinia_admin-v2.9.4/js/plugins/select2/select2.full.min.js"></script> -->
<script>
    var url_update = '{{ route("job.update") }}';
    var url_user = '{{ route("user.visit", ["id" => Auth::user()->id]) }}';
    var url_userown = '{{ route("user.updateown", ["id" => Auth::user()->id]) }}';
    var first_visit = '{{ Auth::user()->first_visit }}';
    var cnt_active = '{{ count($active_job) }}';
    var url_complete = "{{ route('job.complete') }}";

</script>
<script src="{{ url('assets/js/custom/jp.js') }}"></script>

@endpush