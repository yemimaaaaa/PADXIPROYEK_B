<!DOCTYPE html>
<html lang="en">
@extends('layout.sidebar')
@section('content')
    <body>
        <div class="container mt-3">
            <h2>Data Member</h2>
            <div class="row align-items-center mb-3">
                <div class="col text-start">
                    <form class="d-flex" action="{{ route('member.search') }}" method="GET" style="justify-content: flex-start;">
                        <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search" style="width: 200px;" value="{{ request('query') }}">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
                <div class="col text-end">
                    <button type="button" class="btn btn-primary">Create Member</button>
                </div>
            </div>
            <div class="container text-center">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-5 g-4">
                    @foreach($members as $index => $member)
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ $member->foto }}" class="card-img-top" alt="Foto Member" style="height: 150px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $member->nama }}</h5>
                                    <p class="card-text">
                                        No. Telepon: {{ $member->no_hp }} <br>
                                        Periode Awal: {{ $member->periode_awal }} <br>
                                        Periode Akhir: {{ $member->periode_akhir }} <br>
                                        Level Member: {{ $member->id_level_member }}
                                    </p> </div>
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
                    @endforeach
                </div>
            </div>
        </div>
    </body>
@endsection
</html>