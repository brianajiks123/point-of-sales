<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sale Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="sale_detail_table" class="table table-bordered table-striped">
                        <thead>
                            <th>#</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Price (Rp)</th>
                            <th>Amount</th>
                            <th>Sub Total (Rp)</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let sale_detail_table;

    $(function() {
        sale_detail_table = $("#sale_detail_table")
            .DataTable({
                lengthChange: false,
                autoWidth: false,
                processing: true,
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
                    }
                ],
                dom: "Brt",
                bsort: false
            });
    });
</script>
