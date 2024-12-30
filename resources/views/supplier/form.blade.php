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
                            <label class="col-form-label text-danger" for="inputError" style="font-size: 14px;">
                                <i class="fas fa-times-circle"></i> {{ $message }}
                            </label>
                        @enderror
                        <input type="text" name="name" id="inputError"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Enter Category Name"
                            required>
                    </div>
                    <div class="form-group row">
                        @error('phone')
                            <label class="col-form-label text-danger" for="inputErrorPhone" style="font-size: 14px;">
                                <i class="fas fa-times-circle"></i> {{ $message }}
                            </label>
                        @enderror
                        <input type="number" name="phone" id="inputErrorPhone"
                            class="form-control @error('phone') is-invalid @enderror" placeholder="Enter Phone"
                            required>
                    </div>
                    <div class="form-group row">
                        @error('address')
                            <label class="col-form-label text-danger" for="inputErrorAddress" style="font-size: 14px;">
                                <i class="fas fa-times-circle"></i> {{ $message }}
                            </label>
                        @enderror
                        <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" cols="30"
                            rows="10" placeholder="Enter Address" required></textarea>
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
