@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Tambah User</h4>

    <form method="POST" action="{{ route('user.store') }}">
        @csrf

        <div class="mb-2">
            <label>Nama</label>
            <input class="form-control" name="name">
        </div>

        <div class="mb-2">
            <label>Email</label>
            <input class="form-control" name="email">
        </div>

        <div class="mb-2">
            <label>Password</label>
            <input type="password" class="form-control" name="password">
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select class="form-control" name="role">
                <option value="admin">Admin</option>
                <option value="pegawai">Pegawai</option>
            </select>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
