<div class="modal fade" id="modalSupplier" tabindex="-1" aria-labelledby="modalSupplierLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="supplier_table" class="table table-bordered table-striped">
                        <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>
                                <i class="fas fa-cog"></i>
                            </th>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $supplier)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $supplier->name }}</td>
                                    <td>{{ $supplier->phone }}</td>
                                    <td>{{ $supplier->address }}</td>
                                    <td>
                                        <a href="{{ url('/purchase/' . $supplier->id . '/create') }}"
                                            class="btn btn-primary btn-xs">
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
</div>

<script>
    let supplier_table;

    $(function() {
        supplier_table = $("#supplier_table")
            .DataTable({
                lengthChange: false,
                autoWidth: false,
                dom: "Brt",
                bsort: false,
            });
    });
</script>
