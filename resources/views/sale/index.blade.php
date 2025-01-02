@extends('layouts.master')

@section('title')
    <h3 class="mb-0">List {{ $menu }}</h3>
@endsection

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
                        <div class="card-body">
                            <table id="sale_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Member Code</th>
                                        <th>Total Item</th>
                                        <th>Total Price (Rp)</th>
                                        <th>Dicount (%)</th>
                                        <th>Total Pay (Rp)</th>
                                        <th>Cashier</th>
                                        <th>
                                            <i class="fas fa-cog"></i>
                                        </th>
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

    @includeIf('sale.detail')
@endsection

@push('scripts')
    <script>
        let sale_table;

        $(function() {
            $("body").addClass("sidebar-collapse");

            sale_table = $("#sale_table")
                .DataTable({
                    responsive: true,
                    lengthChange: false,
                    autoWidth: false,
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: "{{ route('sale.data') }}",
                    },
                    columns: [{
                            data: "DT_RowIndex",
                            searchable: false,
                            sortable: false
                        },
                        {
                            data: "created_at"
                        },
                        {
                            data: "member_code"
                        },
                        {
                            data: "total_item"
                        },
                        {
                            data: "total_price"
                        },
                        {
                            data: "discount"
                        },
                        {
                            data: "total_pay"
                        },
                        {
                            data: "cashier"
                        },
                        {
                            data: "action",
                            searchable: false,
                            sortable: false
                        }
                    ]
                });
        });

        // Function: Add Sale
        function addSale() {
            $("#modalSupplier").modal("show");
        }

        // Function: Show  Detail
        function showSaleDetail(url) {
            $("#modalDetail").modal("show");

            sale_detail_table.ajax.url(url);
            sale_detail_table.ajax.reload();
        }

        // Function: Delete Sale
        function deleteSale(url) {
            if (confirm("Are you sure delete this sale?")) {
                // Delete Data
                $.post(url, {
                        "_token": $("[name=csrf-token]").attr("content"),
                        "_method": "DELETE"
                    })
                    .done(response => {
                        // Success
                        sale_table.ajax.reload();
                    })
                    .fail(errors => {
                        // Failed
                        alert("Failed to delete data!");

                        return;
                    });
            }
        }
    </script>
@endpush
