@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Data User</h1>
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addUserModal">
        Tambah Data User
    </button>
    <button type="button" class="btn btn-warning mb-3" onclick="window.location.href='{{ route('dashboard.sa') }}'">Dashboard (F1)</button>

    <table id="userTable" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th width="100px">Aksi</th>
                <th width="50px">No. </th>
                <th>Nama</th>
                <th>Username</th>
                <th>Level</th>
                <th>Instansi</th>
                <th>Telepon</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <!-- Modals Tambah Data User -->
    <div class="modal fade" id="addUserModal" role="dialog" aria-labelledby="addUserModalLabel" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Tambah Data User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addUserForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" name="name" placeholder="Nama" required>
                            <label for="name">Username</label>
                            <input type="text" class="form-control" name="username" placeholder="username" required>
                            <label for="level">Level</label>
                            <select name="level_id" id="level_id" class="form-control select" style="width: 100%;" required>
                                @foreach($levels as $level)
                                    <option value="{{ $level->id }}">{{ $level->level}}</option>
                                @endforeach
                            </select>
                            <label for="instansi">Instansi</label>
                            <select name="instansi_id" id="instansi_id" class="form-control select2" style="width: 100%;" required>
                                @foreach($instansi as $ins)
                                    <option value="{{ $ins->id }}">{{ $ins->instansi }}</option>
                                @endforeach
                            </select>
                            <label for="telepon">Telepon</label>
                            <input type="text" class="form-control" name="telepon" placeholder="Telepon" required>
                            <label for="email">E-Mail</label>
                            <input type="text" class="form-control" name="email" placeholder="E-Mail" required>
                            <label for="password">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <label for="password_confirmation">Retype Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Retype Password" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="toggleConfirmPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- form modals edit user --}}
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit Data User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editUserId">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" name="name" id="editName" placeholder="Nama" required>
                            <label for="name">Username</label>
                            <input type="text" class="form-control" name="username" id="editUsername" placeholder="Username" required>
                            <label for="level">Level</label>
                            <select name="level" id="editLevel"class="form-control select" style="width: 100%;" required>
                                @foreach($levels as $level)
                                    <option value="{{ $level->id }}">{{ $level->level }}</option>
                                @endforeach
                            </select>
                            <label for="instansi">Instansi</label>
                            <select name="instansi" id="editInstansi" class="form-control select2" style="width: 100%;" required>
                                @foreach($instansi as $ins)
                                    <option value="{{ $ins->id }}">{{ $ins->instansi }}</option>
                                @endforeach
                            </select>
                            <label for="telepon">Telepon</label>
                            <input type="text" class="form-control" name="telepon" id="editTelepon" placeholder="Telepon" required>
                            <label for="email">E-Mail</label>
                            <input type="text" class="form-control" name="email" id="editEmail" placeholder="E-Mail" required>
                            <label for="password">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="editPassword" placeholder="Password" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="toggleEditPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <label for="password_confirmation">Retype Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password_confirmation" id="editPassword_confirmation" placeholder="Retype Password" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="toggleEditConfirmPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
@push('styles')
    <style>
        .select2-container--open {
            z-index: 1050 !important; /* Pastikan z-index cukup tinggi untuk modal */
        }

        .select2-dropdown {
            width: 100% !important; /* Mengatur lebar dropdown */
            box-sizing: border-box;
        }
    </style>
