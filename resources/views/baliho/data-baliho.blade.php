@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Data Baliho</h1>
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addBalihoModal">
        Tambah Data Baliho
    </button>
    <button type="button" class="btn btn-warning mb-3" onclick="window.location.href='{{ route('dashboard.sa') }}'">Dashboard (F1)</button>

    <table id="balihoTable" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th width="100px">Aksi</th>
                <th width="50px">No. </th>
                <th>Nama Baliho</th>
                <th>Lokasi Baliho</th>
                <th>Foto Baliho</th>
                <th>Ukuran Baliho</th>
                <th>Layout Baliho</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <!-- Modals Tambah Data Baliho -->
    <div class="modal fade" id="addBalihoModal" tabindex="-1" role="dialog" aria-labelledby="addBalihoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBalihoModalLabel">Tambah Data Baliho</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addBalihoForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="namaBaliho">Nama Baliho</label>
                            <input type="text" class="form-control" name="nama_baliho" placeholder="Nama Baliho" required>
                        </div>
                        <div class="form-group">
                            <label for="lokasiBaliho">Lokasi Baliho</label>
                            <input type="text" class="form-control" name="lokasi_baliho" placeholder="Lokasi Baliho" required>
                        </div>
                        <div class="form-group">
                            <label for="fotoBaliho">Foto Baliho</label>
                            <input type="file" class="form-control" name="foto_baliho" id="fotoBaliho" accept=" image/png" required>
                            <ol type="num">
                                <li>Maksimal 2MB.</li>
                                <li>Hanya Support *.png</li>
                            </ol>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="ukuranBaliho">Ukuran Baliho</label>
                                <select class="custom-select form-control-border" name="ukuran_baliho" id="ukuran_baliho" required>
                                    <option value="4M x 8M">4M x 8M</option>
                                    <option value="4M x 6M">4M x 6M</option>
                                    <option value="3M x 4M">3M x 4M</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="layoutBaliho">Layout Baliho</label>
                                <select class="custom-select form-control-border" name="layout_baliho" id="layout_baliho" required>
                                    <option value="Vertikal">Vertikal</option>
                                    <option value="Horizontal">Horizontal</option>
                                </select>
                            </div>
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

    <!-- Modals Edit Data Baliho -->
    <div class="modal fade" id="editBalihoModal" tabindex="-1" role="dialog" aria-labelledby="editBalihoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBalihoModalLabel">Edit Data Baliho</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editBalihoForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="id" id="editBalihoId">
                    <div class="form-group">
                        <label for="editNamaBaliho">Nama Baliho</label>
                        <input type="text" class="form-control" name="nama_baliho" id="editNamaBaliho" required>
                    </div>
                    <div class="form-group">
                        <label for="editLokasiBaliho">Lokasi Baliho</label>
                        <input type="text" class="form-control" name="lokasi_baliho" id="editLokasiBaliho" required>
                    </div>
                    <div class="form-group">
                        <label for="editFotoBaliho">Foto Baliho</label>
                        <input type="file" class="form-control" name="foto_baliho" id="editFotoBaliho" accept="image/png">
                        <img id="editFotoPreview" src="" alt="Foto Baliho" style="max-width: 100%; display: none;" />
                        <ol type="num">
                            <li>Maksimal 2MB.</li>
                            <li>Hanya Support *.png</li>
                        </ol>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="ukuranBaliho">Ukuran Baliho</label>
                            <select class="custom-select form-control-border" name="ukuran_baliho" id="edit_ukuran_baliho" required>
                                <option value="4M x 8M">4M x 8M</option>
                                <option value="4M x 6M">4M x 6M</option>
                                <option value="3M x 4M">3M x 4M</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fotoBaliho">Layout Baliho</label>
                            <select class="custom-select form-control-border" name="layout_baliho" id="edit_layout_baliho" required>
                                <option value="Vertikal">Vertikal</option>
                                <option value="Horizontal">Horizontal</option>
                            </select>
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
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#balihoTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('baliho.data') }}",
                columns: [
                    {
                        data: 'aksi', name: 'aksi', orderable: false, searchable: false
                    },
                    {
                        data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false
                    },
                    {
                        data: 'nama_baliho', name: 'nama_baliho'
                    },
                    {
                        data: 'lokasi_baliho', name: 'lokasi_baliho'
                    },
                    {
                        data: 'foto_baliho', name: 'foto_baliho',
                    },
                    {
                        data: 'ukuran_baliho', name: 'ukuran_baliho'
                    },
                    {
                        data: 'layout_baliho', name: 'layout_baliho'
                    },
                ]
        });

        $('#addBalihoForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('baliho.simpan') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if(response.success) {
                        $('#addBalihoForm')[0].reset();
                        $('#addBalihoModal').modal('hide');
                        table.ajax.reload(null, false);
                        alert('Data baliho berhasil disimpan');
                    } else {
                        alert('Gagal menyimpan data baliho');
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

        window.editBaliho = function (button) {
            var id = $(button).data('id');

            $.get("/baliho/" + id + "/edit", function (data) {
                if (data.data) {
                    $('#editBalihoId').val(data.data.id);
                    $('#editNamaBaliho').val(data.data.nama_baliho);
                    $('#editLokasiBaliho').val(data.data.lokasi_baliho);

                    $('#editUkuranBaliho').val(data.data.ukuran_baliho);
                    $('#editLayoutBaliho').val(data.data.layout_baliho);

                    // Handle photo preview
                    if (data.data.foto_baliho) {
                        $('#editFotoPreview').attr('src', '/storage/' + data.data.foto_baliho).show();
                    } else {
                        $('#editFotoPreview').hide();
                    }

                    $('#editBalihoModal').modal('show');
                } else {
                    alert('Data tidak ditemukan');
                }
            });
        };


        $('#editBalihoForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            var id = $('#editBalihoId').val();

            $.ajax({
                url: "/baliho/" + id,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                        $('#editBalihoForm')[0].reset();
                        $('#editBalihoModal').modal('hide');
                        table.ajax.reload(null, false);
                        alert('Data baliho berhasil diperbarui');
                    } else {
                        alert('Gagal memperbarui data baliho');
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

        window.deleteBaliho = function (button) {
            var id = $(button).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    url: "/baliho/" + id,
                    type: 'DELETE',
                    success: function (response) {
                        if (response.success) {
                            table.ajax.reload(null, false);
                            alert('Data baliho berhasil dihapus');
                        } else {
                            alert('Gagal menghapus data baliho');
                        }
                    },
                    error: function (xhr) {
                        alert('Terjadi kesalahan saat menghapus data');
                    }
                });
            }
        };
    });
</script>
@endpush
