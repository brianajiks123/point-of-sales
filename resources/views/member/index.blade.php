@extends('layouts.master')

@section('title')
    <h3 class="mb-0">List {{ $menu }}</h3>
@endsection

@section('breadcumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">{{ $menu }}</li>
@endsection

@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <button class="btn btn-primary xs" onclick="addMember('{{ route('member.store') }}')">
                                <i class="nav-icon fas fa-plus"></i> Add
                            </button>
                            <button class="btn btn-danger xs"
                                onclick="deleteMemberSelected('{{ route('member.deleteSelected') }}')">
                                <i class="nav-icon fas fa-trash"></i> Delete
                            </button>
                            <button class="btn btn-info xs" onclick="printMember('{{ route('member.printMember') }}')">
                                <i class="nav-icon fas fa-id-card"></i> Print Member
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="member_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <form method="post" class="member_form">
                                            @csrf
                                            <th>
                                                <input type="checkbox" name="select_all_member" id="select_all_member">
                                            </th>
                                        </form>
                                        <th>#</th>
                                        <th>Member Code</th>
                                        <th>Member Name</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>
                                            <i class="nav-icon fas fa-cog"></i>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @includeIf('member.form')
@endsection

@push('scripts')
    <script>
        $(function() {
            let member_table = $("#member_table").DataTable({
                responsive: true,
                lengthChange: false,
                serverSide: true,
                autoWidth: false,
                processing: true,
                ajax: {
                    url: "{{ route('member.data') }}",
                },
                columns: [{
                        data: "select_all_member",
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: "DT_RowIndex",
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: "member_code"
                    },
                    {
                        data: "name"
                    },
                    {
                        data: "address"
                    },
                    {
                        data: "phone"
                    },
                    {
                        data: "action",
                        searchable: false,
                        sortable: false
                    },
                ]
            });

            // Validator and Form Submit Logic
            $("#modalForm form").on("submit", function(e) {
                e.preventDefault(); // Prevent default form submission

                // Send form data via AJAX
                $.post($(this).attr("action"), $(this).serialize())
                    .done(function(response) {
                        // Success - reload table
                        member_table.ajax.reload();
                        $("#modalForm").modal("hide");
                    })
                    .fail(function(errors) {
                        alert("Failed to save data!");
                    });
            });

            // Select All Member
            $("[name=select_all_member]").on("click", function() {
                $("input[name='member_id[]']").prop("checked", this.checked);
            });

            // Function: Add Member
            window.addMember = function(url) {
                $("#modalForm").modal("show");
                $("#modalForm .modal-title").text("Add Member");

                $("#modalForm form")[0].reset();
                $("#modalForm form").attr("action", url);
                $("#modalForm [name=_method]").val("POST");
            }

            // Function: Edit Member
            window.editMember = function(url) {
                $("#modalForm").modal("show");
                $("#modalForm .modal-title").text("Edit Member");

                $("#modalForm form")[0].reset();
                $("#modalForm form").attr("action", url);
                $("#modalForm [name=_method]").val("PUT");

                // Get Member Data via AJAX
                $.get(url)
                    .done(function(response) {
                        $("#modalForm [name=name]").val(response.name);
                        $("#modalForm [name=phone]").val(response.phone);
                        $("#modalForm [name=address]").val(response.address);
                    })
                    .fail(function(errors) {
                        alert("Failed to load data!");
                    });
            }

            // Function: Delete Member
            window.deleteMember = function(url) {
                if (confirm("Are you sure delete this Member?")) {
                    $.post(url, {
                            "_token": $("[name=csrf-token]").attr("content"),
                            "_method": "DELETE"
                        })
                        .done((response) => {
                            member_table.ajax.reload();
                        })
                        .fail((errors) => {
                            alert("Failed to delete data!");
                        });
                }
            }

            window.deleteMemberSelected = function(url) {
                var selected_members = $("input[name='member_id[]']:checked").map(function() {
                    return this.value;
                }).get();

                if (selected_members.length > 0) {
                    if (confirm("Are you sure to delete the selected data?")) {
                        $.post(url, {
                                "_token": $("meta[name='csrf-token']").attr("content"),
                                "member_id": selected_members
                            })
                            .done(function(response) {
                                member_table.ajax.reload();
                            })
                            .fail(function(errors) {
                                alert("Failed to delete selected data!");
                            });
                    }
                } else {
                    alert("Choose data that will be deleted!");
                }
            }

            window.printMember = function(url) {
                var selected_members = $("input[name='member_id[]']:checked").map(function() {
                    return this.value;
                }).get();

                if (selected_members.length < 1) {
                    alert("Choose data that will be printed!");
                    return;
                } else {
                    // Create a form with selected member IDs and target="_blank"
                    var form = $("<form>", {
                        action: url,
                        method: "POST",
                        target: "_blank"
                    });

                    // Add CSRF token
                    form.append($("<input>", {
                        type: "hidden",
                        name: "_token",
                        value: $("meta[name='csrf-token']").attr("content")
                    }));

                    // Add the selected member IDs
                    form.append($("<input>", {
                        type: "hidden",
                        name: "member_id[]",
                        value: selected_members.join(',')
                    }));

                    // Append the form to body and submit it
                    $("body").append(form);
                    form.submit();
                    form.remove();
                }
            }
        });
    </script>
@endpush