@endpush

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#addUserModal').on('shown.bs.modal', function () {
            $('#instansi').select2({
                placeholder: 'Pilih Instansi',
                allowClear: true,
                minimumInputLength: 2,
                width: '100%', // Ensures the input is responsive
                dropdownParent: $('#addUserModal'),
                dropdownAutoWidth: true,
                ajax: {
                    url: "{{ route('instansi.cari') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term
                        };
                    },

                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });
        });

        $('#togglePassword').on('click', function () {
            const passwordField = $('#password');
            const passwordFieldType = passwordField.attr('type');

            if (passwordFieldType === 'password') {
                passwordField.attr('type', 'text');
                $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash'); // Change icon
            } else {
                passwordField.attr('type', 'password');
                $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye'); // Change icon
            }
        });

        $('#toggleConfirmPassword').on('click', function () {
            const confirmPasswordField = $('#password_confirmation');
            const confirmPasswordFieldType = confirmPasswordField.attr('type');

            if (confirmPasswordFieldType === 'password') {
                confirmPasswordField.attr('type', 'text');
                $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash'); // Change icon
            } else {
                confirmPasswordField.attr('type', 'password');
                $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye'); // Change icon
            }
        });

        $('#toggleEditPassword').on('click', function () {
            const editPasswordField = $('#editPassword');
            const editPasswordFieldType = editPasswordField.attr('type');

            if (editPasswordFieldType === 'password') {
                editPasswordField.attr('type', 'text');
                $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                editPasswordField.attr('type', 'password');
                $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        $('#toggleEditConfirmPassword').on('click', function () {
            const editConfirmPasswordField = $('#editPassword_confirmation');
            const editConfirmPasswordFieldType = editConfirmPasswordField.attr('type');

            if (editConfirmPasswordFieldType === 'password') {
                editConfirmPasswordField.attr('type', 'text');
                $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                editConfirmPasswordField.attr('type', 'password');
                $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        var table = $('#userTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('user.data') }}",
            columns: [
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'username', name: 'username' },
                { data: 'level', name: 'level' },
                { data: 'instansi', name: 'instansi' },
                { data: 'telepon', name: 'telepon' },
                { data: 'email', name: 'email' }
            ]
        });

            $('#addUserForm').on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('user.simpan') }}",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if(response.success) {
                            $('#addUserForm')[0].reset();
                            $('#addUserModal').modal('hide');
                            table.ajax.reload(null, false);
                            alert('Data User berhasil disimpan');
                        } else {
                            alert('Gagal menyimpan data level');
                        }
                    },
                    error: function (xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMsg = '';
                        $.each(errors, function (key, value) {
                            errorMsg += value[0] + '\n';
                        });
                        alert(errorMsg);
                    }
                });
            });

            window.editUser = function(button) {
                var id = $(button).data('id');
                var url = "{{ route('user.edit', ':id') }}".replace(':id', id);
                $.get(url, function (data) {
                    $('#editUserModal').modal('show');
                    $('#editUserId').val(data.id);
                    $('#editName').val(data.name);
                    $('#editUsername').val(data.username);
                    $('#editLevel').val(data.level);
                    $('#editInstansi').val(data.instansi);
                    $('#editEmail').val(data.email);
                    $('#editTelepon').val(data.telepon);
                    var updateUrl = "{{ route('user.update', ':id') }}".replace(':id', id);
                    $('#editUserForm').attr('action', updateUrl);
                });
            }

            $('#editUserForm').on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var action = $(this).attr('action');
                $.ajax({
                    type: "PUT",
                    url: action,
                    data: formData,
                    success: function (response) {
                        $('#editUserModal').modal('hide');
                        table.ajax.reload();
                        alert(response.message);
                    },
                    error: function (xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMsg = '';
                        $.each(errors, function (key, value) {
                            errorMsg += value[0] + '\n';
                        });
                        alert(errorMsg);
                    }
                });
            });

            // Fungsi untuk menghapus data user
            window.deleteUser = function(button) {
                if(confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                    var id = $(button).data('id');
                    var url = "{{ route('user.hapus', ':id') }}".replace(':id', id);

                    $.ajax({
                        type: "DELETE",
                        url: url,
                        success: function(response) {
                            if(response.success) {
                                $('#userTable').DataTable().ajax.reload();
                                alert(response.message);
                            } else {
                                alert('Gagal menghapus data user');
                            }
                        },
                        error: function (xhr) {
                            var errors = xhr.responseJSON.errors;
                            var errorMsg = '';
                            $.each(errors, function (key, value) {
                                errorMsg += value[0] + '\n';
                            });
                            alert(errorMsg);
                        }
                    });
                }
            }
    });
</script>
@endpush
