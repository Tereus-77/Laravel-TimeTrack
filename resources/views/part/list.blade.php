@extends('layouts.app')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ url('assets/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
<link href="{{ url('assets/css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Part List</h2>
    </div>
    <div class="col-lg-2">
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Part List </h5>                    
                    <div class="ibox-tools">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <span class="btn btn-sm btn-success btn-file">
                                <span class="fileinput-new">Import Part #</span>
                                <span class="fileinput-exists">Change</span>
                                <input type="file" name="file" id="file">
                            </span>
                            <span class="fileinput-filename"></span>
                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                        </div>

                        <a href="{{ route('part.create') }}" class="btn btn-custom btn-sm"><i class="fa fa-plus"></i> Add Part</a>
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
                                    <th>Part Number</th>
                                    <th>Description</th>
                                    <th>Inactive</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                                <tr class="gradeX">
                                    <td class="d-none"></td>
                                    <td>{{ $data->partnumber }}</td>
                                    <td>{{ $data->description }}</td>
                                    <td>{{ $data->inactive }}</td>
                                    <td>
                                        <a class="btn btn-custom btn-sm" href="{{ route('part.edit', ['id' => $data->id]) }}"><i class="fa fa-edit"></i> Edit</a>
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
    var url_upload = '{{ route("part.upload") }}'
</script>
<script src="{{ url('assets/js/custom/partlist.js') }}"></script>

@endpush