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
                        @error('name')
                            <label class="col-form-label text-danger" for="inputErrorName" style="font-size: 14px;">
                                <i class="fas fa-times-circle"></i> {{ $message }}
                            </label>
                        @enderror
                        <input type="text" name="name" id="inputErrorName"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Enter Product Name"
                            required>
                    </div>
                    <div class="form-group row">
                        @error('category')
                            <label class="col-form-label text-danger" for="inputErrorCategoryId"
                                style="font-size: 14px;">
                                <i class="fas fa-times-circle"></i> {{ $message }}
                            </label>
                        @enderror
                        <select name="category_id" id="inputErrorCategoryId" class="form-control" required>
                            <option value="">-- Choose Category --</option>

                            @foreach ($categories as $key => $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        @error('brand')
                            <label class="col-form-label text-danger" for="inputErrorBrand" style="font-size: 14px;">
                                <i class="fas fa-times-circle"></i> {{ $message }}
                            </label>
                        @enderror
                        <input type="text" name="brand" id="inputErrorBrand"
                            class="form-control @error('brand') is-invalid @enderror" placeholder="Enter Product Brand"
                            required>
                    </div>
                    <div class="form-group row">
                        @error('price')
                            <label class="col-form-label text-danger" for="inputErrorPrice" style="font-size: 14px;">
                                <i class="fas fa-times-circle"></i> {{ $message }}
                            </label>
                        @enderror
                        <input type="number" name="price" id="inputErrorPrice"
                            class="form-control @error('price') is-invalid @enderror" placeholder="Enter Purchase Price"
                            min="1" required>
                    </div>
                    <div class="form-group row">
                        @error('sell_price')
                            <label class="col-form-label text-danger" for="inputErrorSellPrice" style="font-size: 14px;">
                                <i class="fas fa-times-circle"></i> {{ $message }}
                            </label>
                        @enderror
                        <input type="number" name="sell_price" id="inputErrorSellPrice"
                            class="form-control @error('sell_price') is-invalid @enderror"
                            placeholder="Enter Sell Price" min="1" required>
                    </div>
                    <div class="form-group row">
                        @error('discount')
                            <label class="col-form-label text-danger" for="inputErrorDiscount" style="font-size: 14px;">
                                <i class="fas fa-times-circle"></i> {{ $message }}
                            </label>
                        @enderror
                        <input type="number" name="discount" id="inputErrorDiscount"
                            class="form-control @error('discount') is-invalid @enderror" placeholder="Enter Discount"
                            min="0" value="0">
                    </div>
                    <div class="form-group row">
                        @error('stock')
                            <label class="col-form-label text-danger" for="inputErrorStock" style="font-size: 14px;">
                                <i class="fas fa-times-circle"></i> {{ $message }}
                            </label>
                        @enderror
                        <input type="number" name="stock" id="inputErrorStock"
                            class="form-control @error('stock') is-invalid @enderror" placeholder="Enter Stock"
                            min="1" value="1" required>
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
