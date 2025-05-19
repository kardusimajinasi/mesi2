@extends('layouts.app')
@section('content')
    <section class="content">
        <h2>Selamat Datang, {{ Auth::user()->username }} | Level: {{ Auth::user()->level->level }}</h2>

        <div class="row">
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Titik Baliho:</span>
                        <span class="info-box-number"><h1>{{ $totalBaliho }}</h1></span>
                        <button name="totalBaliho" id="totalBaliho">Tekan F4 untuk detail</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Titik Baliho Terpakai</span>
                        <span class="info-box-number"><h1>{{ $terpakaiBaliho }}</h1></span>
                        <button name="terpakaiBaliho" id="terpakaiBaliho">Tekan F6 untuk detail</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="far fa-bookmark"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Titik Baliho Tersedia</span>
                        <span class="info-box-number">{{ $tersediaBaliho }}</span>
                        <button name="rakanggoBaliho" id="rakanggoBaliho">Tekan F3 untuk detail</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fas fa-greater-than-equal"></i></span>
                    <div class="info-box-content">
                        <a href="#">Baliho</a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fas fa-greater-than-equal"></i></span>
                    <div class="info-box-content">
                        <a href="#">Spanduk</a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fas fa-greater-than-equal"></i></span>
                    <div class="info-box-content">
                        <a href="#">Running Teks</a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fas fa-greater-than-equal"></i></span>
                    <div class="info-box-content">
                        <a href="#">Siar Keliling</a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fas fa-greater-than-equal"></i></span>
                    <div class="info-box-content">
                        <a href="#">Siar Radio</a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fas fa-greater-than-equal"></i></span>
                    <div class="info-box-content">
                        <a href="#">Media Sosial</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal F1 -->
    <div class="modal fade" id="modalF1" tabindex="-1" aria-labelledby="modalF1Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalF1Label">Total Titik Baliho</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal F2 -->
    <div class="modal fade" id="modalF2" tabindex="-1" aria-labelledby="modalF2Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalF2Label">Modal F2</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Ini adalah modal untuk F2.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal F3 -->
    <div class="modal fade" id="modalF3" tabindex="-1" aria-labelledby="modalF3Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalF3Label">Modal F3</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Ini adalah modal untuk F3.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('keydown', function(event) {
        if (event.key === 'F4') {
            window.location.href = '{{ route('baliho.index') }}';
        } else if (event.key === 'F6') {
            window.location.href = '{{ route('laporan.index') }}';
        } else if (event.key === '#') {
            window.location.href = '{{ route('laporan.index') }}';
        }
    });
</script>
@endpush
