@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Data Kode Akun</h1>
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addKodeAkunModal">
        Tambah Data Kode Akun
    </button>
    <button type="button" class="btn btn-warning mb-3" onclick="window.location.href='{{ route('dashboard.sa') }}'">Dashboard (F1)</button>

    <table id="kodeAkunTable" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th width="100px">Aksi</th>
                <th width="50px">No. </th>
                <th>Nama Akun</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <!-- Modals Tambah Data Akun -->
    <div class="modal fade" id="addKodeAkunModal" tabindex="-1" role="dialog" aria-labelledby="addKodeAkunModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addKodeAkunModalLabel">Tambah Data Kode Akun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addKodeAkunForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="namaKodeAkun">Kode Akun</label>
                            <input type="text" class="form-control" name="nama_akun" id="nama_akun" placeholder="Nama Akun" required>
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

    <!-- Edit Data Kode Akun -->
    <div class="modal fade" id="editKodeAkunModal" tabindex="-1" role="dialog" aria-labelledby="editKodeAkunModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editKodeAkunModalLabel">Edit Data Kode Akun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editKodeAkunForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editKodeAkuniId">
                        <div class="form-group">
                            <label for="editKodeAkun">Nama Kode Akun</label>
                            <input type="text" class="form-control" name="nama_akun" id="editnama_akun" placeholder="Nama Kode Akun" required>
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

        var table = $('#kodeAkunTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('kodeakun.data') }}",
                columns: [
                    {
                        data: 'aksi', name: 'aksi', orderable: false, searchable: false
                    },
                    {
                        data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false
                    },
                    {
                        data: 'nama_akun', name: 'nama_akun'
                    },
                ]
            });

            $('#addKodeAkunForm').on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('kodeakun.simpan') }}",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if(response.success) {
                            $('#addKodeAkunForm')[0].reset();
                            $('#addKodeAkunModal').modal('hide');
                            table.ajax.reload(null, false);
                            alert('Data Kode Akun berhasil disimpan');
                        } else {
                            alert('Gagal menyimpan data Kode Akun');
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

            window.editKodeAkun = function(button) {
                var id = $(button).data('id');
                var nama = $(button).data('nama');
                var url = "{{ route('kodeakun.edit', ':id') }}".replace(':id', id);
                $.get(url, function (data) {
                    $('#editKodeAkunModal').modal('show');
                    $('#editnama_akun').val(data.nama_akun);
                    $('#editKodeAkunId').val(data.id);
                    var updateUrl = "{{ route('kodeakun.update', ':id') }}".replace(':id', id);
                    $('#editKodeAkunForm').attr('action', updateUrl);
                });
            }

            $('#editKodeAkunForm').on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var action = $(this).attr('action');
                $.ajax({
                    type: "PUT",
                    url: action,
                    data: formData,
                    success: function (response) {
                        $('#editKodeAkunModal').modal('hide');
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

            window.deleteKodeAkun = function(button) {
                if(confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                    var id = $(button).data('id');
                    var url = "{{ route('kodeakun.hapus', ':id') }}".replace(':id', id);

                    $.ajax({
                        type: "DELETE",
                        url: url,
                        success: function(response) {
                            if(response.success) {
                                $('#kodeAkunTable').DataTable().ajax.reload();
                                alert(response.message);
                            } else {
                                alert('Gagal menghapus data Kode Akun');
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
