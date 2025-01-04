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
                        <form action="{{ route('user.updateProfile') }}" method="post" enctype="multipart/form-data"
                            class="profile_form" data-toggle="validator">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="alert alert-info alert-dismissible" style="display: none;">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">&times;</button>
                                    <i class="icon fas fa-check"></i> Update profile success.
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-lg-3 col-offset-1 col-form-label">Name</label>
                                    <div class="col-lg-6">
                                        <input type="text" name="name" class="form-control" id="name"
                                            placeholder="Enter Name" value="{{ Auth::user()->name }}" required>
                                        <span class="help-block with-errors text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="profile_photo_path"
                                        class="col-lg-3 col-offset-1 col-form-label">Photo</label>
                                    <div class="col-lg-4">
                                        <input type="file" name="profile_photo_path" class="form-control"
                                            id="profile_photo_path" accept="image/png, image/jpeg, image/jpg"
                                            onchange="imagePreview('.show_profile_photo', this.files[0], 100)">
                                        <span class="help-block with-errors text-danger"></span><br>
                                        <div class="show_profile_photo">
                                            <img src="{{ Auth::user()->profile_photo_path ? url(Auth::user()->profile_photo_path) : asset('admin/img/user2-160x160.jpg') }}"
                                                width="100">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="curr_password" class="col-lg-3 col-offset-1 col-form-label">Current
                                        Password</label>
                                    <div class="col-lg-4">
                                        <input type="password" name="curr_password" id="curr_password" class="form-control"
                                            placeholder="Enter Current Password" minlength="8">
                                        <span class="help-block with-errors text-danger"></span><br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="new_password" class="col-lg-3 col-offset-1 col-form-label">New
                                        Password</label>
                                    <div class="col-lg-4">
                                        <input type="password" name="new_password" id="new_password" class="form-control"
                                            placeholder="Enter New Password" minlength="8">
                                        <span class="help-block with-errors text-danger"></span><br>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>
                                        Update</button>
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
        $(function() {
            $("body").addClass("sidebar-collapse");

            $("#curr_password").on("keyup", function() {
                if ($(this).val() != "") $("#new_password").attr("required", true);
                else $("#new_password").attr("required", false);
            });

            $(".profile_form").validator().on("submit", function(e) {
                if (!e.preventDefault()) {
                    $.ajax({
                            url: $(".profile_form").attr("action"),
                            type: $(".profile_form").attr("method"),
                            data: new FormData($(".profile_form")[0]),
                            async: false,
                            processData: false,
                            contentType: false
                        })
                        .done(response => {
                            $("[name=name]").val(response.name);

                            if (response.profile_photo_path == "") {
                                $(".show_profile_photo").html(`<p>Image is empty.</p>`);
                            }

                            $(".show_profile_photo").html(
                                `<img src="${response.profile_photo_path}" width="100">`);

                            $(".img_profile").attr("src", `${response.profile_photo_path}`);

                            $(".alert").fadeIn();

                            setTimeout(() => {
                                $(".alert").fadeOut();
                            }, 3000);
                        })
                        .fail(errors => {
                            if (errors.status == 422) alert(errors.reponseJSON);
                            else alert("Failed to update data!");
                            return;
                        });
                }
            });
        });
    </script>
@endpush
