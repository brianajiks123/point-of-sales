@extends('layouts.master')

@section('title')
    <h3 class="mb-0">{{ $menu }}</h3>
@endsection

@push('css_purchase_detail')
    <style>
        .show_pay {
            font-size: 5em;
            text-align: center;
            height: 120px;
        }

        .show_text {
            padding: 15px;
            background: #fdf8f8;
        }

        .show_pay,
        .show_text {
            text-align: center;
        }

        #purchase_detail_table tbody tr:last-child {
            display: none;
        }

        @media(max-width: 768px) {
            .show_pay {
                font-size: 3em;
                height: 70px;
                padding-top: 5px;
            }
        }
    </style>
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
                            <table>
                                <tr>
                                    <td>Supplier</td>
                                    <td> : {{ $supplier->name }}</td>
                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <td> : {{ $supplier->phone }}</td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td> : {{ $supplier->address }}</td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <form class="product_form">
                                @csrf
                                <div class="form-group row">
                                    <label for="product_code" class="col-lg-2 col-form-label">Product Code</label>
                                    <div class="col-lg-5">
                                        <div class="input-group">
                                            <input type="hidden" name="purchase_id" id="purchase_id"
                                                value="{{ $purchase_id }}">
                                            <input type="hidden" name="product_id" id="product_id">
                                            <input type="text" name="code" id="product_code" class="form-control">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-flat"
                                                    onclick="showProduct()">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <table id="purchase_detail_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Code</th>
                                        <th>Product Name</th>
                                        <th>Price (Rp)</th>
                                        <th width="14%">Amount</th>
                                        <th>Sub Total (Rp)</th>
                                        <th>
                                            <i class="fas fa-cog"></i>
                                        </th>
                                    </tr>
                                </thead>
                            </table>

                            {{-- Total Price Preview --}}
                            <div class="row mt-3">
                                <div class="col-lg-9">
                                    <div class="show_pay bg-info"></div>
                                    <div class="show_text"></div>
                                </div>
                                <div class="col-lg">
                                    <form action="{{ route('purchase.store') }}" method="POST" class="purchase_form">
                                        @csrf
                                        <input type="hidden" name="purchase_id" value="{{ $purchase_id }}">
                                        <input type="hidden" name="total_purchase" id="total_purchase">
                                        <input type="hidden" name="total_amount_purchase" id="total_amount_purchase">
                                        <input type="hidden" name="pay" id="pay">

                                        <div class="form-group row">
                                            <label for="total_rp"class="col-lg-4 col-form-label">Total (Rp)</label>
                                            <div class="col-lg-5">
                                                <input type="text" id="total_rp" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="discount" class="col-lg-4 col-form-label">Discount (%)</label>
                                            <div class="col-lg-5">
                                                <input type="number" name="discount" id="discount" class="form-control"
                                                    value="0" min="0">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="pay_purchase" class="col-lg-4 col-form-label">Pay (Rp)</label>
                                            <div class="col-lg-5">
                                                <input type="text" id="pay_purchase" class="form-control">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-lg-9"></div>
                                <div class="col-lg">
                                    <button type="submit" class="btn btn-primary" id="btn_save">Save Transaction</button>
                                </div>
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

    @includeIf('purchase_detail.product')
@endsection

@push('scripts')
    <script>
        let purchase_detail_table;

        $(function() {
            purchase_detail_table = $("#purchase_detail_table")
                .DataTable({
                    responsive: true,
                    lengthChange: false,
                    autoWidth: false,
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: "{{ route('purchase_detail.data', $purchase_id) }}",
                    },
                    columns: [{
                            data: "DT_RowIndex",
                            searchable: false,
                            sortable: false
                        },
                        {
                            data: "product_code"
                        },
                        {
                            data: "product_name"
                        },
                        {
                            data: "price"
                        },
                        {
                            data: "amount"
                        },
                        {
                            data: "sub_total"
                        },
                        {
                            data: "action",
                            searchable: false,
                            sortable: false
                        }
                    ],
                    dom: "Brt",
                    bSort: false,
                })
                .on("draw.dt", function() {
                    loadTotalPayLabel($("#discount").val());
                });

            // Update Amount
            $(document).on("input", ".edit_amount", function() {
                let id = $(this).data("id");
                let amount = parseInt($(this).val(), 10);

                // Handle amount
                if (isNaN(amount) || amount < 1) {
                    $(this).val(1);
                    alert("The amount must be greater than 0");
                    return;
                }

                if (amount > 10000) {
                    $(this).val(10000);
                    alert("The amount cannot exceed 10.000");
                    return;
                }

                $.post(`{{ url('/purchase_detail') }}/${id}`, {
                        "_token": $("[name=csrf-token]").attr("content"),
                        "_method": "PUT",
                        "amount": amount
                    })
                    .done(response => {
                        purchase_detail_table.ajax.reload();
                    })
                    .fail(errors => {
                        alert("Failed to update amount!");
                        return;
                    });
            })

            // Update Discount
            $(document).on("input", "#discount", function() {
                if ($(this).val() == "") {
                    $(this).val(0).select();
                }

                loadTotalPayLabel($(this).val());
            });

            // Save Purchase Transaction
            $("#btn_save").on("click", function() {
                $(".purchase_form").submit();
            })
        });

        // Function: Show Product
        function showProduct() {
            $("#modalProduct").modal("show");
        }

        // Function: Hide Product
        function hideProduct() {
            $("#modalProduct").modal("hide");
        }

        // Function: Choose Product of Purchase Detail
        function chooseProduct(id, code) {
            $('#product_id').val(id);
            $('#product_code').val(code);

            hideProduct();

            addProduct();
        }

        // Function: Add Product of Purchase Detail
        function addProduct() {
            $.post("{{ route('purchase_detail.store') }}", $(".product_form").serialize())
                .done(response => {
                    $('#product_code').focus();

                    purchase_detail_table.ajax.reload();
                })
                .fail(errors => {
                    alert("Failed to save data!");
                    return;
                })
        }

        // Function: Delete Purchase Detail
        function deletePurchaseDetail(url) {
            if (confirm("Are you sure delete this purchase?")) {
                // Delete Data
                $.post(url, {
                        "_token": $("[name=csrf-token]").attr("content"),
                        "_method": "DELETE"
                    })
                    .done(response => {
                        // Success
                        purchase_detail_table.ajax.reload();
                    })
                    .fail(errors => {
                        // Failed
                        alert("Failed to delete data!");

                        return;
                    });
            }
        }

        // Function: Load Total Pay Label
        function loadTotalPayLabel(discount = 0) {
            $("#total_purchase").val($(".total").val());
            $("#total_amount_purchase").val($(".total_amount").val());

            const url = `{{ url('/purchase_detail/load-form') }}/${discount}/${$(".total").val()}`;

            $.get(url)
                .done(response => {
                    // Success
                    $("#pay").val(response.pay);
                    $("#total_rp").val("Rp " + response.total_rp);
                    $("#pay_purchase").val(response.pay_rp);

                    $(".show_pay").text("Rp " + response.pay_rp);
                    $(".show_text").text(response.show_text);
                })
                .fail(errors => {
                    // Failed
                    alert("Failed to get data!");

                    return;
                });
        }
    </script>
@endpush
