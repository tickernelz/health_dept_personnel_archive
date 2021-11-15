@extends('layouts.admin')

@push('title', 'Edit Surat Masuk')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    <!-- Main Content goes here -->

    <div class="card">
        <div class="card-body">
            <form action="{{ route('suratmasuk.update', $data->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="form-group">
                    <label for="kode">Kode Surat</label>
                    <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" id="kode"
                           placeholder="Masukkan Kode..." autocomplete="off" value="{{ old('kode') ?? $data->kode}}">
                    @error('kode')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nomor_surat">Nomor Surat</label>
                    <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror"
                           name="nomor_surat" id="nomor_surat"
                           placeholder="Masukkan Nomor Surat..." autocomplete="off" value="{{ old('nomor_surat') ?? $data->nomor_surat}}">
                    @error('nomor_surat')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tanggal_masuk">Tanggal Masuk</label>
                    <div class="input-group date">
                        <input onkeydown="return false" type="text"
                               class="form-control datepicker @error('tanggal_masuk') is-invalid @enderror"
                               name="tanggal_masuk" id="tanggal_masuk"
                               placeholder="Masukkan Tanggal Masuk..." autocomplete="off"
                               value="{{ old('tanggal_masuk') ?? $tanggal_masuk}}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </div>
                    </div>
                    @error('tanggal_masuk')
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
                    <label for="pengirim">Pengirim</label>
                    <input type="text" class="form-control @error('pengirim') is-invalid @enderror" name="pengirim"
                           id="pengirim"
                           placeholder="Masukkan Pengirim..." autocomplete="off" value="{{ old('pengirim') ?? $data->pengirim}}">
                    @error('pengirim')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kepada">Kepada</label>
                    <input type="text" class="form-control @error('kepada') is-invalid @enderror" name="kepada"
                           id="kepada"
                           placeholder="Masukkan Kepada..." autocomplete="off" value="{{ old('kepada') ?? $data->kepada}}">
                    @error('kepada')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="perihal">Perihal</label>
                    <textarea class="form-control @error('perihal') is-invalid @enderror" name="perihal" id="perihal"
                              rows="3">{{ old('perihal') ?? $data->perihal}}</textarea>
                    @error('perihal')
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
                                   id="file">
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
                           id="operator" autocomplete="off" value="{{ Auth::user()->nama }}" readonly>
                    @error('operator')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('suratmasuk.index') }}" class="btn btn-default">Kembali</a>

            </form>
        </div>
    </div>

    <!-- End of Main Content -->
@endsection

@push('notif')
    @if (session('error'))
        <div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
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
