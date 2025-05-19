@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Data Instansi</h1>
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addInstansiModal">
        Tambah Data Instansi
    </button>
    <button type="button" class="btn btn-warning mb-3" onclick="window.location.href='{{ route('dashboard.sa') }}'">Dashboard (F1)</button>

    <table id="instansiTable" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th width="100px">Aksi</th>
                <th width="50px">No. </th>
                <th>Nama Instansi</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <!-- Modals Tambah Data Instansi -->
    <div class="modal fade" id="addInstansiModal" tabindex="-1" role="dialog" aria-labelledby="addInstansiModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addInstansiModalLabel">Tambah Data Instansi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addInstansiForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="namaInstansi">Nama Instansi</label>
                            <input type="text" class="form-control" name="instansi" id="instansi" placeholder="Nama Instansi" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Data Instansi -->
    <div class="modal fade" id="editInstansiModal" tabindex="-1" role="dialog" aria-labelledby="editInstansiModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editInstansiModalLabel">Edit Data Instansi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editInstansiForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editInstansiId">
                        <div class="form-group">
                            <label for="editInstansi">Nama Instansi</label>
                            <input type="text" class="form-control" name="instansi" id="editInstansi" placeholder="Nama Instansi" required>
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

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#instansiTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('instansi.data') }}",
                columns: [
                    {
                        data: 'aksi', name: 'aksi', orderable: false, searchable: false
                    },
                    {
                        data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false
                    },
                    {
                        data: 'instansi', name: 'instansi'
                    },
                ]
            });

            $('#addInstansiForm').on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('instansi.simpan') }}",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if(response.success) {
                            $('#addInstansiForm')[0].reset();
                            $('#addInstansiModal').modal('hide');
                            table.ajax.reload(null, false);
                            alert('Data instansi berhasil disimpan');
                        } else {
                            alert('Gagal menyimpan data instansi');
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

            window.editInstansi = function(button) {
                var id = $(button).data('id');
                var url = "{{ route('instansi.edit', ':id') }}".replace(':id', id);
                $.get(url, function (data) {
                    $('#editInstansiModal').modal('show');
                    $('#editInstansi').val(data.instansi);
                    $('#editInstansiId').val(data.id);
                    var updateUrl = "{{ route('instansi.update', ':id') }}".replace(':id', id);
                    $('#editInstansiForm').attr('action', updateUrl);
                });
            }

            $('#editInstansiForm').on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var action = $(this).attr('action');
                $.ajax({
                    type: "PUT",
                    url: action,
                    data: formData,
                    success: function (response) {
                        $('#editInstansiModal').modal('hide');
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

            window.deleteInstansi = function(button) {
                if(confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                    var id = $(button).data('id');
                    var url = "{{ route('instansi.hapus', ':id') }}".replace(':id', id);

                    $.ajax({
                        type: "DELETE",
                        url: url,
                        success: function(response) {
                            if(response.success) {
                                $('#instansiTable').DataTable().ajax.reload();
                                alert(response.message);
                            } else {
                                alert('Gagal menghapus data instansi');
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
