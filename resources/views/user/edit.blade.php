@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Edit User</h4>

    <form method="POST" action="{{ route('user.update',$user->id) }}">
        @csrf @method('PUT')

        <div class="mb-2">
            <label>Nama</label>
            <input class="form-control" name="name" value="{{ $user->name }}">
        </div>

        <div class="mb-2">
            <label>Email</label>
            <input class="form-control" name="email" value="{{ $user->email }}">
        </div>

        <div class="mb-2">
            <label>Password (opsional)</label>
            <input type="password" class="form-control" name="password">
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select class="form-control" name="role">
                <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
                <option value="pegawai" {{ $user->role=='pegawai'?'selected':'' }}>Pegawai</option>
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
