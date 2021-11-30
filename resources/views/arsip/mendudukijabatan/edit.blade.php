@extends('layouts.admin')

@push('title', 'Edit Surat Menduduki Jabatan')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    <form action="{{ route('mendudukijabatan.update', $data->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('mendudukijabatan.index') }}" class="btn btn-secondary">Kembali</a>

        <!-- Main Content goes here -->

        <div class="card shadow mt-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Detail Surat</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="nomor">Nomor Surat</label>
                    <input type="text" class="form-control @error('nomor') is-invalid @enderror" name="nomor"
                           id="nomor"
                           placeholder="Masukkan Nomor Surat..." autocomplete="off" value="{{ old('nomor') ?? $data->nomor}}" @hasrole('Admin') readonly @endhasrole>
                    @error('pengirim')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tanggal_surat">Tanggal Surat</label>
                    <div class="input-group date">
                        <input onkeydown="return false" type="text"
                               class="form-control datepicker @error('tanggal_surat') is-invalid @enderror"
                               name="tanggal_surat" id="tanggal_surat"
                               placeholder="Masukkan Tanggal Surat..." autocomplete="off"
                               value="{{ old('tanggal_surat') ?? $tanggal_surat}}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </div>
                    </div>
                    @error('tanggal_surat')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Berkas Surat</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('file') is-invalid @enderror" name="file"
                                   id="file" @hasrole('Admin') readonly @endhasrole>
                            <label class="custom-file-label" for="file">Pilih file</label>
                        </div>
                    </div>
                    @error('file')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="operator">Operator</label>
                    <input type="text" class="form-control @error('operator') is-invalid @enderror" name="operator"
                           id="operator" autocomplete="off" value="{{  $data->operator ?? Auth::user()->nama }}" readonly>
                    @error('operator')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card shadow mt-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Detail Pengirim</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="nip_pengirim">NIP</label>
                    <input type="text" class="form-control @error('nip_pengirim') is-invalid @enderror" name="nip_pengirim"
                           id="nip_pengirim"
                           placeholder="Masukkan NIP Pengirim..." autocomplete="off" value="{{ old('nip_pengirim')  ?? $data->nip_pengirim }}" @hasrole('Admin') readonly @endhasrole>
                    @error('nip_pengirim')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama_pengirim">Nama</label>
                    <input type="text" class="form-control @error('nama_pengirim') is-invalid @enderror" name="nama_pengirim"
                           id="nama_pengirim"
                           placeholder="Masukkan Nama Pengirim..." autocomplete="off" value="{{ old('nama_pengirim') ?? $data->nama_pengirim }}" @hasrole('Admin') readonly @endhasrole>
                    @error('nama_pengirim')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="pangkat_pengirim">Pangkat</label>
                    <input type="text" class="form-control @error('pangkat_pengirim') is-invalid @enderror" name="pangkat_pengirim"
                           id="pangkat_pengirim"
                           placeholder="Masukkan Pangkat Pengirim..." autocomplete="off" value="{{ old('pangkat_pengirim') ?? $data->pangkat_pengirim }}" @hasrole('Admin') readonly @endhasrole>
                    @error('pangkat_pengirim')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jabatan_pengirim">Jabatan</label>
                    <input type="text" class="form-control @error('jabatan_pengirim') is-invalid @enderror" name="jabatan_pengirim"
                           id="jabatan_pengirim"
                           placeholder="Masukkan Jabatan Pengirim..." autocomplete="off" value="{{ old('jabatan_pengirim') ?? $data->jabatan_pengirim }}" @hasrole('Admin') readonly @endhasrole>
                    @error('jabatan_pengirim')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card shadow mt-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Detail Penerima</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="nip_penerima">NIP</label>
                    <input type="text" class="form-control @error('nip_penerima') is-invalid @enderror" name="nip_penerima"
                           id="nip_penerima"
                           placeholder="Masukkan NIP Penerima..." autocomplete="off" value="{{ old('nip_penerima') ?? $data->nip_penerima }}" @hasrole('Admin') readonly @endhasrole>
                    @error('nip_penerima')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama_penerima">Nama</label>
                    <input type="text" class="form-control @error('nama_penerima') is-invalid @enderror" name="nama_penerima"
                           id="nama_penerima"
                           placeholder="Masukkan Nama Penerima..." autocomplete="off" value="{{ old('nama_penerima') ?? $data->nama_penerima }}" @hasrole('Admin') readonly @endhasrole>
                    @error('nama_penerima')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="pangkat_penerima">Pangkat</label>
                    <input type="text" class="form-control @error('pangkat_penerima') is-invalid @enderror" name="pangkat_penerima"
                           id="pangkat_penerima"
                           placeholder="Masukkan Pangkat Penerima..." autocomplete="off" value="{{ old('pangkat_penerima') ?? $data->pangkat_penerima }}" @hasrole('Admin') readonly @endhasrole>
                    @error('pangkat_penerima')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jabatan_penerima">Jabatan</label>
                    <input type="text" class="form-control @error('jabatan_penerima') is-invalid @enderror" name="jabatan_penerima"
                           id="jabatan_penerima"
                           placeholder="Masukkan Jabatan Penerima..." autocomplete="off" value="{{ old('jabatan_penerima') ?? $data->jabatan_penerima }}" @hasrole('Admin') readonly @endhasrole>
                    @error('jabatan_penerima')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </form>

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

    @if (session('error'))
        <div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
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
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"/>
@endpush

@push('js')
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.id.min.js"
        charset="UTF-8"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script>
        $(document).ready(function () {
            bsCustomFileInput.init()
        })
        $('.datepicker').datepicker({
            today: "Hari Ini",
            clear: "Bersihkan",
            format: "dd/mm/yyyy",
            todayHighlight: true,
            language: 'id'
        });
    </script>
@endpush
