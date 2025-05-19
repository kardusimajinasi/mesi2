<a href="#" class="brand-link">
    <img src="{{asset('images/AdminLTELogo.png')}}" class="brand-image ">
    <span class="brand-text font-weight-light">Mesi</span>
</a>

<div class="sidebar">
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
                    <p>Poke me<i class="right fas fa-angle-left"></i></p>
                </a>
                @auth
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('dashboard.sa') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>(F1) Dashboard </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pesanmesi.pesan') }}" class="nav-link">
                            <i class="fas fa-concierge-bell"></i>
                            <p>(F2) Pesan Mesi </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('instansi.index') }}" class="nav-link">
                            <i class="fas fa-building"></i>
                            <p>(F3) Instansi </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('level.index') }}" class="nav-link">
                        <i class="fab fa-blackberry"></i>
                        <p>Level</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('baliho.index') }}" class="nav-link">
                            <i class="fas fa-building"></i>
                            <p>(F4) Baliho </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.index') }}" class="nav-link">
                            <i class="fas fa-users"></i>
                            <p>(F5) User </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('laporan.index') }}" class="nav-link">
                            <i class="fas fa-th-list"></i>
                            <p>(F6) Laporan </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('kodeakun.index') }}" class="nav-link">
                            <i class="fas fa-truck-monster"></i>
                            <p>Kode Akun </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('analisislog.analisis-log') }}" class="nav-link">
                            <i class="fab fa-slack"></i>
                            <p>Analisis Log</p>
                        </a>
                    </li>
                </ul>
                @endauth
            </li>
        </ul>
    </nav>
</div>

<script>
    document.addEventListener('keydown', function(event) {
        if (event.key === 'F1') {
            event.preventDefault();
            window.location.href = '{{ route('dashboard.sa') }}';
        } else if (event.key === 'F2') {
            event.preventDefault();
            window.location.href = '{{ route('pesanmesi.pesan') }}';
        } else if (event.key === 'F3') {
            event.preventDefault();
            window.location.href = '{{ route('instansi.index') }}';
        }else if (event.key === 'F4') {
            event.preventDefault();
            window.location.href = '{{ route('baliho.index') }}';
        }else if (event.key === 'F5') {
            event.preventDefault();
            window.location.href = '{{ route('user.index') }}';
        }else if (event.key === 'F6') {
            event.preventDefault();
            window.location.href = '{{ route('laporan.index') }}';
        }
    });
</script>

