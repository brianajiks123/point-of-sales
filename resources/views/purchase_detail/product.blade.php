<div class="modal fade" id="modalProduct" tabindex="-1" aria-labelledby="modalProductLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="product_table" class="table table-bordered table-striped">
                    <thead>
                        <th>#</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>
                            <i class="fas fa-cog"></i>
                        </th>
                    </thead>
                    <tbody>
                        @foreach ($product as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class='badge badge-success'
                                        style='font-size: 14px;'>{{ $item->code }}</span>
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->price }}</td>
                                <td>
                                    <a class="btn btn-primary btn-xs"
                                        onclick="chooseProduct('{{ $item->id }}', '{{ $item->code }}')">
                                        <i class="fas fa-check-circle"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    let product_table;

    $(function() {
        product_table = $("#product_table")
            .DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                dom: "Brt",
                bSort: false,
            });
    });
</script>
