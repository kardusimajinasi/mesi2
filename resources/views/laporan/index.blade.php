@extends('layouts.app')
@push('styles')
<style>
    .bg-primary {
        background-color: #007bff !important;
    }

    .bg-success {
        background-color: #28a745 !important;
    }

    .bg-danger {
        background-color: #dc3545 !important;
    }

    .bg-secondary {
        background-color: #6c757d !important;
    }

    .fc {
        font-size: 0.85rem;
    }

    #calendar {
        width: 80%;
        margin: 0 auto;
        height: 400px;
    }
</style>
@endpush

@section('content')
<h8>Laporan Kinerja Titik Baliho</h8>
<div class="row">
    <div class="col">
        <div class="card card-success">
            <div class="card-body">
                <div id="calendar" style="width: auto" height: 500px;"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="filter-bulan">Filter Bulan</label>
            <select id="filter-bulan" class="form-control">
                <option value="">Semua Bulan</option>
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <table id="kinerjaBaliho" class="table table-bordered table-hover" responsive>
            <thead>
                <tr>
                    <th>Nama Baliho</th>
                    <th>Tanggal Event</th>
                    <th>Nama</th>
                    <th>Instansi</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
{{-- <div class="modal fade" id="eventDetailModal" tabindex="-1" aria-labelledby="eventDetailModalLabel" aria-hidden="true"> --}}
    <div class="modal fade" id="eventDetailModal" tabindex="-1" aria-labelledby="eventDetailModalLabel" aria-hidden="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventDetailModalLabel">Detail Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nama Baliho:</strong> <span id="eventNamaBaliho"></span></p>
                <p><strong>Instansi:</strong> <span id="eventInstansi"></span></p>
                <p><strong>Nama User:</strong> <span id="eventName"></span></p>
                <p><strong>Deskripsi:</strong> <span id="eventDescription"></span></p>
                <p><strong>Durasi:</strong> <span id="eventDuration"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('#kinerjaBaliho').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('laporan.laporan-events') }}',
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100],
            searching: true,
            ordering: true,
            order: [[1, 'desc']],
            columns: [
                { data: 'title', name: 'title' },
                { data: 'tanggal_event', name: 'tanggal_event' },
                { data: 'name', name: 'name' },
                { data: 'instansi', name: 'instansi' },
                { data: 'detail', name: 'detail' }
            ]
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            initialView: 'dayGridMonth',
            events: function(info, successCallback, failureCallback) {
                $.ajax({
                    url: '{{ route('laporan.laporan-events') }}',
                    success: function(data) {
                        var balihoColors = [
                            'bg-primary', 'bg-success', 'bg-danger', 'bg-secondary',
                            'bg-info', 'bg-warning', 'bg-dark', 'bg-light',
                            'bg-pink', 'bg-teal', 'bg-indigo', 'bg-gray',
                            'bg-yellow', 'bg-blue'
                        ];

                        var events = data.data.map(function(item) {
                            var hash = 0;
                            for (var i = 0; i < item.baliho_id.length; i++) {
                                hash = (hash << 5) - hash + item.baliho_id.charCodeAt(i);
                                hash = hash & hash; // Memastikan hash tetap dalam angka 32-bit
                            }

                            var className = balihoColors[Math.abs(hash) % balihoColors.length];

                            console.log('Baliho ID:', item.baliho_id, 'Class Name:', className);

                            return {
                                title: item.title,
                                start: item.start,
                                end: item.end,
                                extendedProps: {
                                    namaBaliho: item.title,
                                    instansi: item.instansi,
                                    name:item.name,
                                    description: item.detail,
                                    duration: `${item.start} - ${item.end}`
                                },
                                classNames: [className]
                            };
                        });
                        successCallback(events);
                    },
                    error: function(xhr) {
                        console.error('Error fetching data:', xhr);
                        failureCallback();
                    }
                });
            },

            eventClick: function(info) {
                console.log(info.event.extendedProps);
                // Set data to modal
                $('#eventNamaBaliho').text(info.event.extendedProps.namaBaliho);
                $('#eventInstansi').text(info.event.extendedProps.instansi);
                $('#eventName').text(info.event.extendedProps.name);
                $('#eventDescription').text(info.event.extendedProps.description);
                $('#eventDuration').text(info.event.extendedProps.duration);

                $('#eventDetailModal').modal('show');
            }
        });
        calendar.render();
    });
</script>
@endpush

