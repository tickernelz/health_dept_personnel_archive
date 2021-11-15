@extends('layouts.admin')

@push('title', 'Tambah Pengguna')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    <!-- Main Content goes here -->

    <div class="card">
        <div class="card-body">
            <form action="{{ route('pengguna.store') }}" method="post">
                @csrf

                <div class="form-group">
                    <label for="nip">NIP</label>
                    <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" id="nip"
                           placeholder="Masukkan NIP..." autocomplete="off" value="{{ old('nip') }}">
                    @error('nip')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama"
                           placeholder="Masukkan Nama..." autocomplete="off" value="{{ old('nama')}}">
                    @error('nama')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="hp">No. HP</label>
                    <input type="text" class="form-control @error('hp') is-invalid @enderror" name="hp" id="hp"
                           placeholder="Masukkan No. HP..." autocomplete="off" value="{{ old('hp')}}">
                    @error('hp')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="peran">Peran</label>
                    <select id="peran" name="peran" class="form-control @error('peran') is-invalid @enderror">
                        @foreach($roles as $li)
                            <option value="{{ $li->id }}">{{ $li->name }}</option>
                        @endforeach
                    </select>
                    @error('peran')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                           id="email" placeholder="Masukkan Email..." autocomplete="off" value="{{ old('email') }}">
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username"
                           id="username" placeholder="Masukkan Username..." autocomplete="off" value="{{ old('username') }}">
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                           id="password" placeholder="Masukkan Password..." autocomplete="off">
                    @error('password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('pengguna.index') }}" class="btn btn-default">Kembali</a>

            </form>
        </div>
    </div>

    <!-- End of Main Content -->
@endsection

@push('notif')
    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success border-left-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
@endpush
