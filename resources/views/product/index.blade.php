@extends('layouts.master')

@section('title')
    <h3 class="mb-0">List Product</h3>
@endsection

@section('breadcumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">Product</li>
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
                            <button class="btn btn-primary xs" onclick="addProduct('{{ route('product.store') }}')">
                                <i class="nav-icon fas fa-plus"></i> Add
                            </button>
                            <button class="btn btn-danger xs"
                                onclick="deleteProductSelected('{{ route('product.deleteSelected') }}')">
                                <i class="nav-icon fas fa-trash"></i> Delete
                            </button>
                            <button class="btn btn-info xs" onclick="printBarcode('{{ route('product.printBarcode') }}')">
                                <i class="nav-icon fas fa-barcode"></i> Print Barcode
                            </button>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <form class="product_form" method="post">
                                @csrf
                                <table id="product_table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" name="select_all_product" id="select_all_product">
                                            </th>
                                            <th>#</th>
                                            <th>Product Code</th>
                                            <th>Product Name</th>
                                            <th>Category</th>
                                            <th>Brand</th>
                                            <th>Purchase Price (Rp)</th>
                                            <th>Sell Price (Rp)</th>
                                            <th>Discount</th>
                                            <th>Stock</th>
                                            <th>
                                                <i class="nav-icon fas fa-cog"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </form>
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

    @includeIf('product.form')
@endsection

@push('scripts')
    <script>
        let product_table;

        $(function() {
            product_table = $("#product_table")
                .DataTable({
                    responsive: true,
                    lengthChange: false,
                    autoWidth: false,
                    processing: true,
                    ajax: {
                        url: "{{ route('product.data') }}",
                    },
                    columns: [{
                            data: "select_all_product"
                        },
                        {
                            data: "DT_RowIndex",
                            searchable: false,
                            sortable: false
                        },
                        {
                            data: "code"
                        },
                        {
                            data: "name"
                        },
                        {
                            data: "category"
                        },
                        {
                            data: "brand"
                        },
                        {
                            data: "price"
                        },
                        {
                            data: "sell_price"
                        },
                        {
                            data: "discount"
                        },
                        {
                            data: "stock"
                        },
                        {
                            data: "action",
                            searchable: false,
                            sortable: false
                        },
                    ]
                });

            // Validator
            $("#modalForm").validator().on("submit", function(e) {
                if (!e.preventDefault()) {
                    $.post($("#modalForm form").attr("action"), $("#modalForm form").serialize())
                        .done((response) => {
                            // Success
                            $("#modalForm").modal("hide");

                            product_table.ajax.reload();
                        })
                        .fail((errors) => {
                            // Failed
                            alert("Failed to save data!");

                            return;
                        });
                }
            });

            // Select All Product
            $("[name=select_all_product]").on("click", function() {
                $(":checkbox").prop("checked", this.checked);
            });
        });

        // Function: Add Product
        function addProduct(url) {
            $("#modalForm").modal("show");
            $("#modalForm .modal-title").text("Add Product");

            $("#modalForm form")[0].reset();
            $("#modalForm form").attr("action", url);
            $("#modalForm [name=_method]").val("POST");
        }

        // Function: Edit Product
        function editProduct(url) {
            $("#modalForm").modal("show");
            $("#modalForm .modal-title").text("Edit Product");

            $("#modalForm form")[0].reset();
            $("#modalForm form").attr("action", url);
            $("#modalForm [name=_method]").val("PUT");

            // Get Data
            $.get(url)
                .done((response) => {
                    // Success
                    $("#modalForm [name=name]").val(response.name);
                    $("#modalForm [name=category_id]").val(response.category_id);
                    $("#modalForm [name=brand]").val(response.brand);
                    $("#modalForm [name=price]").val(response.price);
                    $("#modalForm [name=sell_price]").val(response.sell_price);
                    $("#modalForm [name=discount]").val(response.discount);
                    $("#modalForm [name=stock]").val(response.stock);
                })
                .fail((errors) => {
                    // Failed
                    alert("Failed to display data!");

                    return;
                });
        }

        // Function: Delete Product
        function deleteProduct(url) {
            if (confirm("Are you sure delete this Product?")) {
                // Delete Data
                $.post(url, {
                        "_token": $("[name=csrf-token]").attr("content"),
                        "_method": "DELETE"
                    })
                    .done((response) => {
                        // Success
                        product_table.ajax.reload();
                    })
                    .fail((errors) => {
                        // Failed
                        alert("Failed to delete data!");

                        return;
                    });
            }
        }

        // Function: Delete Product Selected
        function deleteProductSelected(url) {
            total_selected = $("input:checked").length;

            if (total_selected) {
                if (confirm("Are you sure to delete the selected data?")) {
                    $.post(url, $(".product_form").serialize())
                        .done((response) => {
                            // Success
                            product_table.ajax.reload();
                        })
                        .fail((errors) => {
                            // Failed
                            alert("Failed to delete selected data!");

                            return;
                        });
                }
            } else {
                alert("Choose data that will be deleted!");
                return;
            }
        }

        // Function: Print Barcode
        function printBarcode(url) {
            total_selected = $("input:checked").length;

            if (total_selected < 1) {
                alert("Choose data that will be printed!");
                return;
            } else if (total_selected < 3) {
                alert("Choose min. 3 data to printed!");
                return;
            } else {
                $(".product_form")
                    .attr("action", url)
                    .attr("target", "_blank")
                    .submit();
            }
        }
    </script>
@endpush
