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
                            <button class="btn btn-primary xs" onclick="addCategory('{{ route('category.store') }}')">
                                <i class="fas fa-plus"></i> Add
                            </button>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <table id="category_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category</th>
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

    @includeIf('category.form')
@endsection

@push('scripts')
    <script>
        let category_table;

        $(function() {
            $("body").addClass("sidebar-collapse");

            category_table = $("#category_table")
                .DataTable({
                    responsive: true,
                    lengthChange: false,
                    autoWidth: false,
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: "{{ route('category.data') }}",
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

                            category_table.ajax.reload();
                        })
                        .fail((errors) => {
                            // Failed
                            alert("Failed to save data!");

                            return;
                        });
                }
            });
        });

        // Function: Add Category
        function addCategory(url) {
            $("#modalForm").modal("show");
            $("#modalForm .modal-title").text("Add Category");

            $("#modalForm form")[0].reset();
            $("#modalForm form").attr("action", url);
            $("#modalForm [name=_method]").val("POST");
        }

        // Function: Edit Category
        function editCategory(url) {
            $("#modalForm").modal("show");
            $("#modalForm .modal-title").text("Edit Category");

            $("#modalForm form")[0].reset();
            $("#modalForm form").attr("action", url);
            $("#modalForm [name=_method]").val("PUT");

            // Get Data
            $.get(url)
                .done(response => {
                    // Success
                    $("#modalForm [name=name]").val(response.name);
                })
                .fail(errors => {
                    // Failed
                    alert("Failed to display data!");

                    return;
                });
        }

        // Function: Delete Category
        function deleteCategory(url) {
            if (confirm("Are you sure delete this category?")) {
                // Delete Data
                $.post(url, {
                        "_token": $("[name=csrf-token]").attr("content"),
                        "_method": "DELETE"
                    })
                    .done(response => {
                        // Success
                        category_table.ajax.reload();
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
