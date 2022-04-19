@extends('layouts.app')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ url('assets/css/plugins/iCheck/custom.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Edit Part</h2>
    </div>
    <div class="col-lg-2">
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Edit Part </h5>
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
                            <form role="form" action="{{ route('part.update', ['id' => $data->id]) }}" method="post">
                                @method('PUT')
                                @csrf
                                <div class="form-group row mt-3">
                                    <h2 class="col-6 d-inline">Part Number </h2>
                                    <div class="col-6">
                                        <input type="number" name="partnumber" value="{{ $data->partnumber }}" id="exampleInputEmail2" class="form-control float-right">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <h2 class="col-6 d-inline">Description </h2>
                                    <div class="col-6">
                                        <Textarea style="width: 100%; border-color: #e7eaec;" name="description" rows="2">
                                        {{ $data->description }}
                                        </Textarea>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <h2 class="col-6 d-inline">Inactive </h2>
                                    <div class="col-6">
                                        <input type="checkbox" name="inactive" {{ $data->inactive == 'Yes' ? 'checked' : '' }} class="i-checks">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-custom btn-sm" type="submit">Save</button>
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
<script>
    $(document).ready(function(){
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    })
</script>

@endpush