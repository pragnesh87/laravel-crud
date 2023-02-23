@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h3>Users</h3>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">New</button>
                </div>
                <div class="d-flex justify-content-end mt-3 mb-3">
                    <div class="input-group">
                        <input type="search" class="form-control" id="search" name="search"
                            placeholder="Search: name/email/gender" aria-label="Recipient's username"
                            aria-describedby="search-aria">
                        <span class="input-group-text" id="search-aria"><i class="bi bi-search"></i></span>
                    </div>
                </div>
            </div>
            <div class="card-body" id="user-table">
                @include('users.list')
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="userModalId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalId">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid" id="create-user-modal-body">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-user">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalId"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalId">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid" id="edit-user-modal-body">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="update-user">Update</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('show.bs.modal', function() {
                $.ajax({
                        method: "get",
                        url: '{{ route('user.create') }}',
                        dataType: 'html',
                    })
                    .done(function(response, textStatus, jqXHR) {
                        $("#create-user-modal-body").html(response);
                    });
            });

            $(document).on('click', '#save-user', function() {
                const formdata = new FormData($("#create-user-form")[0]);
                $.ajax({
                        method: "POST",
                        url: '{{ route('user.save') }}',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formdata,
                        dataType: 'json',
                    })
                    .done(function(response, textStatus, jqXHR) {
                        if (response.success) {
                            $("#createModal").modal('hide');

                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                            })

                            loadUsers();
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                            })
                        }
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        const resp = jqXHR.responseJSON
                        Swal.fire({
                            title: 'Error!',
                            text: resp.message,
                            icon: 'error',
                        })
                    });
            });

            $(document).on('click', '.edit-user', function() {
                let id = $(this).data('id');
                $.ajax({
                        method: "get",
                        url: '{{ route('user.edit') }}',
                        data: {
                            id: id
                        },
                        dataType: 'html',
                    })
                    .done(function(response, textStatus, jqXHR) {
                        $("#editModal").modal('show');
                        $("#edit-user-modal-body").html(response);
                    })
            });

            $(document).on('click', '#update-user', function() {
                const formdata = new FormData($("#update-user-form")[0]);
                $.ajax({
                        method: "POST",
                        url: '{{ route('user.update') }}',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formdata,
                        dataType: 'json',
                    })
                    .done(function(response, textStatus, jqXHR) {
                        if (response.success) {
                            $("#editModal").modal('hide');
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                            })

                            loadUsers();
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                            })
                        }
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        const resp = jqXHR.responseJSON
                        Swal.fire({
                            title: 'Error!',
                            text: resp.message,
                            icon: 'error',
                        })
                    });
            });

            $(document).on('click', '.delete-user', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#C0392B',
                    cancelButtonColor: '#2C3E50',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('user.delete') }}',
                            method: 'delete',
                            data: {
                                id: id,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'Your file has been deleted.',
                                    icon: 'success'
                                });

                                loadUsers();
                            }
                        });
                    }
                })
            });

            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                loadUsers(page);
            });

            $(document).on('click', '#search-aria', function() {
                loadUsers();
            });
        });

        function loadUsers(page = 1) {
            $.ajax({
                    method: "get",
                    url: '{{ route('user.list') }}',
                    data: {
                        search: $('#search').val(),
                        page: page
                    },
                    dataType: 'html',
                })
                .done(function(response, textStatus, jqXHR) {
                    $("#user-table").html(response);
                })
                .fail(function(jqXHR, textStatus, errorThrown) {

                });
        }
    </script>
@endpush
