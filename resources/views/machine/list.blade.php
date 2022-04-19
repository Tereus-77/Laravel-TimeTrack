@extends('layouts.app')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ url('assets/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Machine List</h2>
    </div>
    <div class="col-lg-2">
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Machine List </h5>                    
                    <div class="ibox-tools">                        
                        <a class="btn btn-custom btn-sm" href="{{ route('machine.create') }}"><i class="fa fa-plus"></i> Add Machine</a>
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
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th class="d-none"></th>
                                    <th>Machine Name</th>
                                    <th>Work Cell</th>
                                    <th>Inactive</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                                <tr class="gradeX">
                                    <td class="d-none"></td>
                                    <td>{{ $data->machinename }}</td>
                                    <td>{{ $data->workcell }}</td>
                                    <td>{{ $data->inactive }}</td>
                                    <td>
                                        <a class="btn btn-custom btn-sm" href="{{ route('machine.edit', ['id' => $data->id]) }}"><i class="fa fa-edit"></i> Edit</a>
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
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lfgitp',
            buttons: [
                
            ]

        });

    });

</script>

@endpush