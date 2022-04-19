@extends('layouts.app')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ url('assets/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('assets/css/plugins/select2/select2-bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Start a Job</h2>
    </div>
    <div class="col-lg-2">
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Start a Job </h5>
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
                            <form role="form" action="{{ route('job.create') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label><h4> What machine are you working at?</h4></label>
                                    <select class="select2_demo_1 form-control" name="machinename">
                                    <!-- <select data-placeholder="Select a Job In Progress..." class="chosen-select" name="machinename" tabindex="2"> -->
                                        <option value="">-- Select Machine --</option>
                                        @foreach($machines as $machine)
                                            <option value="{{ $machine->id }}">{{ $machine->machinename }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('machinename'))
                                        <p class="text-danger">{{ $errors->first('machinename') }}</p>
                                    @endif
                                </div>
                                <div class="form-group mt-5">
                                    <label><h4> What part are you making?</h4></label>
                                    <select class="select2_demo_1 form-control" name="partnumber">
                                    <!-- <select data-placeholder="Select a Job In Progress..." class="chosen-select" name="partnumber" tabindex="2"> -->
                                        <option value="">-- Select Part --</option>
                                        @foreach($parts as $part)
                                            <option value="{{ $part->id }}">{{ $part->partnumber }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $part->description }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('partnumber'))
                                        <p class="text-danger">{{ $errors->first('partnumber') }}</p>
                                    @endif
                                </div>
                                <div class="form-group mt-5">
                                    <button type="submit" class="btn btn-custom btn-lg btn-rounded btn-block"><h2> Start</h2></button>
                                </div>
                            </form>
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

<script>
    $(document).ready(function(){
        $('.chosen-select').chosen({width: "100%"});
        $(".select2_demo_1").select2({
            theme: 'bootstrap4',
        });
        $(".select2_demo_3").select2({
            theme: 'bootstrap4',
            placeholder: "Select a state",
            allowClear: true
        });
    })
</script>

@endpush