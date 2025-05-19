@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Data level</h1>
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addlevelModal">
        Tambah Data level
    </button>

    <table id="levelTable" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th width="100px">Aksi</th>
                <th width="50px">No. </th>
                <th>level</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <!-- Modals Tambah Data level -->
    <div class="modal fade" id="addlevelModal" tabindex="-1" role="dialog" aria-labelledby="addlevelModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addlevelModalLabel">Tambah Data level</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addlevelForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="namalevel">Level</label>
                            <input type="text" class="form-control" name="level" id="level" placeholder="Nama level" required>
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

    <!-- Edit Data level -->
    <div class="modal fade" id="editlevelModal" tabindex="-1" role="dialog" aria-labelledby="editlevelModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editlevelModalLabel">Edit Data level</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editlevelForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editlevelId">
                        <div class="form-group">
                            <label for="editNamalevel">Level</label>
                            <input type="text" class="form-control" name="level" id="editNamaLevel" placeholder="Level" required>
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

        var table = $('#levelTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('level.data') }}",
                columns: [
                    {
                        data: 'aksi', name: 'aksi', orderable: false, searchable: false
                    },
                    {
                        data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false
                    },
                    {
                        data: 'level', name: 'level'
                    },
                ]
            });

            $('#addlevelForm').on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('level.simpan') }}",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if(response.success) {
                            $('#addlevelForm')[0].reset();
                            $('#addlevelModal').modal('hide');
                            table.ajax.reload(null, false);
                            alert('Data level berhasil disimpan');
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

            window.editLevel = function(button) {
                var id = $(button).data('id');
                var url = "{{ route('level.edit', ':id') }}".replace(':id', id);
                $.get(url, function (data) {
                    $('#editlevelModal').modal('show');
                    $('#editNamaLevel').val(data.level);
                    $('#editlevelId').val(data.id);
                    var updateUrl = "{{ route('level.update', ':id') }}".replace(':id', id);
                    $('#editlevelForm').attr('action', updateUrl);
                });
            }

            $('#editlevelForm').on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var action = $(this).attr('action');
                $.ajax({
                    type: "PUT",
                    url: action,
                    data: formData,
                    success: function (response) {
                        $('#editlevelModal').modal('hide');
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

            window.deleteLevel = function(button) {
                if(confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                    var id = $(button).data('id');
                    var url = "{{ route('level.hapus', ':id') }}".replace(':id', id);

                    $.ajax({
                        type: "DELETE",
                        url: url,
                        success: function(response) {
                            if(response.success) {
                                $('#levelTable').DataTable().ajax.reload();
                                alert(response.message);
                            } else {
                                alert('Gagal menghapus data level');
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
