@extends('layouts.app')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ url('assets/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
<link href="{{ url('assets/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>All Processing Jobs</h2>
    </div>
    <div class="col-lg-2">
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>All Processing Jobs</h5>                    
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
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th>Job Info</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobs as $job)
                                <tr class="gradeX">
                                    <td>{{ $job->user->username }}</td>
                                    <td>
                                        {{ date('Y:m:d', strtotime($job->started_date)) }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        {{ $job->machine->machinename }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                        {{ $job->part->partnumber }}
                                    </td>
                                    <td>
                                        @if ($job->active == 'Yes')
                                            <button class="btn btn-warning btn-sm pause" data-value="{{ $job->id }}"><i class="fa fa-pause"></i> Pause</button>
                                        @endif
                                        <button class="btn btn-success btn-sm complete" data-value="{{ $job->id }}"><i class="fa fa-check-square-o"></i> Complete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script src="{{ url('assets/js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ url('assets/js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script>
    var url_del = '{{ route("user.delete") }}';
</script>
<script src="{{ url('assets/js/custom/ulist.js') }}"></script>
<script>
    var url_update = '{{ route("job.update") }}';
    var url_complete = "{{ route('job.complete') }}";
</script>
<script src="{{ url('assets/js/custom/pc.js') }}"></script>

@endpush