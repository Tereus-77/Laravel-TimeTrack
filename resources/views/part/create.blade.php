@extends('layouts.app')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ url('assets/css/plugins/iCheck/custom.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Add Part</h2>
    </div>
    <div class="col-lg-2">
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Add Part </h5>
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
                            <form role="form" action="{{ route('part.create') }}" method="post">
                                @csrf
                                <div class="form-group row mt-3">
                                    <h2 class="col-6 d-inline">Part Number </h2>
                                    <div class="col-6">
                                        <input type="number" id="partnumber" name="partnumber" autocomplete="off" placeholder="Enter Part Number" id="exampleInputEmail2" class="form-control float-right">
                                        @if($errors->has('partnumber'))
                                            <p class="text-danger">{{ $errors->first('partnumber') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <h2 class="col-6 d-inline">Description </h2>
                                    <div class="col-6">
                                        <Textarea style="width: 100%; border-color: #e7eaec;" id="desc" name="description" rows="2">
                                        </Textarea>
                                        @if($errors->has('description'))
                                            <p class="text-danger">{{ $errors->first('description') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <h2 class="col-6 d-inline">Inactive </h2>
                                    <div class="col-6">
                                        <input type="checkbox" name="inactive" class="i-checks">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-custom btn-sm" type="submit">Create</button>
                                        <a class="btn btn-white btn-sm" href="{{ route('part.list') }}">Cancel</a>
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
<script src="{{ url('assets/js/custom/pacr.js') }}"></script>

@endpush