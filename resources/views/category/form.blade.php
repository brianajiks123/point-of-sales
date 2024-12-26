<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="post">
            @csrf
            @method("POST")

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
                                <i class="far fa-times-circle"></i> {{ $message }}
                            </label>
                        @enderror
                        <input type="text" name="name" id="inputError"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Enter Category Name"
                            value="{{ old('name') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
