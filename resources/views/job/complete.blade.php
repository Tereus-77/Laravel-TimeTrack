@extends('layouts.app')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ url('assets/css/plugins/switchery/switchery.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Complete a Job</h2>
    </div>
    <div class="col-lg-2">
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Complete a Job </h5>
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
                            <form role="form" action="{{ route('job.complete') }}" method="post">
                                @csrf
                                <input type="hidden" name="job" value="{{ $job->id }}">
                                <div class="form-group mt-3">
                                    <h2 class="d-inline">Work Cell : </h2>
                                    <h2 class="float-right">{{ $job->machine->workcell }}</h2>
                                </div>
                                <div class="form-group mt-3">
                                    <h2 class="d-inline">Part Number : </h2>
                                    <h2 class="float-right">{{ $job->part->partnumber }}</h2>
                                </div>
                                <div class="form-group mt-3">
                                    <h2 class="d-inline">Total Time for Job : </h2>
                                    <h2 class="float-right">{{ $total_time }}</h2>
                                </div>
                                <div class="form-group mt-3">
                                    <h2 class="d-inline">Secondary : </h2>
                                    <input type="checkbox" id="secondary" class="js-switch float-right" />
                                </div>
                                <div class="parts">
                                    <div class="form-group row mt-3">
                                        <h2 class="col-9 d-inline">How many good parts were made? </h2>
                                        <div class="col-3">
                                            <input type="number" id="good" name="good" placeholder="0" id="exampleInputEmail2" class="form-control float-right">
                                            @if($errors->has('good'))
                                                <p class="text-danger">{{ $errors->first('good') }}</p>
                                            @endif
                                    </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <h2 class="col-9  d-inline">How many scrap / bad parts? </h2>
                                        <div class="col-3">
                                            <input type="number" name="bad" placeholder="0" value="0" id="exampleInputEmail2" class="form-control float-right">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-5">
                                    <button class="btn btn-success btn-lg btn-rounded btn-block" type="submit"><h2> Mark Job Complete</h2></button>
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
<script src="{{ url('assets/js/plugins/switchery/switchery.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.chosen-select').chosen({width: "100%"});

        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, { color: '#1AB394' });

        var $secondary = false;
        $('#secondary').on('change', function (e) {
            $secondary = !$secondary;
            if ($secondary) {
                $('.parts').addClass('d-none');
                $('#good').val("0");
            } else {
                $('.parts').removeClass('d-none');
                $('#good').val("");
            }
        });
    })
</script>

@endpush