@extends('layouts.admin')

@push('title', 'List Pengguna')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    <!-- Main Content goes here -->

    <a href="{{ route('pengguna.create') }}" class="btn btn-primary mb-3">Tambah Pengguna</a>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Data</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered text-center" id="table">
                <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No. HP</th>
                    <th>Peran</th>
                    <th>Username</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration ?? 'Kosong' }}</td>
                        <td>{{ $user->nip ?? 'Kosong' }}</td>
                        <td>{{ $user->nama ?? 'Kosong' }}</td>
                        <td>{{ $user->email ?? 'Kosong' }}</td>
                        <td>{{ $user->hp ?? 'Kosong' }}</td>
                        <td>{{ $user->roles->first()->name ?? 'Kosong' }}</td>
                        <td>{{ $user->username ?? 'Kosong' }}</td>
                        <td>
                            <form action="{{ route('pengguna.destroy', $user->id) }}" method="post">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('pengguna.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Yakin Mau Dihapus?')">Delete
                                    </button>
                                </div>
                            </form>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <!-- End of Main Content -->
@endsection

@push('notif')
    @if(session('errors'))
        <div class="alert alert-danger border-left-success alert-dismissible fade show"
             role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            <strong>Aduh!</strong> Ada yang error nih :
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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

@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.0.1/b-colvis-2.0.1/b-html5-2.0.1/b-print-2.0.1/date-1.1.1/r-2.2.9/sc-2.0.5/sp-1.4.0/sl-1.3.3/datatables.min.css"/>
@endpush
@push('js')

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.0.1/b-colvis-2.0.1/b-html5-2.0.1/b-print-2.0.1/date-1.1.1/r-2.2.9/sc-2.0.5/sp-1.4.0/sl-1.3.3/datatables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#table').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/id.json'
                }
            });
        });
    </script>
@endpush
