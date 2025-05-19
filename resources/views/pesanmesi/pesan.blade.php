@extends('layouts.app')
@push('styles')
<style>
    .custom-bg-color-1 {
        background-color: #f8f9fa; /* Warna abu-abu terang */
        padding: 15px;
        border-radius: 5px;
    }

    .custom-bg-color-2 {
        background-color: #e9f7f9; /* Warna biru muda */
        padding: 15px;
        border-radius: 5px;
    }

    .custom-bg-color-3 {
        background-color: #f9f6e9; /* Warna kuning muda */
        padding: 15px;
        border-radius: 5px;
    }

    .uppercase {
        text-transform: uppercase;
    }
</style>
@endpush

@section('content')
    <!-- Error Alert -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {!! session('error') !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif


    <div id="notifBentrokContainer" style="display: none; background-color: #ffcc00; color: #333; padding: 15px; margin: 10px 0;">
        <strong>⛔ Jadwal Bentrok!</strong><br>Silakan ubah tanggal peminjaman.
    </div>

    <!-- Form untuk Pesan -->
    <form action="{{ route('pesanmesi.simpanpesanan') }}" method="POST" enctype="multipart/form-data" id="frm_pesan" novalidate>
        @csrf
        <div class="container">
            <div class="form-group">
                <label for="kodeTransaksi" >Kode Transaksi:</label>
                <input type="text" id="kodeTransaksi" class="form-control" value="{{ $kodeTransaksi }}" readonly >
            </div>
            <div class="row">
                <div class="col">
                    <!-- Tab Card -->
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <!-- Tab Navigation -->
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-one-pilih-lokasi-tab" data-toggle="pill" href="#custom-tabs-one-pilih-lokasi" role="tab">Pilih Lokasi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-isi-data-tab" data-toggle="pill" href="#custom-tabs-one-isi-data" role="tab">Lengkapi Informasi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-rekap-baliho-tab" data-toggle="pill" href="#custom-tabs-one-rekap-baliho" role="tab">Data Transaksi</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <!-- Tab Pilih Lokasi -->
                                <div class="tab-pane fade show active" id="custom-tabs-one-pilih-lokasi" role="tabpanel">
                                    <table id="balihoTable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <center>Semua<br><input type="checkbox" id="checkAll"></center>
                                                </th>
                                                <th>Lokasi</th>
                                                <th>Foto</th>
                                                <th>Ukuran</th>
                                                <th>Layout</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($baliho as $item)
                                                <tr>
                                                    <td align="center">
                                                        <input type="checkbox" class="baliho-checkbox" name="baliho_ids[]" value="{{ $item->id }}">
                                                    </td>
                                                    <td>{{ $item->lokasi_baliho }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm lihat-foto" data-toggle="modal" data-target="#fotoModal" data-foto="{{ Storage::url($item->foto_baliho) }}">Lihat Foto</button>
                                                    </td>
                                                    <td>{{ $item->ukuran_baliho }}</td>
                                                    <td>{{ $item->layout_baliho }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Tab Isi Data -->
                                <div class="tab-pane fade" id="custom-tabs-one-isi-data" role="tabpanel" aria-labelledby="custom-tabs-one-isi-data-tab">
                                    <div class="row">
                                        <div class="col-4 custom-bg-color-1">
                                            <div class="form-group">
                                                <label>Tanggal Event <span style="color: red;">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                        <i class="far fa-calendar-alt"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control float-right" name="reservation" id="reservation">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4 custom-bg-color-2">
                                            <div class="form-group">
                                                <label>Tanggal Surat <span style="color: red;">*</span></label>
                                                <div class="input-group date" id="tgl_surat" data-target-input="nearest">
                                                    <div class="input-group-append" data-target="#tgl_surat" data-toggle="datetimepicker">
                                                        <div class="input-group-text">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" name="tgl_surat" class="form-control datetimepicker-input" data-target="#tgl_surat" value="{{ old('tgl_surat') }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4 custom-bg-color-3">
                                            <label>Aksi</label>
                                            <div class="d-flex">
                                                <button type="button" class="btn btn-primary flex-grow-1 mr-2" name="simpanTitikBaliho" id="simpanTitikBaliho">
                                                    Simpan
                                                </button>
                                                <button type="button" class="btn btn-success flex-grow-1" name="kembali" id="kembali">
                                                    Kembali
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-4 custom-bg-color-1">
                                            <label>Nomor Surat <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control uppercase" name="no_surat" id="no_surat" required>
                                        </div>
                                        <div class="col-4 custom-bg-color-2">
                                            <label>Berita/Keterangan/Perihal/Acara/Event<span style="color: red;">*</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control uppercase" name="keterangan_event" id="keterangan_event">
                                            </div>
                                        </div>
                                        <div class="col-4 custom-bg-color-3">
                                            <label>Perihal Surat <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control uppercase" name="perihal_surat" id="perihal_surat" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4 custom-bg-color-1">
                                            <label for="nama">Nama <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control uppercase" name="name" id="name" required>
                                        </div>
                                        <div class="col-4 custom-bg-color-2">
                                            <label for="telepon">Telepon <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" name="telepon" id="telepon" required>
                                        </div>
                                        <div class="col-4 custom-bg-color-3">
                                            <label for="instansi">Instansi <span style="color: red;">*</span></label>
                                            <select name="instansi" id="instansi" class="form-control select2" required>
                                                @foreach($instansi as $ins)
                                                    <option value="" disabled selected>Pilih Instansi</option>
                                                    <option value="{{ $ins->id }}">{{ $ins->instansi }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4 custom-bg-color-1">
                                            <label>Upload Surat Permohonan Fasilitasi <span style="color: red;">*</span></label>
                                            <input type="file" class="form-control" name="surat_permohonan" id="surat_permohonan" accept="application/pdf" required>
                                            <ol type="num">
                                                <li>Maksimal 2MB.</li>
                                                <li>Hanya Support *.pdf</li>
                                            </ol>
                                        </div>
                                        <div class="col-4 custom-bg-color-2">
                                            <label for="fotoBaliho">Upload Desain Baliho <span style="color: red;">*</span></label>
                                            <input type="file" class="form-control" name="desain_baliho" id="desain_baliho" accept="image/png" required>
                                            <ol type="num">
                                                <li>Maksimal 5MB.</li>
                                                <li>Hanya Support *.png</li>
                                            </ol>
                                        </div>
                                        {{-- <div class="col-4 custom-bg-color-3">
                                            <label for="fotoBaliho">Upload Lepas Baliho <span style="color: red;">*</span></label>
                                            <input type="file" class="form-control" name="upload_lepas_baliho" id="upload_lepas_baliho" accept="image/png" required>
                                            <ol type="num">
                                                <li>Maksimal 5MB.</li>
                                                <li>Hanya Support *.png</li>
                                            </ol>
                                        </div> --}}
                                    </div>
                                </div>

                                <!-- Tab Rekap Data -->
                                <div class="tab-pane fade" id="custom-tabs-one-rekap-baliho" role="tabpanel" aria-labelledby="custom-tabs-one-rekap-baliho-tab">
                                    <table id="rekapBaliho" class="table table-bordered table-hover" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Aksi</th>
                                                <th>No.</th>
                                                <th>Kode</th>
                                                <th>Baliho</th>
                                                <th>Peminjam</th>
                                                <th>Nara Hubung</th>
                                                <th>Instansi</th>
                                                <th>Event</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal Foto -->
    <div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fotoModalLabel">Lihat Foto Baliho</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="" id="fotoBaliho" class="img-fluid" alt="Foto Baliho">
                </div>
            </div>
        </div>
    </div>

    {{-- modals untuk memberi notifikasi ganti tanggal saat jadwal / tanggal sama --}}
    <div class="modal fade" id="notifBentrok" tabindex="-1" aria-labelledby="notifBentrokModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notifBentrokModalLabel">GANTI TANGGAL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>


    {{-- modal detail --}}
    <div class="modal fade" id="detailRekap" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Rekap Baliho</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Tanggal Mulai:</strong> <span id="viewTglMulai"></span></p>
                    <p><strong>Tanggal Selesai:</strong> <span id="viewTglSelesai"></span></p>
                    <p><strong>No. Surat:</strong> <span id="viewNoSurat"></span></p>
                    <p><strong>Perihal:</strong> <span id="viewPerihal"></span></p>
                    <p><strong>Tanggal Surat:</strong> <span id="viewTglSurat"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal form upload foto lepas baliho --}}
    <div class="modal fade" id="uploadLepasModal" tabindex="-1" aria-labelledby="uploadLepasModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="uploadLepasForm" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadLepasModalLabel">Upload Foto Lepas Baliho</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="pesan_id" id="pesan_id">
                        <div class="mb-3">
                            <label for="foto_lepas" class="form-label">Pilih Foto (bisa banyak)</label>
                            <input class="form-control" type="file" id="foto_lepas" name="foto_lepas[]" accept="image/*" multiple>
                        </div>
                        <div class="row" id="preview_foto"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Upload</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#rekapBaliho').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('pesanmesi.rekapbaliho') }}",
            columns: [
                {
                    data: 'aksi', name: 'aksi', orderable: false, searchable: false
                },
                {
                    data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false
                },
                {
                    data: 'kode_trans', name: 'kode_trans'
                },
                {
                    data: 'baliho_ids', name: 'baliho_ids'
                },
                {
                    data: 'nama_pic', name: 'nama_pic',
                },
                {
                    data: 'tlp_pic', name: 'tlp_pic'
                },
                {
                    data: 'instansi', name: 'instansi'
                },
                {
                    data: 'keterangan_event', name: 'keterangan_event'
                },
            ]
        });

        let selectedBalihoIds = [];

        function updateSelectedBalihoIds() {
            selectedBalihoIds = [];
            $('.baliho-checkbox:checked').each(function () {
                selectedBalihoIds.push($(this).val());
            });
        }

        $('.baliho-checkbox').on('change', function () {
            updateSelectedBalihoIds();

            const allChecked = $('.baliho-checkbox').length === $('.baliho-checkbox:checked').length;
            $('#checkAll').prop('checked', allChecked);
        });

        document.getElementById('frm_pesan').addEventListener('submit', function (e) {
            e.preventDefault();
            updateSelectedBalihoIds();

            if (selectedBalihoIds.length === 0) {
                alert('Silakan pilih minimal satu baliho.');
                return;
            }

            const tanggalMulai = $('#reservation').data('daterangepicker').startDate.format('YYYY-MM-DD');
            const tanggalSelesai = $('#reservation').data('daterangepicker').endDate.format('YYYY-MM-DD');

            const noSurat = $('#no_surat').val();
            if (!noSurat) {
                alert('Nomor Surat harus diisi!');
                return;
            }

            const tglSurat = $('#tgl_surat').val();
            if (!tglSurat) {
                alert('Tanggal Surat harus diisi!');
                return;
            }

            const keteranganEvent = $('#keterangan_event').val();
            if (!keteranganEvent) {
                alert('Keterangan Event harus diisi!');
                return;
            }

            $.ajax({
                url: '{{ route("pesanmesi.cekTanggal") }}',
                method: 'POST',
                cache: false,
                data: {
                    baliho_ids: selectedBalihoIds,
                    tanggal_mulai: tanggalMulai,
                    tanggal_selesai: tanggalSelesai,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.bentrok) {
                        console.error("Bentrokan ditemukan:", response.details);

                        let bentrokDetails = response.details.map(detail =>
                        `⚠️ <strong>${detail.nama_baliho}</strong> di lokasi <strong>${detail.lokasi}</strong> sudah dipesan pada <strong>${detail.tanggal}</strong>.`
                        ).join('<br>');

                        $('#notifBentrokContainer').html(`
                            <button type="button" class="close" onclick="$('#notifBentrokContainer').hide();" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>⛔ Jadwal Bentrok!</strong><br>Silakan ubah tanggal peminjaman:<br>${bentrokDetails}
                        `).fadeIn();

                    } else {
                        $('#frm_pesan')[0].submit();
                    }
                },
                error: function (xhr, status, error) {
                    // console.error("Error:", error);
                    alert("Terjadi kesalahan. Silakan coba lagi.");
                }
            });
        });

        $('#instansi').select2({
            placeholder: 'Pilih Instansi',
            allowClear: true,
        });

        $('#tgl_surat').datetimepicker({
            format: 'YYYY-MM-DD',
        });

        $('#reservation').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD',
            }
        });

        $('#checkAll').on('change', function () {
            $('.baliho-checkbox').prop('checked', this.checked);
            updateSelectedBalihoIds();
        });

        $('.lihat-foto').on('click', function () {
            const foto = $(this).data('foto');
            $('#fotoBaliho').attr('src', foto);
        });

        $('#simpanTitikBaliho').on('click', function () {
            if (confirm('Apakah Anda yakin ingin menyimpan data?')) {
                $('#frm_pesan').submit();
            }
        });

        window.detailRekap = function(button) {
            const id = $(button).data('id');
            const tglMulai = button.getAttribute('data-tglmulai') || 'N/A';
            const tglSelesai = button.getAttribute('data-tglselesai') || 'N/A';
            const noSurat = button.getAttribute('data-nosurat') || 'N/A';
            const perihal = button.getAttribute('data-perihal') || 'N/A';
            const tglSurat = button.getAttribute('data-tglsurat') || 'N/A';

            document.getElementById('viewTglMulai').textContent = tglMulai;
            document.getElementById('viewTglSelesai').textContent = tglSelesai;
            document.getElementById('viewNoSurat').textContent = noSurat;
            document.getElementById('viewPerihal').textContent = perihal;
            document.getElementById('viewTglSurat').textContent = tglSurat;

            $('#detailRekap').modal('show');
        }

        $(document).on('click', '.hapus-btn', function () {
            const id = $(this).data('id');
            if (confirm('Yakin ingin menghapus data ini?')) {
                $.ajax({
                    url: `/pesanmesi/hapusorderbaliho/${id}`,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function (res) {
                        table.ajax.reload();
                    }
                });
            }
        });

        // document.querySelectorAll('.hapus-btn').forEach(button => {
        //     button.addEventListener('click', function() {
        //         let id = this.getAttribute('data-id');

        //         // Pindah ke tab isi data jika ada validasi yang menghalangi
        //         document.querySelector('#custom-tabs-one-isi-data-tab').click();

        //         if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
        //             fetch(`/pesanmesi/hapusorderbaliho/${id}`, {
        //                 method: 'DELETE',
        //                 headers: {
        //                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        //                     'Content-Type': 'application/json'
        //                 }
        //             })
        //             .then(response => response.json())
        //             .then(data => {
        //                 if (data.success) {
        //                     alert(data.success);
        //                     location.reload(); // Refresh halaman setelah menghapus
        //                 } else {
        //                     alert(data.error);
        //                 }
        //             })
        //             .catch(error => console.error('Error:', error));
        //         }
        //     });
        // });
    });
</script>
@endpush
