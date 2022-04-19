@extends('layouts.app')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ url('assets/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
<link href="{{ url('assets/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Timesheet Report</h2>
    </div>
    <div class="col-lg-2">
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Timesheet Report</h5>                    
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
                    <div class="row">
                        <div class="form-group col-lg-2 col-md-3 col-sm-4 col-xs-3" id="data_1">
                            <label class="font-normal">From Date</label>
                            <div class="input-group date">
                                <input id="from_date" autocomplete="off" type="text" class="form-control" value=""><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-3 col-sm-4 col-xs-3" id="data_1">
                            <label class="font-normal">To Date</label>
                            <div class="input-group date">
                                <input id="to_date" autocomplete="off" type="text" class="form-control" value=""><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-3 col-sm-4 col-xs-3">
                            <label class="font-normal">Employee</label>
                            <select id="employee" data-placeholder="Select Employee..." class="chosen-select"  tabindex="2">
                                <option value="">-- Select Employee --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th class="d-none">No</th>
                                    <th>Employee</th>
                                    <th>Date</th>
                                    <th>Part Number</th>
                                    <th>Qty Good</th>
                                    <th>Qty Bad</th>
                                    <th>Time to Complete</th>
                                    <th>Standard Hrs</th>
                                </tr>
                            </thead>
                            <tbody id="result">
                                @foreach($datas as $job)
                                <tr class="gradeX">
                                    <td class="d-none"></td>
                                    <td>{{ $job['user']['name'] }}</td>
                                    <td>{{ $job['updated_at'] ? date('Y/m/d', strtotime($job['updated_at'])) : '' }}</td>
                                    <td>{{ $job['part']['partnumber'] }}</td>
                                    <td>{{ $job['qty_good'] }}</td>
                                    <td>{{ $job['qty_bad'] }}</td>
                                    <td>{{ $job['time_to_complete'] }}</td>
                                    <td>{{ number_format($job['part_hr'], 3) }}</td>
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
<script src="{{ url('assets/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script>
    var url_timesheet = '{{ route("report.timesheet") }}';
</script>
<script src="{{ url('assets/js/custom/ti.js') }}"></script>

@endpush