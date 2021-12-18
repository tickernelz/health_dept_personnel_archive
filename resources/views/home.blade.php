@extends('layouts.admin')

@push('title', 'Dashboard')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Dashboard') }}</h1>

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

    <div class="row">

        <!-- Total Surat -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Surat</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $widget['totalsurat'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-mail-bulk fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div
                                class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{ __('Pengguna') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $widget['users'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Surat Masuk -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('suratmasuk.index') }}" style="text-decoration: none">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div
                                    class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ __('Surat Masuk') }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $widget['suratmasuk'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-envelope fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Surat Keluar -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('suratkeluar.index') }}" style="text-decoration: none">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div
                                    class="text-xs font-weight-bold text-success text-uppercase mb-1">{{ __('Surat Keluar') }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $widget['suratkeluar'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-envelope-open fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Cuti Tahunan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('cutitahunan.index') }}" style="text-decoration: none">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Cuti Tahunan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $widget['cutitahunan'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Cuti Melahirkan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('cutimelahirkan.index') }}" style="text-decoration: none">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div
                                    class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{ __('Cuti Melahirkan') }}</div>
                                <div
                                    class="h5 mb-0 font-weight-bold text-gray-800">{{ $widget['cutimelahirkan'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <div class="row">
        <!-- Cuti Alasan Penting -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('cutialasanpenting.index') }}" style="text-decoration: none">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div
                                    class="text-xs font-weight-bold text-success text-uppercase mb-1">{{ __('Cuti Alasan Penting') }}</div>
                                <div
                                    class="h5 mb-0 font-weight-bold text-gray-800">{{ $widget['cutialasanpenting'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Surat Menduduki Jabatan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('mendudukijabatan.index') }}" style="text-decoration: none">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div
                                    class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ __('Surat Menduduki Jabatan') }}</div>
                                <div
                                    class="h5 mb-0 font-weight-bold text-gray-800">{{ $widget['mendudukijabatan'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Surat Mutasi -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('mutasi.index') }}" style="text-decoration: none">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Surat Mutasi
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $widget['mutasi'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exchange-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Surat Pengantar -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('pengantar.index') }}" style="text-decoration: none">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div
                                    class="text-xs font-weight-bold text-info text-uppercase mb-1">{{ __('Surat Pengantar') }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $widget['pengantar'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-share-square fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <div class="row">

        <!-- Surat Perintah Tugas -->
        <div class="col-xl-12 col-md-12 mb-4">
            <a href="{{ route('perintahtugas.index') }}" style="text-decoration: none">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Surat Perintah
                                    Tugas
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $widget['perintahtugas'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-mail-bulk fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>
@endsection
