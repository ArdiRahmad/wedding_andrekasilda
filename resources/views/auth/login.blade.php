@extends('adminlte::auth.login')

@section('css')
<style>
    /* Mengubah background halaman login */
    body.login-page {
        /* Menggunakan gambar gratis dari Unsplash (Tema Wedding) */
        background: url('https://images.unsplash.com/photo-1519225421980-715cb0215aed?q=80&w=2070&auto=format&fit=crop') no-repeat center center fixed !important;
        background-size: cover !important;
    }

    /* Efek Kaca (Glassmorphism) untuk kotak login */
    .login-box {
        background: rgba(255, 255, 255, 0.7) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 15px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }

    /* Menghilangkan background putih bawaan card AdminLTE */
    .login-box .card {
        background: transparent !important;
        border: none;
        box-shadow: none;
    }

    /* Mengubah warna teks dan judul */
    .login-logo a {
        color: #d81b60 !important; /* Warna Pink elegan */
        font-family: 'Georgia', serif;
        font-weight: bold;
        font-size: 2.2rem;
        text-shadow: 2px 2px 4px rgba(255,255,255,0.8);
    }

    .login-box-msg {
        color: #333;
        font-weight: 500;
    }

    /* Mempercantik tombol login */
    .btn-primary {
        background-color: #d81b60;
        border-color: #d81b60;
        border-radius: 25px; /* Tombol membulat */
        font-weight: bold;
        transition: 0.3s;
    }

    .btn-primary:hover {
        background-color: #ad144b;
        border-color: #ad144b;
        transform: translateY(-2px);
    }

    /* Mempercantik input field */
    .form-control {
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.9);
    }
</style>
@stop

@section('auth_header')
    <p class="login-box-msg">Silakan masuk untuk mengelola daftar tamu & undangan pernikahan.</p>
@stop