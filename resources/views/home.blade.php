<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Resmi Desa Sidodadi</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Navbar Transparan */
        .navbar {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(6px);
            transition: background 0.3s ease;
        }

        .navbar-brand img {
            width: 50px;
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            background: url('/images/gambar_balai_desa_sidodadi.jpg') center/cover no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: white;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);
            text-align: center;
        }

        .hero h1 {
            font-weight: 700;
            font-size: 3rem;
        }

        .hero h2 {
            font-weight: 700;
            font-size: 2.5rem;
        }

        .hero p {
            font-size: 1.1rem;
            margin-top: 15px;
        }

        /* Hover efek menu */
        .nav-link:hover {
            color: #008000 !important;
            /* hijau desa */
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
                <img src="/images/gambar_logo_sidoarjo.png" alt="Logo Desa" class="me-2">
                <div>Desa Sidodadi<br>
                    <small class="text-muted">Kabupaten Sidoarjo</small>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav fw-semibold">
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Profil Desa</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <h1>Selamat Datang</h1>
        <h2>Website Resmi Desa Sidodadi</h2>
        <p>Sumber informasi terbaru tentang pemerintahan di Desa Sidodadi</p>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <title>Homepage</title>
    <style>
        .btn {
            padding: 10px 20px;
            margin: 5px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .user-btn {
            background-color: blue;
        }

        .admin-btn {
            background-color: green;
        }
    </style>
    </head>

</html>