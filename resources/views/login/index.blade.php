@extends('layout.auth')

@section('content')
<style>
    /* Gaya untuk latar belakang */
    body {
        background-image: url('/basado.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 100vh;
        overflow: hidden; /* Hilangkan scroll */
    }

    /* Elemen untuk efek blur pada latar belakang */
    .blur-background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('/basado.jpg');
        background-size: cover;
        background-position: center;
        filter: blur(2px); /* Blur pada latar belakang */
        z-index: -1; /* Agar tetap di belakang konten */
    }

    /* Kartu login dengan efek blur */
    .card {
        backdrop-filter: blur(20px); /* Efek blur pada kartu */
        background: rgba(255, 255, 255, 0.2); /* Warna transparan untuk kartu */
        border-radius: 8px; /* Sudut bulat pada kartu */
        border: 1px solid rgba(255, 255, 255, 0.3); /* Garis batas yang halus */
    }
    .btn-white {
    background-color: white;
    color: black;
    border: 1px solid #ccc;
    }

    .btn-white:hover {
        background-color: #f0f0f0; /* Warna sedikit lebih gelap saat di-hover */
    }

</style>

<!-- Elemen latar belakang yang buram -->
<div class="blur-background"></div>

<!-- Kontainer dan Kartu Login -->
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
        <div class="text-center mb-4">
            <h3 class="fw-bold">Hi, Welcome Back</h3>
        </div>
        {{-- @if(Session::has('error'))
            <div class="alert alert-danger" role="alert" style="text-align: center">
                {{ Session::get('error') }}
            </div>
        @endif <!-- Tambahkan @endif di sini untuk menutup kondisi --> --}}

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" required value="{{ old('email') }}" autofocus>
                @error('email')
                    <div class="invalid-feedback">Email tidak terdaftar</div>
                @enderror
            </div>
            <div class="mb-3"> 
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>
            </div>
            <button type="submit" class="btn btn-white w-100">Log In</button>
        </form>
    </div>
</div>
@endsection
