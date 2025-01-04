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
                            <button class="btn btn-primary xs" onclick="addSupplier('{{ route('supplier.store') }}')">
                                <i class="fas fa-plus"></i> Add
                            </button>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <table id="supplier_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Address</th>
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

    @includeIf('supplier.form')
@endsection

@push('scripts')
    <script>
        let supplier_table;

        $(function() {
            $("body").addClass("sidebar-collapse");
            
            supplier_table = $("#supplier_table")
                .DataTable({
                    responsive: true,
                    lengthChange: false,
                    autoWidth: false,
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: "{{ route('supplier.data') }}",
                    },
                    columns: [{
                            data: "DT_RowIndex",
                            searchable: false,
                            sortable: false
                        },
                        {
                            data: "name"
                        },
                        {
                            data: "phone"
                        },
                        {
                            data: "address"
                        },
                        {
                            data: "action",
                            searchable: false,
                            sortable: false
                        }
                    ]
                });

            $("#modalForm").on("submit", function(e) {
                if (!e.preventDefault()) {
                    $.post($("#modalForm form").attr("action"), $("#modalForm form").serialize())
                        .done((response) => {
                            // Success
                            $("#modalForm").modal("hide");

                            supplier_table.ajax.reload();
                        })
                        .fail((errors) => {
                            // Failed
                            alert("Failed to save data!");

                            return;
                        });
                }
            });
        });

        // Function: Add Supplier
        function addSupplier(url) {
            $("#modalForm").modal("show");
            $("#modalForm .modal-title").text("Add Supplier");

            $("#modalForm form")[0].reset();
            $("#modalForm form").attr("action", url);
            $("#modalForm [name=_method]").val("POST");
        }

        // Function: Edit Supplier
        function editSupplier(url) {
            $("#modalForm").modal("show");
            $("#modalForm .modal-title").text("Edit Supplier");

            $("#modalForm form")[0].reset();
            $("#modalForm form").attr("action", url);
            $("#modalForm [name=_method]").val("PUT");

            // Get Data
            $.get(url)
                .done(response => {
                    // Success
                    $("#modalForm [name=name]").val(response.name);
                    $("#modalForm [name=phone]").val(response.phone);
                    $("#modalForm [name=address]").val(response.address);
                })
                .fail(errors => {
                    // Failed
                    alert("Failed to display data!");

                    return;
                });
        }

        // Function: Delete Supplier
        function deleteSupplier(url) {
            if (confirm("Are you sure delete this supplier?")) {
                // Delete Data
                $.post(url, {
                        "_token": $("[name=csrf-token]").attr("content"),
                        "_method": "DELETE"
                    })
                    .done(response => {
                        // Success
                        supplier_table.ajax.reload();
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
