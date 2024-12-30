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
                        @error('description')
                            <label class="col-form-label text-danger" for="inputErrorDescription" style="font-size: 14px;">
                                <i class="fas fa-times-circle"></i> {{ $message }}
                            </label>
                        @enderror
                        <textarea name="description" id="inputErrorDescription" class="form-control @error('description') is-invalid @enderror"
                            cols="30" rows="10" placeholder="Enter Description" required></textarea>
                    </div>
                    <div class="form-group row">
                        @error('amount')
                            <label class="col-form-label text-danger" for="inputErrorAmount" style="font-size: 14px;">
                                <i class="fas fa-times-circle"></i> {{ $message }}
                            </label>
                        @enderror
                        <input type="number" name="amount" id="inputErrorAmount"
                            class="form-control @error('amount') is-invalid @enderror" placeholder="Enter Amount"
                            min="1" required>
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
