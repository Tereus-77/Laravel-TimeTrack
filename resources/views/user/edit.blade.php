@extends('layouts.app')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ url('assets/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('assets/css/plugins/select2/select2-bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>User Edit</h2>
    </div>
    <div class="col-lg-2">
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>User Edit </h5>
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
                            <form role="form" action="{{ route('user.update', ['id' => $user->id]) }}" method="post">
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" name="name" placeholder="Enter fullname" class="form-control" value="{{ $user->name }}">
                                    @if($errors->has('name'))
                                        <p class="text-danger">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>User Name</label>
                                    <input type="text" name="username" placeholder="Enter Username" class="form-control" value="{{ $user->username }}">
                                    @if($errors->has('username'))
                                        <p class="text-danger">{{ $errors->first('username') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="select2_demo_1 form-control" id="select" name="role">
                                    <!-- <select data-placeholder="Select Role..." class="chosen-select"  tabindex="2" name="role"> -->
                                        <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="Employee" {{ $user->role == 'Employee' ? 'selected' : '' }}>Employee</option>
                                    </select>
                                    @if($errors->has('role'))
                                        <p class="text-danger">{{ $errors->first('role') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" placeholder="Enter password" class="form-control">
                                    @if($errors->has('password'))
                                        <p class="text-danger">{{ $errors->first('password') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" name="password_confirmation" placeholder="Enter confirm_password" class="form-control">
                                    @if($errors->has('password_confirmation'))
                                        <p class="text-danger">{{ $errors->first('password_confirmation') }}</p>
                                    @endif
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-lg-12">
                                        <a class="btn btn-sm btn-default float-right m-t-n-xs" href="{{ route('user.list') }}"><strong>Cancel</strong></a>
                                        <button class="btn btn-sm btn-custom float-right m-t-n-xs mr-3" type="submit"><strong>Save</strong></button>
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
<script src="{{ url('assets/js/plugins/select2/select2.full.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.chosen-select').chosen({width: "100%"});
        $(".select2_demo_1").select2({
            theme: 'bootstrap4',
        });
    })
</script>

@endpush