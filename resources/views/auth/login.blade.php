<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LIONEL MESI</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('stylesheets/adminlte.min.css')}}">
    {{-- favicon --}}
    <link rel="icon" href="{{ url('images/logo.png') }}">

    <style>
        /* Default Dark Theme */
        body {
            background: linear-gradient(180deg, #000 0%, #333 100%);
            color: #fff;
            font-family: 'Source Sans Pro', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            transition: background 0.5s, color 0.5s;
        }

        .login-box {
            width: 360px;
        }

        .card {
            background-color: #1a1a1a;
            border: 1px solid #444;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.8);
            transition: background-color 0.5s, box-shadow 0.5s;
        }

        .card-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .card-header img {
            width: 70px;
            height: 90px;
            border-radius: 0;
            margin-bottom: 10px;
        }

        .card-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 2px;
        }

        .login-box-msg {
            font-size: 1rem;
            color: #bbb;
        }

        .form-control {
            background-color: #333;
            color: #fff;
            border: 1px solid #555;
            border-radius: 5px;
        }

        .form-control:focus {
            border-color: #666;
            box-shadow: none;
        }

        .btn-primary {
            background-color: #555;
            border-color: #666;
        }

        .btn-primary:hover {
            background-color: #777;
            color: #fff;
        }

        a {
            color: #bbb;
        }

        a:hover {
            color: #fff;
        }

        /* Light Theme */
        body.light {
            background: linear-gradient(180deg, #f9f9f9 0%, #ffffff 100%);
            color: #333;
        }

        body.light .card {
            background-color: #ffffff;
            border: 1px solid #ddd;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        body.light .form-control {
            background-color: #f9f9f9;
            color: #333;
            border: 1px solid #ccc;
        }

        body.light .btn-primary {
            background-color: #007bff;
            border-color: #0056b3;
        }

        body.light a {
            color: #007bff;
        }

        body.light a:hover {
            color: #0056b3;
        }

        /* Slider CAPTCHA Style */
        .slider-container {
            position: relative;
            width: 100%;
            height: 40px;
            margin: 20px 0;
            background-color: #ddd;
            border-radius: 20px;
        }

        .slider-btn {
            position: absolute;
            top: 50%;
            left: 0;
            width: 50px;
            height: 50px;
            background-color: #007bff;
            border-radius: 50%;
            cursor: pointer;
            transform: translateY(-50%);
        }

        .slider-btn.active {
            background-color: #28a745;
        }

        .slider-btn:active {
            transition: 0.1s ease;
        }

        .slider-text {
            font-size: 14px;
            text-align: center;
            margin-top: 10px;
        }

        .error-message {
            color: red;
            font-size: 14px;
            display: none;
        }

        .footer {
            text-align: center;
            margin-top: 10px;
            padding: 5px;
            background-color: #1a1a1a;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            color: #fff;
        }

        .footer-heading {
            font-size: 10pt;
            font-weight: bold;
            letter-spacing: 1px;
            color: #f1c40f; /* Gold color for emphasis */
            margin-bottom: 10px;
        }

        .footer-subheading {
            font-size: 10pt;
            font-weight: 500;
            color: #bbb;
            margin: 5px 0;
        }

        .footer-version {
            font-size: 10pt;
            color: #aaa;
            margin-top: 15px;
            font-style: italic;
        }

        .footer p {
            margin: 0;
            padding: 0;
        }

        /* widget */
        .info-box {
            top: 10px; /* Jarak dari atas */
            left: 10px; /* Jarak dari kiri */
            display: flex;
            align-items: flex-start;
            padding: 10px;
            margin: 0; /* Hilangkan margin bawah agar posisi tetap */
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .info-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="info-box">
                    <p>
                        Total Visitors: {{ $totalVisitors }}</br>
                        Visitors Today: {{ $todayVisitors }}
                    </p>
                </div>
            </div>
            <div class="col">
                <div class="info-box">
                    <p>
                        Total Baliho:</br>
                        Total Terpakai:</br>
                        Total Belum Terpakai:</br>
                    </p>
                </div>
            </div>
            <div class="col">
                <div class="info-box">
                    <p>
                        {{-- No Registerasi Hak Cipta</br>
                        No ISBN</br> --}}
                        Panduan Penggunaan Aplikasi</br>
                        Versi Aplikasi</br>
                        Tahun Pembuatan Aplikasi</br>
                        {{-- Pengembang Aplikasi</br>
                        Kontak Pengembang Aplikasi</br> --}}
                    </p>
                </div>
            </div>
            <div class="col">
                <div class="login-box">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <img src="{{asset('images/logo.png')}}" alt="Logo">
                            <p>LAYANAN INFORMASI ELEKTRONIK <br>MEDIA PUBLIKASI</p>
                            <h1>LIONEL MESI</h1>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="input-group mb-3">
                                    <input type="text" name="username" class="form-control" placeholder="username" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-envelope"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="toggle-password" style="cursor: pointer;">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="slider-container">
                                    <div class="slider-btn" id="slider-btn"></div>
                                    <input type="hidden" id="captcha-input" name="captcha" value="false">
                                </div>
                                <div class="error-message" id="captcha-error">Selesaikan Tantangan</div>
                                <div class="row">
                                    <div class="col">
                                        Grendel e geseren lagi iso yo....
                                        <button type="submit" class="btn btn-primary btn-block" id="login-btn" disabled>LOGIN</button>
                                        <div class="footer">
                                            <p class="footer-subheading">DINAS KOMUNIKASI & DIGITAL</p>
                                            <p class="footer-subheading">PEMERINTAH KOTA SURAKARTA</p>
                                            <p class="footer-version">2024</p>
                                            <p class="footer-version">VERSI 3.0.0</p>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Mode Toggle Button -->
                    <div style="text-align: center; margin-top: 20px;">
                        <button id="toggle-mode" class="btn btn-secondary">MODE TERANG/GELAP</button>
                    </div>
                </div>
            </div>
    </div>

    <!-- jQuery -->
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('javascripts/adminlte.min.js')}}"></script>

    <script>
        const togglePassword = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', () => {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;

            // Toggle the icon between eye and lock
            togglePassword.classList.toggle('fas fa-eye');
            togglePassword.classList.toggle('fas fa-lock');
        });

        const toggleButton = document.getElementById('toggle-mode');
        toggleButton.addEventListener('click', () => {
            // Toggle the body class to switch between light and dark mode
            document.body.classList.toggle('light');

            // Change button text based on the mode
            if (document.body.classList.contains('light')) {
                toggleButton.textContent = 'MODE GELAP';
            } else {
                toggleButton.textContent = 'MODE TERANG';
            }
        });

        const sliderBtn = document.getElementById('slider-btn');
        const loginBtn = document.getElementById('login-btn');
        const captchaError = document.getElementById('captcha-error');
        let isCaptchaComplete = false;

        sliderBtn.addEventListener('mousedown', (e) => {
            const initialX = e.clientX;
            const sliderWidth = document.querySelector('.slider-container').offsetWidth;

            const onMouseMove = (moveEvent) => {
                const moveX = moveEvent.clientX - initialX;
                const newLeft = Math.min(sliderWidth - 50, Math.max(0, moveX));
                sliderBtn.style.left = `${newLeft}px`;
            };

            document.addEventListener('mousemove', onMouseMove);

            document.addEventListener('mouseup', () => {
                document.removeEventListener('mousemove', onMouseMove);
                if (sliderBtn.offsetLeft >= sliderWidth - 50) {
                    isCaptchaComplete = true;
                    loginBtn.disabled = false;
                    sliderBtn.classList.add('active');
                    captchaError.style.display = 'none';  // Hide the error message
                    document.getElementById('captcha-input').value = "true"; // Update hidden input
                } else {
                    isCaptchaComplete = false;
                    loginBtn.disabled = true;
                    sliderBtn.classList.remove('active');
                    captchaError.style.display = 'block'; // Show the error message
                    document.getElementById('captcha-input').value = "false"; // Update hidden input
                }
            });
        });
    </script>
</body>
</html>
