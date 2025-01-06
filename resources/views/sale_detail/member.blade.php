<div class="modal fade" id="modalMember" tabindex="-1" aria-labelledby="modalMemberLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="member_table" class="table table-bordered table-striped">
                        <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>
                                <i class="fas fa-cog"></i>
                            </th>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->phone }}</td>
                                    <td>{{ $member->address }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-xs"
                                            onclick="chooseMember('{{ $member->id }}', '{{ $member->member_code }}')">
                                            <i class="fas fa-check-circle"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let member_table;

    $(function() {
        member_table = $("#member_table")
            .DataTable({
                lengthChange: false,
                autoWidth: false,
                dom: "Brt",
                bsort: false,
            });
    });
</script>
