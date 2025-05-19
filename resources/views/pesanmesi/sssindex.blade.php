@extends('layouts.app')
@section('content')
    <div class="container">
        <button id="lanjutPesanButton" class="btn btn-primary mb-3" style="display: none; width: 100%;" onclick="openPesanModal()">
            Lanjut Pesan (n/13)
        </button></br>

        <table id="balihoTable" class="table table-bordered table-hover" responsive>
            <thead>
                <tr>
                    <th width="50px" align="center">
                        Pesan Semua
                        <input type="checkbox" id="checkAll">
                    </th>
                    <th class="align-top" >Lokasi </th>
                    <th class="align-top">Foto,<br/> Klik kanan,open image<br/> pada tab baru</th>
                    <th class="align-top">Ukuran </th>
                    <th class="align-top">Layout </th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <!-- Modal for Konfirmasi Pesan -->
    <div class="modal fade" id="pesanModal" tabindex="-1" role="dialog" aria-labelledby="pesanModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pesanModalLabel">Konfirmasi Pesan Baliho</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin ingin pesan titik baliho ini?</p>
                    <ol id="selectedBalihoList"></ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="confirmPesanButton" onclick="confirmPesan()">Konfirmasi Pesan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    let selectedIds = [];
    const totalBaliho = 13;

    const table = $('#balihoTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('baliho.data') }}',
        pageLength: 25,
        lengthMenu: [[25, 50, 100], [25, 50, 100]],
        columns: [
            {
                data: 'id',
                name: 'id',
                render: function (data) {
                    const isChecked = selectedIds.includes(data) ? 'checked' : '';
                    return `<input type="checkbox" class="rowCheckbox" value="${data}" ${isChecked}>`;
                },
                orderable: false,
                searchable: false
            },
            { data: 'lokasi_baliho', name: 'lokasi_baliho' },
            { data: 'foto_baliho', name: 'foto_baliho', render: function(data) {
                return `<img src="${data}" width="100" alt="Foto Baliho">`;
            }},
            { data: 'ukuran_baliho', name: 'ukuran_baliho' },
            { data: 'layout_baliho', name: 'layout_baliho' },
        ],
        rowCallback: function(row, data) {
            if (selectedIds.includes(data.id)) {
                $(row).find('.rowCheckbox').prop('checked', true);
            }
        }
    });

    function toggleLanjutButton() {
        const selectedCount = selectedIds.length;
        if (selectedCount > 0) {
            $('#lanjutPesanButton')
                .show()
                .text(`Lanjut Pesan (${selectedCount}/${totalBaliho})`);
        } else {
            $('#lanjutPesanButton').hide();
        }
    }

    // function toggleLanjutButton() {
    // // Hitung jumlah yang dipilih
    // const selectedCount = selectedIds.length;

    // // Hitung jumlah total dari input jumlahBaliho
    // let totalBaliho = 0;
    // $('.jumlahBaliho').each(function () {
    //     const value = parseInt($(this).val(), 10);
    //     if (!isNaN(value)) {
    //         totalBaliho += value;
    //     }
    // });

    // Tampilkan jumlah dalam tombol
    if (selectedCount > 0) {
        $('#lanjutPesanButton')
            .show()
            .text(`Lanjut Pesan (${totalBaliho}/${selectedCount})`);
    } else {
        $('#lanjutPesanButton').hide();
    }
}


    // $('#checkAll').on('change', function() {
    //     const isChecked = $(this).is(':checked');
    //         $('.rowCheckbox').prop('checked', isChecked);
    //         selectedIds = isChecked ? table.rows({ page: 'current' }).data().map(row => row.id).toArray() : [];
    //         toggleLanjutButton();
    // });

    // $('#balihoTable').on('change', '.rowCheckbox', function() {
    //     const id = $(this).val();
    //     if ($(this).is(':checked')) {
    //         if (!selectedIds.includes(id)) selectedIds.push(id);
    //         } else {
    //         selectedIds = selectedIds.filter(item => item !== id);
    //     }
    //     toggleLanjutButton();
    // });

    $('#checkAll').on('change', function() {
    const isChecked = $(this).is(':checked');
    $('.rowCheckbox').prop('checked', isChecked);
    selectedIds = isChecked ? table.rows({ page: 'current' }).data().map(row => row.id).toArray() : [];
    toggleLanjutButton();
});

$('#balihoTable').on('change', '.rowCheckbox', function() {
    const id = $(this).val();
    if ($(this).is(':checked')) {
        if (!selectedIds.includes(id)) selectedIds.push(id);
    } else {
        selectedIds = selectedIds.filter(item => item !== id);
    }
    toggleLanjutButton();
});


    function openPesanModal() {
        if (selectedIds.length) {
            const balihoList = selectedIds.map(id => {
                const baliho = table.row(function(idx, data) {
                    return data.id === id;
                }).data();

                return baliho ? `<li>${baliho.nama_baliho}</li>` : '';
            }).join('');

            $('#selectedBalihoList').html(balihoList);
            $('#pesanModal').modal('show');
        }
    }

    function confirmPesan() {
        $.ajax({
            url: '{{ route('pesanmesi.pesan') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                balihoIds: selectedIds
            },
            success: function(response) {
                if (response.success) {
                    alert('Pesanan berhasil diproses');
                    window.location.href = '{{ route('pesanmesi.detailpesan') }}';
                } else {
                    alert(response.error || 'Pesanan gagal diproses');
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat mengirim pesanan');
            }
        });
    }

    $(document).ready(function() {
        toggleLanjutButton();
    });
</script>
@endpush
