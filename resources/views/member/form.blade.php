<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel">
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
                        <input type="text" name="name" id="name" class="form-control placeholder="Enter
                            Member Name" required>
                    </div>
                    <div class="form-group row">
                        <input type="number" name="phone" id="phone" class="form-control"
                            placeholder="Enter Phone" required>
                    </div>
                    <div class="form-group row">
                        <textarea name="address" id="address" class="form-control" cols="30" rows="10"
                            placeholder="Enter Address" required></textarea>
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
