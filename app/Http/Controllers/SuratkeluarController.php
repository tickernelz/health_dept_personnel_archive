<?php

namespace App\Http\Controllers;

use App\Models\Suratkeluar;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SuratkeluarController extends Controller
{
    public function index()
    {
        $data = Suratkeluar::get();

        return view('arsip.suratkeluar.list', [
            'title' => 'List Surat Keluar',
            'data' => $data,
        ]);
    }

    public function create()
    {
        return view('arsip.suratkeluar.create', [
            'title' => 'Tambah Surat Keluar',
        ]);
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'kode' => 'nullable|string',
            'nomor_surat' => 'required|string|unique:suratkeluars',
            'tanggal_keluar' => 'required|string',
            'tanggal_surat' => 'required|string',
            'kepada' => 'required|string',
            'perihal' => 'required|string',
            'file' => 'file|nullable|mimes:pdf,docx,doc,jpg,jpeg',
            'operator' => 'required|string',
        ]);

        // Konversi Tanggal
        $tanggal_keluar = Carbon::createFromFormat('d/m/Y', $request->input('tanggal_keluar'))->format('Y-m-d');
        $tanggal_surat = Carbon::createFromFormat('d/m/Y', $request->input('tanggal_surat'))->format('Y-m-d');

        // Cek File
        if ($request->hasFile('file')) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $request->file->move(public_path('file/suratkeluar'), $fileName);
        }

        // Cek Tanggal
        if ($tanggal_surat > $tanggal_keluar) {
            return back()->with('error', 'Tanggal Surat Tidak Boleh Lebih Dari Tanggal Keluar!');
        }

        // Simpan Data
        $data = new Suratkeluar();
        $data->kode = $request->input('kode');
        $data->nomor_surat = $request->input('nomor_surat');
        $data->tanggal_keluar = $tanggal_keluar;
        $data->tanggal_surat = $tanggal_surat;
        $data->kepada = $request->input('kepada');
        $data->perihal = $request->input('perihal');
        $data->operator = $request->input('operator');
        $data->file = $fileName ?? null;
        $data->save();

        return redirect()->route('suratkeluar.index')->with('message', 'Data Berhasil Ditambahkan!');
    }

    public function edit(int $id)
    {
        $data = Suratkeluar::firstWhere('id', $id);

        // Konversi Tanggal
        $tanggal_keluar = Carbon::parse($data->tanggal_keluar)->format('d/m/Y');
        $tanggal_surat = Carbon::parse($data->tanggal_surat)->format('d/m/Y');

        return view('arsip.suratkeluar.edit', [
            'title' => 'Edit Surat Keluar',
            'data' => $data,
            'tanggal_keluar' => $tanggal_keluar,
            'tanggal_surat' => $tanggal_surat,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $data = Suratkeluar::firstWhere('id', $id);

        $request->validate([
            'kode' => 'nullable|string',
            'nomor_surat' => 'required|string|unique:suratkeluars,nomor_surat,'.$data->id,
            'tanggal_keluar' => 'required|string',
            'tanggal_surat' => 'required|string',
            'kepada' => 'required|string',
            'perihal' => 'required|string',
            'file' => 'file|nullable|mimes:pdf,docx,doc,jpg,jpeg',
            'operator' => 'required|string',
        ]);

        // Konversi Tanggal
        $tanggal_keluar = Carbon::createFromFormat('d/m/Y', $request->input('tanggal_keluar'))->format('Y-m-d');
        $tanggal_surat = Carbon::createFromFormat('d/m/Y', $request->input('tanggal_surat'))->format('Y-m-d');

        // Cek Tanggal
        if ($tanggal_surat > $tanggal_keluar) {
            return back()->with('error', 'Tanggal Surat Tidak Boleh Lebih Dari Tanggal Keluar!');
        }

        $data->kode = $request->input('kode');
        $data->nomor_surat = $request->input('nomor_surat');
        $data->tanggal_keluar = $tanggal_keluar;
        $data->tanggal_surat = $tanggal_surat;
        $data->kepada = $request->input('kepada');
        $data->perihal = $request->input('perihal');
        $data->operator = $request->input('operator');
        // Cek apakah ada berkas?
        if ($request->hasFile('file')) {
            // Hapus Berkas Lama (Jika Ada)
            $namaberkas = $data->file;
            if (is_file(public_path('file/suratkeluar/').$namaberkas)) {
                unlink(public_path('file/suratkeluar/').$namaberkas);
            }
            // Upload File Baru
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $request->file->move(public_path('file/suratkeluar'), $fileName);
            $data->file = $fileName;
        }
        $simpan = $data->save();

        if ($simpan) {
            return redirect()->route('suratkeluar.index')->with('message', 'Data Berhasil Diperbarui!');
        }

        return back()->with('error', 'Data Gagal Diperbarui!');
    }

    public function hapus_file(int $id)
    {
        $data = Suratkeluar::firstWhere('id', $id);
        $namaberkas = $data->file;

        // Hapus Berkas Lama ()
        unlink(public_path('file/suratkeluar/').$namaberkas);
        $data->file = null;
        $data->save();

        return redirect()->route('suratkeluar.index')->with('message', 'File Berhasil Dihapus!');
    }

    public function destroy(int $id)
    {
        $data = Suratkeluar::firstWhere('id', $id);
        // Cek apakah ada berkas?
        if ($data->file !== null) {
            // Hapus Berkas Lama
            unlink(public_path('file/suratkeluar/').$data->file);
        }
        $data->delete();

        return redirect()->route('suratkeluar.index')->with('message', 'Data Berhasil Dihapus!');
    }
}
