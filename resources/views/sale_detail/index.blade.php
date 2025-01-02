@extends('layouts.master')

@section('title')
    <h3 class="mb-0">{{ $menu }}</h3>
@endsection

@push('css_detail')
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

        #sale_detail_table tbody tr:last-child {
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
                        <div class="card-body">
                            <form class="product_form">
                                @csrf
                                <div class="form-group row">
                                    <label for="product_code" class="col-lg-2 col-form-label">Product Code</label>
                                    <div class="col-lg-5">
                                        <div class="input-group">
                                            <input type="hidden" name="sale_id" id="sale_id" value="{{ $sale_id }}">
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

                            <table id="sale_detail_table" class="table table-bordered table-striped">
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
                                    <form action="{{ route('sale.store') }}" method="POST" class="sale_form">
                                        @csrf
                                        <input type="hidden" name="sale_id" value="{{ $sale_id }}">
                                        <input type="hidden" name="total_sale" id="total_sale">
                                        <input type="hidden" name="total_amount_sale" id="total_amount_sale">
                                        <input type="hidden" name="pay" id="pay">
                                        <input type="hidden" name="member_id" id="member_id" value="{{ $member->id }}">

                                        <div class="form-group row">
                                            <label for="total_rp"class="col-lg col-form-label">Total (Rp)</label>
                                            <div class="col-lg">
                                                <input type="text" id="total_rp" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="member_code" class="col-lg col-form-label">Member</label>
                                            <div class="col-lg">
                                                <div class="input-group">
                                                    <input type="text" id="member_code" class="form-control"
                                                        value="{{ $member->member_code }}">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-info btn-flat"
                                                            onclick="showMember()">
                                                            <i class="fas fa-search"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="discount" class="col-lg col-form-label">Discount (%)</label>
                                            <div class="col-lg">
                                                <input type="number" name="discount" id="discount" class="form-control"
                                                    value="{{ !empty($member) ? $discount : 0 }}" min="0" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="pay_sale" class="col-lg col-form-label">Pay (Rp)</label>
                                            <div class="col-lg">
                                                <input type="text" id="pay_sale" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="accepted" class="col-lg col-form-label">Accepted (Rp)</label>
                                            <div class="col-lg">
                                                <input type="number" name="accepted" id="accepted"
                                                    class="form-control" value="{{ $sale->accepted ?? 0 }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="back_rp" class="col-lg col-form-label">Back Money (Rp)</label>
                                            <div class="col-lg">
                                                <input type="text" id="back_rp" class="form-control" value="0"
                                                    readonly>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-lg-9"></div>
                                <div class="col-lg">
                                    <button type="submit" class="btn btn-primary" id="btn_save">Save
                                        Transaction</button>
                                    <a href="{{ route('sale.index') }}" class="btn btn-secondary">Back</a>
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

    @includeIf('sale_detail.product')
    @includeIf('sale_detail.member')
@endsection

@push('scripts')
    <script>
        let sale_detail_table;

        $(function() {
            $("body").addClass("sidebar-collapse");

            sale_detail_table = $("#sale_detail_table")
                .DataTable({
                    responsive: true,
                    lengthChange: false,
                    autoWidth: false,
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: "{{ route('transaction.data', $sale_id) }}",
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
                            data: "sale_price"
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
                    loadTotalPayLabel($("#discount").val(), $("#accepted").val());
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

                $.post(`{{ url('/transaction') }}/${id}`, {
                        "_token": $("[name=csrf-token]").attr("content"),
                        "_method": "PUT",
                        "amount": amount
                    })
                    .done(response => {
                        sale_detail_table.ajax.reload();
                    })
                    .fail(errors => {
                        alert("Failed to update amount!");
                        return;
                    });
            });

            // Update Accepted Money
            $("#accepted").on("change", function() {
                if ($(this).val() == "") {
                    $(this).val(0).select();
                }

                if (parseInt($(this).val()) < parseInt($("#pay").val())) {
                    alert("Accepted must be greater than Pay!");
                } else {
                    loadTotalPayLabel($("#discount").val(), $(this).val());
                }
            }).focus(function() {
                $(this).select();
            });

            // Save Sale Transaction
            $("#btn_save").on("click", function() {
                $(".sale_form").submit();
            });
        });

        // Function: Show Product
        function showProduct() {
            $("#modalProduct").modal("show");
        }

        // Function: Hide Product
        function hideProduct() {
            $("#modalProduct").modal("hide");
        }

        // Function: Choose Product of Sale Detail
        function chooseProduct(id, code) {
            $('#product_id').val(id);
            $('#product_code').val(code);

            hideProduct();

            addProduct();
        }

        // Function: Add Product of Sale Detail
        function addProduct() {
            $.post("{{ route('transaction.store') }}", $(".product_form").serialize())
                .done(response => {
                    $('#product_code').focus();

                    sale_detail_table.ajax.reload();
                })
                .fail(errors => {
                    alert("Failed to save data!");
                    return;
                })
        }

        // Function: Show Member
        function showMember() {
            $("#modalMember").modal("show");
        }

        // Function: Hide Member
        function hideMember() {
            $("#modalMember").modal("hide");
        }

        // Function: Choose Member of Sale Detail
        function chooseMember(id, code) {
            $('#member_id').val(id);
            $('#member_code').val(code);
            $('#discount').val("{{ $discount }}");

            if ($('#accepted').val() != 0) {
                loadTotalPayLabel($('#discount').val(), $('#accepted').val());
            } else {
                loadTotalPayLabel($('#discount').val());

                $("#accepted").val(0).select();
            }

            hideMember();
        }

        // Function: Delete Sale Detail
        function deleteSaleDetail(url) {
            if (confirm("Are you sure delete this sale?")) {
                // Delete Data
                $.post(url, {
                        "_token": $("[name=csrf-token]").attr("content"),
                        "_method": "DELETE"
                    })
                    .done(response => {
                        // Success
                        sale_detail_table.ajax.reload();
                    })
                    .fail(errors => {
                        // Failed
                        alert("Failed to delete data!");

                        return;
                    });
            }
        }

        // Function: Load Total Pay Label
        function loadTotalPayLabel(discount = 0, accepted = 0) {
            $("#total_sale").val($(".total").val());
            $("#total_amount_sale").val($(".total_amount").val());

            const url = `{{ url('/transaction/load-form') }}/${discount}/${$(".total").val()}/${accepted}`;

            $.get(url)
                .done(response => {
                    // Success
                    $("#pay").val(response.pay);
                    $("#total_rp").val(response.total_rp);
                    $("#pay_sale").val(response.pay_rp);

                    $(".show_pay").text("Bayar: Rp " + response.pay_rp);
                    $(".show_text").text(response.show_text);

                    $("#back_rp").val(response.back_rp);

                    if ($("#accepted").val() != 0) {
                        $(".show_pay").text("Back: Rp " + response.back_rp);
                        $(".show_text").text(response.back_show_text);
                    }

                    if (response.back_rp.toString().includes("-")) {
                        $("#btn_save").prop("disabled", true);
                    } else {
                        $("#btn_save").prop("disabled", false);
                    }
                })
                .fail(errors => {
                    // Failed
                    alert("Failed to get data!");

                    return;
                });
        }
    </script>
@endpush
