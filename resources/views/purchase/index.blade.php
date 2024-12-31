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
                        <div class="card-header">
                            <button class="btn btn-primary xs" onclick="addPurchase('{{ route('purchase.store') }}')">
                                <i class="fas fa-plus"></i> Add
                            </button>
                            @empty(!session('purchase_id'))
                                <a href="{{ route('purchase_detail.index') }}" class="btn btn-info xs">
                                    <i class="fas fa-info"></i> Active Transaction
                                </a>
                            @endempty
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <table id="purchase_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Supplier</th>
                                        <th>Total Item</th>
                                        <th>Total Price (Rp)</th>
                                        <th>Dicount</th>
                                        <th>Pay (Rp)</th>
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

    @includeIf('purchase.supplier')
    @includeIf('purchase.detail')
@endsection

@push('scripts')
    <script>
        let purchase_table;

        $(function() {
            purchase_table = $("#purchase_table")
                .DataTable({
                    responsive: true,
                    lengthChange: false,
                    autoWidth: false,
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: "{{ route('purchase.data') }}",
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
                            data: "supplier"
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
                            data: "pay"
                        },
                        {
                            data: "action",
                            searchable: false,
                            sortable: false
                        }
                    ]
                });
        });

        // Function: Add Purchase
        function addPurchase() {
            $("#modalSupplier").modal("show");
        }

        // Function: Show Purchase
        function showPurchase(url) {
            $("#modalDetail").modal("show");

            purchase_detail_table.ajax.url(url);
            purchase_detail_table.ajax.reload();
        }

        // Function: Delete Purchase
        function deletePurchase(url) {
            if (confirm("Are you sure delete this purchase?")) {
                // Delete Data
                $.post(url, {
                        "_token": $("[name=csrf-token]").attr("content"),
                        "_method": "DELETE"
                    })
                    .done(response => {
                        // Success
                        purchase_table.ajax.reload();
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
