@extends('layouts.app')
@section('content')
    <div class="container">
        <h5>Pesan</h5>
        <div class="row">
            <div class="col-md-4">
                <div>
                    <h6>Titik Baliho yang Dipesan:</h6>
                    <ol>
                        @forelse ($selectedBalihos as $baliho)
                            <li>{{ $baliho->lokasi_baliho }}</li>
                        @empty
                            <li>No selected billboard points found.</li>
                        @endforelse
                    </ol>
                </div>
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tanggal Event Berlangsung</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control float-right" id="reservation">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Berita/Keterangan/Perihal/Acara/Event</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="event_description">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fotoBaliho">Upload Desain Baliho</label>
                            <input type="file" class="form-control" name="desain_baliho" id="desain_baliho" accept="image/png" required>
                            <ol type="num">
                                <li>Maksimal 5MB.</li>
                                <li>Hanya Support *.png</li>
                            </ol>
                        </div>
                        <div class="form-group">
                            <label for="suratBaliho">Upload Surat Permohonan Fasilitasi</label>
                            <input type="file" class="form-control" name="surat_permohonan" id="surat_permohonan" accept="application/pdf" required>
                            <ol type="num">
                                <li>Maksimal 2MB.</li>
                                <li>Hanya Support *.pdf</li>
                            </ol>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                        <div class="form-group">
                            <label for="telepon">Telepon</label>
                            <input type="text" class="form-control" name="telepon" id="telepon" required>
                        </div>

                        <div class="d-flex">
                            <button type="button" class="btn btn-primary flex-grow-1 mr-2" name="simpanTitikBaliho" id="simpanTitikBaliho">
                                Simpan
                            </button>
                            <button type="button" class="btn btn-success flex-grow-1" name="kembali" id="kembali">
                                Kembali
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Calendar Section -->
            <div class="col-md-8">
                <div class="card card-success">
                    <div class="card-body">
                        <div id="calendar" style="width: 100%; height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <table id="pesan" class="table table-bordered table-hover" responsive>
            <thead>
                <tr>
                    <th>Tanggal Event Mulai</th>
                    <th>Tanggal Event Selesai</th>
                    <th>Lokasi Baliho yang Dipesan</th>
                    <th>Jumlah Baliho yang Dipesan</th>
                    <th>Keterangan Event</th>
                    <th>Nama</th>
                    <th>Telepon</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($details as $detail)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($detail->tgl_mulai_event)->format('ymd') }}</td>
                        <td>{{ \Carbon\Carbon::parse($detail->tgl_selesai_event)->format('ymd') }}</td>
                        <td>{{ $detail->lokasi_baliho_yg_dipesan }}</td>
                        <td>{{ $detail->jml_baliho_yg_dipesan }}</td>
                        <td>{{ $detail->keterangan_event }}</td>
                        <td>{{ $detail->nama_pic_event }}</td>
                        <td>{{ $detail->telp_pic_event }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            let selectedBalihos = [];

            $('#selectedBalihos input:checked').each(function() {
                selectedBalihos.push($(this).data('lokasi-baliho'));
            });



            $('#simpanTitikBaliho').on('click', function() {
                const formData = new FormData();

                // Make sure dates are properly formatted
                let startDate = $('#reservation').data('daterangepicker').startDate.format('YYYY-MM-DD');
                let endDate = $('#reservation').data('daterangepicker').endDate.format('YYYY-MM-DD');

                formData.append('tgl_mulai_event', startDate);
                formData.append('tgl_selesai_event', endDate);
                formData.append('lokasi_baliho_yg_dipesan', selectedBalihos.join(', '));
                formData.append('jml_baliho_yg_dipesan', selectedBalihos.length);
                formData.append('keterangan_event', $('#event_description').val());
                formData.append('desain_baliho', $('#desain_baliho')[0].files[0]);
                formData.append('surat_permohonan', $('#surat_permohonan')[0].files[0]);
                formData.append('name', $('#name').val());
                formData.append('telepon', $('#telepon').val());
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: '{{ route('pesanmesi.simpan-detail-pesan') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alert(response.success || 'Detail pesan berhasil disimpan!');
                        window.location.href = "{{ route('pesanmesi.index') }}";
                    },
                    error: function(xhr) {
                        console.error('Error response: ', xhr.responseText);
                        alert('Error terjadi. Silakan cek console atau log server.');
                    }
                });
            });

            document.getElementById('kembali').addEventListener('click', function() {
                window.location.href = "{{ route('pesanmesi.index') }}";
            });

        $('#reservation').daterangepicker();
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            initialView: 'dayGridMonth'
        });
        calendar.render();
    });
    </script>
@endpush
