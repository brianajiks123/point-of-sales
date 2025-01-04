<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post">
            @csrf
            @method('POST')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <input type="text" name="name" id="inputErrorName" class="form-control"
                            placeholder="Enter Product Name" required>
                    </div>
                    <div class="form-group row">
                        <select name="category_id" id="inputErrorCategoryId" class="form-control" required>
                            <option value="">-- Choose Category --</option>

                            @foreach ($categories as $key => $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <input type="text" name="brand" id="inputErrorBrand" class="form-control"
                            placeholder="Enter Product Brand" required>
                    </div>
                    <div class="form-group row">
                        <input type="number" name="price" id="inputErrorPrice" class="form-control"
                            placeholder="Enter Purchase Price" min="1" required>
                    </div>
                    <div class="form-group row">
                        <input type="number" name="sell_price" id="inputErrorSellPrice" class="form-control"
                            placeholder="Enter Sell Price" min="1" required>
                    </div>
                    <div class="form-group row">
                        <input type="number" name="discount" id="inputErrorDiscount" class="form-control"
                            placeholder="Enter Discount" min="0" required>
                    </div>
                    <div class="form-group row">
                        <input type="number" name="stock" id="inputErrorStock" class="form-control"
                            placeholder="Enter Stock" min="1" value="1" required>
                        <small class="ml-1">Min. 1</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                            class="fas fa-times-circle"></i> Close</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
