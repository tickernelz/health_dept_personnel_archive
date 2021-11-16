<?php

namespace App\Http\Controllers;

use App\Models\Perintahtugas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PerintahtugasController extends Controller
{
    public function index()
    {
        $data = Perintahtugas::get();

        return view('arsip.perintahtugas.list', [
            'title' => 'List Surat Perintah Tugas',
            'data' => $data,
        ]);
    }

    public function create()
    {
        return view('arsip.perintahtugas.create', [
            'title' => 'Tambah Surat Perintah Tugas',
        ]);
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'nomor' => 'nullable|string',
            'pengirim' => 'required|string',
            'nama' => 'required|string',
            'nip' => 'nullable|string',
            'pangkat' => 'nullable|string',
            'jabatan' => 'nullable|string',
            'isi' => 'nullable|string',
            'tanggal_surat' => 'required|string',
            'tanggal_mulai' => 'required|nullable',
            'tanggal_selesai' => 'required|nullable',
            'file' => 'file|nullable|mimes:pdf,docx,doc,jpg,jpeg',
            'operator' => 'required|string',
        ]);

        // Konversi Tanggal
        $tanggal_surat = Carbon::createFromFormat('d/m/Y', $request->input('tanggal_surat'))->format('Y-m-d');
        $tanggal_mulai = Carbon::createFromFormat('d/m/Y', $request->input('tanggal_mulai'))->format('Y-m-d');
        $tanggal_selesai = Carbon::createFromFormat('d/m/Y', $request->input('tanggal_selesai'))->format('Y-m-d');

        // Cek File
        if ($request->hasFile('file')) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $request->file->move(public_path('file/perintahtugas'), $fileName);
        }

        // Cek Tanggal
        if ($tanggal_mulai > $tanggal_selesai) {
            return back()->with('error', 'Tanggal Mulai Tidak Boleh Lebih Dari Tanggal Selesai Cuti!')->withInput();
        }

        // Simpan Data
        $data = new Perintahtugas();
        $data->nomor = $request->input('nomor');
        $data->pengirim = $request->input('pengirim');
        $data->nama = $request->input('nama');
        $data->nip = $request->input('nip');
        $data->pangkat = $request->input('pangkat');
        $data->jabatan = $request->input('jabatan');
        $data->isi = $request->input('isi');
        $data->tanggal_surat = $tanggal_surat;
        $data->tanggal_mulai = $tanggal_mulai;
        $data->tanggal_selesai = $tanggal_selesai;
        $data->operator = $request->input('operator');
        $data->file = $fileName ?? null;
        $data->save();

        return redirect()->route('perintahtugas.index')->with('message', 'Data Berhasil Ditambahkan!');
    }

    public function edit(int $id)
    {
        $data = Perintahtugas::firstWhere('id', $id);

        // Konversi Tanggal
        $tanggal_surat = Carbon::parse($data->tanggal_surat)->format('d/m/Y');
        $tanggal_mulai = Carbon::parse($data->tanggal_mulai)->format('d/m/Y');
        $tanggal_selesai = Carbon::parse($data->tanggal_selesai)->format('d/m/Y');

        return view('arsip.perintahtugas.edit', [
            'title' => 'Edit Surat Perintah Tugas',
            'data' => $data,
            'tanggal_surat' => $tanggal_surat,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $data = Perintahtugas::firstWhere('id', $id);

        $request->validate([
            'nomor' => 'nullable|string',
            'pengirim' => 'required|string',
            'nama' => 'required|string',
            'nip' => 'nullable|string',
            'pangkat' => 'nullable|string',
            'jabatan' => 'nullable|string',
            'isi' => 'nullable|string',
            'tanggal_surat' => 'required|string',
            'tanggal_mulai' => 'required|nullable',
            'tanggal_selesai' => 'required|nullable',
            'file' => 'file|nullable|mimes:pdf,docx,doc,jpg,jpeg',
            'operator' => 'required|string',
        ]);

        // Konversi Tanggal
        $tanggal_surat = Carbon::createFromFormat('d/m/Y', $request->input('tanggal_surat'))->format('Y-m-d');
        $tanggal_mulai = Carbon::createFromFormat('d/m/Y', $request->input('tanggal_mulai'))->format('Y-m-d');
        $tanggal_selesai = Carbon::createFromFormat('d/m/Y', $request->input('tanggal_selesai'))->format('Y-m-d');

        // Cek Tanggal
        if ($tanggal_mulai > $tanggal_selesai) {
            return back()->with('error', 'Tanggal Mulai Tidak Boleh Lebih Dari Tanggal Selesai Cuti!');
        }

        $data->nomor = $request->input('nomor');
        $data->pengirim = $request->input('pengirim');
        $data->nama = $request->input('nama');
        $data->nip = $request->input('nip');
        $data->pangkat = $request->input('pangkat');
        $data->jabatan = $request->input('jabatan');
        $data->isi = $request->input('isi');
        $data->tanggal_surat = $tanggal_surat;
        $data->tanggal_mulai = $tanggal_mulai;
        $data->tanggal_selesai = $tanggal_selesai;
        $data->operator = $request->input('operator');
        // Cek apakah ada berkas?
        if ($request->hasFile('file')) {
            // Hapus Berkas Lama (Jika Ada)
            $namaberkas = $data->file;
            if (is_file(public_path('file/perintahtugas/').$namaberkas)) {
                unlink(public_path('file/perintahtugas/').$namaberkas);
            }
            // Upload File Baru
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $request->file->move(public_path('file/perintahtugas'), $fileName);
            $data->file = $fileName;
        }
        $simpan = $data->save();

        if ($simpan) {
            return redirect()->route('perintahtugas.index')->with('message', 'Data Berhasil Diperbarui!');
        }

        return back()->with('error', 'Data Gagal Diperbarui!');
    }

    public function hapus_file(int $id)
    {
        $data = Perintahtugas::firstWhere('id', $id);
        $namaberkas = $data->file;

        // Hapus Berkas Lama
        unlink(public_path('file/perintahtugas/').$namaberkas);
        $data->file = null;
        $data->save();

        return redirect()->route('perintahtugas.index')->with('message', 'File Berhasil Dihapus!');
    }

    public function destroy(int $id)
    {
        $data = Perintahtugas::firstWhere('id', $id);
        // Cek apakah ada berkas?
        if ($data->file !== null) {
            // Hapus Berkas Lama
            unlink(public_path('file/perintahtugas/').$data->file);
        }
        $data->delete();

        return redirect()->route('perintahtugas.index')->with('message', 'Data Berhasil Dihapus!');
    }
}
