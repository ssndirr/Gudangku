@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Data User</h4>

    <a href="{{ route('user.create') }}" class="btn btn-primary mb-3">
        Tambah User
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
        @foreach($users as $u)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ ucfirst($u->role) }}</td>
            <td>
                <a href="{{ route('user.edit',$u->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('user.destroy',$u->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Hapus user?')" class="btn btn-danger btn-sm">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
