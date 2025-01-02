@extends('layouts.master')

@section('title')
    <h3>{{ $menu }}</h3>
    <h4 class="mb-0">{{ indonesia_date($first_date, false) }} - {{ indonesia_date($last_date, false) }}</h4>
@endsection

@push('css_detail')
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/daterangepicker/daterangepicker.css') }}" />
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" />
@endpush

@section('breadcumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">{{ $menu }}</li>
@endsection

@section('content')
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <button class="btn btn-info xs" onclick="updatePeriod()">
                                <i class="fas fa-calendar"></i> Change Period
                            </button>
                            <a href="{{ route('report.exportPdf', [$first_date, $last_date]) }}" target="_blank"
                                class="btn btn-danger xs">
                                <i class="fas fa-file-pdf"></i> Export PDF
                            </a>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <table id="report_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Sale (Rp)</th>
                                        <th>Purchase (Rp)</th>
                                        <th>Expense (Rp)</th>
                                        <th>Income (Rp)</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- ./card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row (main row) -->
        </div>
        <!--end::Container-->
    </div>

    @includeIf('report.form')
@endsection

@push('scripts')
    <!-- date-range-picker -->
    <script src="{{ asset('admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <script>
        let report_table;

        $(function() {
            $("body").addClass("sidebar-collapse");

            report_table = $("#report_table")
                .DataTable({
                    responsive: true,
                    lengthChange: false,
                    autoWidth: false,
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: "{{ route('report.data', [$first_date, $last_date]) }}",
                    },
                    columns: [{
                            data: "DT_RowIndex",
                            searchable: false,
                            sortable: false
                        },
                        {
                            data: "date"
                        },
                        {
                            data: "sale"
                        },
                        {
                            data: "purchase"
                        },
                        {
                            data: "expense"
                        },
                        {
                            data: "income"
                        }
                    ],
                    dom: "Brt",
                    bSort: false,
                    bPaginate: false,
                });

            // Date picker (First Date)
            $("#first_date").datetimepicker({
                format: 'MM/DD/YYYY'
            });

            // Date picker (Last Date)
            $("#last_date").datetimepicker({
                format: 'MM/DD/YYYY'
            });
        });

        // Function: Update Period
        function updatePeriod() {
            $("#modalForm").modal("show");
        };
    </script>
@endpush
