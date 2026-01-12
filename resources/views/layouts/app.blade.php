<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIM Desa - Sidodadi</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-landmark me-2"></i>SIM Desa
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <!-- Menu kiri -->
                <ul class="navbar-nav me-auto">
                    @auth
                        @if(auth()->user()->role == 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admins.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.surat.index') }}">Surat</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.pengaduan.index') }}">Pengaduan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.program-bantuan.index') }}">Bantuan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.biodata-warga.index') }}">Data Warga</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-warning fw-bold"
                                    href="{{ route('admin.statistik.index') }}">Statistik</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-info fw-bold" href="{{ route('admin.keuangan.index') }}">
                                    <i class="fas fa-wallet me-1"></i> Keuangan
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('users.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('surat-pengajuan.index') }}">Surat</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('pengaduan.index') }}">Pengaduan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('program-bantuan.index') }}">Bantuan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('statistik.index') }}">Statistik</a>
                            </li>
                        @endif
                    @endauth
                </ul>

                <!-- Menu kanan -->
                <ul class="navbar-nav ms-auto align-items-center">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="btn btn-primary btn-sm text-white" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                Halo, {{ auth()->user()->name ?? 'Warga' }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                @if(auth()->user()->role !== 'admin')
                                    <li>
                                        <a class="dropdown-item" href="{{ route('users.profile') }}">
                                            <i class="fas fa-user-circle me-2"></i>Lihat Profil
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>

            </div>
        </div>
    </nav>

    <!-- Spacer for fixed navbar -->
    <div style="height: 80px;"></div>

    <!-- KONTEN HALAMAN -->
    <main class="@yield('main_class', 'container py-4')" style="min-height: 80vh;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Pemerintah Desa Sidodadi. All rights reserved.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
</body>

</html>