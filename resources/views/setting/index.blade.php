@extends('layouts.master')

@section('title')
    <h3 class="mb-0">{{ $menu }}</h3>
@endsection

@section('breadcumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">{{ $menu }}</li>
@endsection

@section('content')
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <form action="{{ route('setting.update', Auth::user()->id) }}" method="post"
                            enctype="multipart/form-data" class="setting_form" data-toggle="validator">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="alert alert-info alert-dismissible" style="display: none;">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">&times;</button>
                                    <i class="icon fas fa-check"></i> Update data success.
                                </div>

                                <div class="form-group row">
                                    <label for="company_name" class="col-lg-3 col-offset-1 col-form-label">Company
                                        Name</label>
                                    <div class="col-lg-6">
                                        <input type="text" name="company_name" class="form-control" id="company_name"
                                            placeholder="Enter Company Name" required>
                                        <span class="help-block with-errors text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone" class="col-lg-3 col-offset-1 col-form-label">Phone</label>
                                    <div class="col-lg-6">
                                        <input type="number" name="phone" class="form-control" id="phone"
                                            placeholder="Enter Phone" minlength="12" required>
                                        <span class="help-block with-errors text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address" class="col-lg-3 col-offset-1 col-form-label">Address</label>
                                    <div class="col-lg-6">
                                        <textarea name="address" class="form-control" id="address" cols="15" rows="2" placeholder="Enter Address"
                                            required></textarea>
                                        <span class="help-block with-errors text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="path_logo" class="col-lg-3 col-offset-1 col-form-label">Logo</label>
                                    <div class="col-lg-4">
                                        <input type="file" name="path_logo" class="form-control" id="path_logo"
                                            accept="image/png, image/jpeg, image/jpg"
                                            onchange="imagePreview('.show_logo', this.files[0], 100)">
                                        <span class="help-block with-errors text-danger"></span><br>
                                        <div class="show_logo"></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="path_card_member" class="col-lg-3 col-offset-1 col-form-label">Card
                                        Member</label>
                                    <div class="col-lg-4">
                                        <input type="file" name="path_card_member" class="form-control"
                                            id="path_card_member" accept="image/png, image/jpeg, image/jpg"
                                            onchange="imagePreview('.show_card_member', this.files[0])">
                                        <span class="help-block with-errors text-danger"></span><br>
                                        <div class="show_card_member"></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="discount" class="col-lg-3 col-offset-1 col-form-label">Discount</label>
                                    <div class="col-lg-2">
                                        <input type="number" name="discount" class="form-control" id="discount"
                                            placeholder="Enter Discount" min="0" value="0" required>
                                        <span class="help-block with-errors text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="note_type" class="col-lg-3 col-offset-1 col-form-label">Note Type</label>
                                    <div class="col-lg-2">
                                        <select name="note_type" class="form-control" id="note_type" required>
                                            <option value="1">Small Note</option>
                                            <option value="2">Big Note</option>
                                        </select>
                                        <span class="help-block with-errors text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update</button>
                            </div>
                        </form>
                        <!-- ./card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row (main row) -->
        </div>
        <!--end::Container-->
    </div>
@endsection

@push('scripts')
    <script>
        showData();

        $(function() {
            $("body").addClass("sidebar-collapse");

            $(".setting_form").validator().on("submit", function(e) {
                if (!e.preventDefault()) {
                    $.ajax({
                            url: $(".setting_form").attr("action"),
                            type: $(".setting_form").attr("method"),
                            data: new FormData($(".setting_form")[0]),
                            async: false,
                            processData: false,
                            contentType: false
                        })
                        .done(response => {
                            showData();

                            $(".alert").fadeIn();

                            setTimeout(() => {
                                $(".alert").fadeOut();
                            }, 3000);
                        })
                        .fail(errors => {
                            alert("Failed to update data!");
                        });
                }
            });
        });

        // Get Data
        function showData() {
            $.get("{{ route('setting.show', Auth::user()->id) }}")
                .done(response => {
                    $("[name=company_name]").val(response.company_name);
                    $("title").text(response.company_name + " | Setting");

                    $("[name=phone]").val(response.phone);
                    $("[name=address]").val(response.address);
                    $("[name=discount]").val(response.discount);
                    $("[name=note_type]").val(response.note_type);

                    if (response.path_logo == "") {
                        $(".show_logo").html(`<p>Image is empty.</p>`);
                    }

                    if (response.path_card_member == "") {
                        $(".show_card_member").html(`<p>Image is empty.</p>`);
                    }

                    $(".show_logo").html(`<img src="${response.path_logo}" width="100">`);
                    $("[rel=icon]").attr("href", response.path_logo);

                    $(".show_card_member").html(`<img src="${response.path_card_member}" width="200">`);

                })
                .fail(errors => {
                    alert("Failed to get data!");
                });
        }
    </script>
@endpush
