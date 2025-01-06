<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel">
    <div class="modal-dialog">
        <form action="{{ route('report.index') }}" method="get">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Report Period</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="input-group date" id="first_date" data-target-input="nearest">
                            <input type="text" name="f_date" class="form-control datetimepicker-input"
                                placeholder="Enter First Date" data-target="#first_date" value="{{ request('f_date') }}"
                                required />
                            <div class="input-group-append" data-target="#first_date" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="input-group date" id="last_date" data-target-input="nearest">
                            <input type="text" name="l_date" class="form-control datetimepicker-input"
                                placeholder="Enter Last Date" data-target="#last_date" value="{{ request('l_date') }}"
                                required />
                            <div class="input-group-append" data-target="#last_date" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="fas fa-times-circle"></i> Close</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Change</button>
                    </div>
                </div>
        </form>
    </div>
</div>
