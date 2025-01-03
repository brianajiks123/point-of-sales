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
                            class="form-control @error('name') is-invalid @enderror" placeholder="Enter Name" required>
                    </div>
                    <div class="form-group row">
                        @error('email')
                            <label class="col-form-label text-danger" for="inputErrorEmail" style="font-size: 14px;">
                                <i class="fas fa-times-circle"></i> {{ $message }}
                            </label>
                        @enderror
                        <input type="email" name="email" id="inputErrorEmail"
                            class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email"
                            required>
                    </div>
                    <div class="form-group row">
                        @error('password')
                            <label class="col-form-label text-danger" for="inputErrorPassword" style="font-size: 14px;">
                                <i class="fas fa-times-circle"></i> {{ $message }}
                            </label>
                        @enderror
                        <input type="password" name="password" id="inputErrorPassword"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Enter Password"
                            minlength="8" required>
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
