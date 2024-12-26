@extends('layouts.master')

@section('title')
    <h3 class="mb-0">Category</h3>
@endsection

@section('breadcumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">Category</li>
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
                                <i class="nav-icon fas fa-plus"></i> Add
                            </button>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hovered"
                                    id="category_table">
                                    <thead>
                                        <tr>
                                            <td>#</td>
                                            <td>Category</td>
                                            <td>
                                                <i class="nav-icon fas fa-cog"></i>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
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
            category_table = $("#category_table").DataTable({
                paging: true,
                lengthChange: false,
                searching: false,
                ordering: true,
                info: true,
                autoWidth: false,
                responsive: true,
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

            // Validator
            $("#modalForm").validator().on("submit", function(e) {
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
            $("#modalForm [name=name]").focus();
        }

        // Function: Edit Category
        function editCategory(url) {
            $("#modalForm").modal("show");
            $("#modalForm .modal-title").text("Edit Category");

            $("#modalForm form")[0].reset();
            $("#modalForm form").attr("action", url);
            $("#modalForm [name=_method]").val("PUT");
            $("#modalForm [name=name]").focus();

            // Get Data
            $.get(url)
                .done((response) => {
                    // Success
                    $("#modalForm [name=name]").val(response.name);
                })
                .fail((errors) => {
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
                    .done((response) => {
                        // Success
                        category_table.ajax.reload();
                    })
                    .fail((errors) => {
                        // Failed
                        alert("Failed to delete data!");

                        return;
                    });
            }
        }
    </script>
@endpush
