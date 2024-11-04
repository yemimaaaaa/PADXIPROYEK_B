<!DOCTYPE html>
<html lang="en">
@extends('layout.sidebar')
@section('content')
    <body>
        <div class="container mt-3">
            <h2>Profile Member</h2>
            <div class="card">
                <img src="{{ $member->foto }}" class="card-img-top" alt="Foto Member" style="height: 150px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $member->nama }}</h5>
                    <p class="card-text">
                        No. Telepon: {{ $member->no_hp }} <br>
                        Periode Awal: {{ $member->periode_awal }} <br>
                        Periode Akhir: {{ $member->periode_akhir }} <br>
                        Level Member: {{ $member->id_level_member }}
                    </p>
                </div>
                <div class="card-footer">
                    <a href="/member/{{ $member->id_member }}/edit" class="btn btn-outline-primary btn-sm me-2">Edit</a>
                    <form action="/member/{{ $member->id_member }}/delete" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
@endsection
</html>
