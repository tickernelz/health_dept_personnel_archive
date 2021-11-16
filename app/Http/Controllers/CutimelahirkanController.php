<?php

namespace App\Http\Controllers;

use App\Models\Cutimelahirkan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CutimelahirkanController extends Controller
{
    public function index()
    {
        $data = Cutimelahirkan::get();

        return view('arsip.cuti.melahirkan.list', [
            'title' => 'List Cuti Melahirkan',
            'data' => $data,
        ]);
    }

    public function create()
    {
        return view('arsip.cuti.melahirkan.create', [
            'title' => 'Tambah Cuti Melahirkan',
        ]);
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'pengirim' => 'required|string',
            'nomor_induk' => 'required|string',
            'divisi' => 'nullable|string',
            'jabatan' => 'nullable|string',
            'tanggal_surat' => 'required|string',
            'tanggal_mulai' => 'required|string',
            'tanggal_selesai' => 'required|string',
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
            $request->file->move(public_path('file/cuti/melahirkan'), $fileName);
        }

        // Cek Tanggal
        if ($tanggal_mulai > $tanggal_selesai) {
            return back()->with('error', 'Tanggal Mulai Tidak Boleh Lebih Dari Tanggal Selesai Cuti!');
        }

        // Simpan Data
        $data = new Cutimelahirkan();
        $data->pengirim = $request->input('pengirim');
        $data->nomor_induk = $request->input('nomor_induk');
        $data->divisi = $request->input('divisi');
        $data->jabatan = $request->input('jabatan');
        $data->tanggal_surat = $tanggal_surat;
        $data->tanggal_mulai = $tanggal_mulai;
        $data->tanggal_selesai = $tanggal_selesai;
        $data->operator = $request->input('operator');
        $data->file = $fileName ?? null;
        $data->save();

        return redirect()->route('cutimelahirkan.index')->with('message', 'Data Berhasil Ditambahkan!');
    }

    public function edit(int $id)
    {
        $data = Cutimelahirkan::firstWhere('id', $id);

        // Konversi Tanggal
        $tanggal_surat = Carbon::parse($data->tanggal_surat)->format('d/m/Y');
        $tanggal_mulai = Carbon::parse($data->tanggal_mulai)->format('d/m/Y');
        $tanggal_selesai = Carbon::parse($data->tanggal_selesai)->format('d/m/Y');

        return view('arsip.cuti.melahirkan.edit', [
            'title' => 'Edit Cuti Melahirkan',
            'data' => $data,
            'tanggal_surat' => $tanggal_surat,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $data = Cutimelahirkan::firstWhere('id', $id);

        $request->validate([
            'pengirim' => 'required|string',
            'nomor_induk' => 'required|string',
            'divisi' => 'nullable|string',
            'jabatan' => 'nullable|string',
            'tanggal_surat' => 'required|string',
            'tanggal_mulai' => 'required|string',
            'tanggal_selesai' => 'required|string',
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

        $data->pengirim = $request->input('pengirim');
        $data->nomor_induk = $request->input('nomor_induk');
        $data->divisi = $request->input('divisi');
        $data->jabatan = $request->input('jabatan');
        $data->tanggal_surat = $tanggal_surat;
        $data->tanggal_mulai = $tanggal_mulai;
        $data->tanggal_selesai = $tanggal_selesai;
        $data->operator = $request->input('operator');
        // Cek apakah ada berkas?
        if ($request->hasFile('file')) {
            // Hapus Berkas Lama (Jika Ada)
            $namaberkas = $data->file;
            if (is_file(public_path('file/cuti/melahirkan/').$namaberkas)) {
                unlink(public_path('file/cuti/melahirkan/').$namaberkas);
            }
            // Upload File Baru
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $request->file->move(public_path('file/cuti/melahirkan'), $fileName);
            $data->file = $fileName;
        }
        $simpan = $data->save();

        if ($simpan) {
            return redirect()->route('cutimelahirkan.index')->with('message', 'Data Berhasil Diperbarui!');
        }

        return back()->with('error', 'Data Gagal Diperbarui!');
    }

    public function hapus_file(int $id)
    {
        $data = Cutimelahirkan::firstWhere('id', $id);
        $namaberkas = $data->file;

        // Hapus Berkas Lama ()
        unlink(public_path('file/cuti/melahirkan').$namaberkas);
        $data->file = null;
        $data->save();

        return redirect()->route('cutimelahirkan.index')->with('message', 'File Berhasil Dihapus!');
    }

    public function destroy(int $id)
    {
        $data = Cutimelahirkan::firstWhere('id', $id);
        // Hapus Berkas Lama
        unlink(public_path('file/cuti/melahirkan/').$data->file);
        $data->delete();

        return redirect()->route('cutimelahirkan.index')->with('message', 'Data Berhasil Dihapus!');
    }
}
