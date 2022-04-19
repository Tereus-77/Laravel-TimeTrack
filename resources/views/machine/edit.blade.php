@extends('layouts.app')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ url('assets/css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ url('assets/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('assets/css/plugins/select2/select2-bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Edit Machine</h2>
    </div>
    <div class="col-lg-2">
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Edit Machine </h5>
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
                            <form role="form" action="{{ route('machine.update', ['id' => $data->id]) }}" method="post">                                
                                @method('PUT')
                                @csrf
                                <div class="form-group row mt-3">
                                    <h2 class="col-6 d-inline">Machine Name </h2>
                                    <div class="col-6">
                                        <input type="text" name="machinename" value="{{ $data->machinename }}" id="exampleInputEmail2" class="form-control float-right">
                                        @if($errors->has('machinename'))
                                            <p class="text-danger">{{ $errors->first('machinename') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <h2 class="col-6 d-inline">Work Cell </h2>
                                    <div class="col-6">
                                        <select class="select2_demo_1 form-control" name="workcell">
                                        <!-- <select data-placeholder="Select Work Cell" class="chosen-select" name="workcell" tabindex="2"> -->
                                            <option value="workcella" {{ $data->workcell == 'workcella' ? 'selected' : '' }}>Work Cell A</option>
                                            <option value="workcellb" {{ $data->workcell == 'workcellb' ? 'selected' : '' }}>Work Cell B</option>
                                            <option value="workcellc" {{ $data->workcell == 'workcellc' ? 'selected' : '' }}>Work Cell C</option>
                                        </select>
                                        @if($errors->has('workcell'))
                                            <p class="text-danger">{{ $errors->first('workcell') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <h2 class="col-6 d-inline">Inactive </h2>
                                    <div class="col-6">
                                        <input type="checkbox" {{ $data->inactive == 'Yes' ? 'checked' : '' }} name="inactive" class="i-checks">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-custom btn-sm" type="submit">Save</button>                                    
                                        <a class="btn btn-white btn-sm" href="{{ route('machine.list') }}">Cancel</a>
                                    </div>
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
<script src="{{ url('assets/js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ url('assets/js/plugins/select2/select2.full.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.chosen-select').chosen({width: "100%"});
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
        $(".select2_demo_1").select2({
            theme: 'bootstrap4',
        });
    })
</script>

@endpush