<?php

namespace App\Http\Controllers;

use App\Models\Pengantar;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PengantarController extends Controller
{
    public function index()
    {
        $data = Pengantar::get();

        return view('arsip.pengantar.list', [
            'title' => 'List Surat Pengantar',
            'data' => $data,
        ]);
    }

    public function create()
    {
        return view('arsip.pengantar.create', [
            'title' => 'Tambah Surat Pengantar',
        ]);
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'nomor' => 'nullable|string',
            'pengirim' => 'required|string',
            'kepada' => 'nullable|string',
            'isi' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'tanggal_surat' => 'required|string',
            'file' => 'file|nullable|mimes:pdf,docx,doc,jpg,jpeg',
            'operator' => 'required|string',
        ]);

        // Konversi Tanggal
        $tanggal_surat = Carbon::createFromFormat('d/m/Y', $request->input('tanggal_surat'))->format('Y-m-d');

        // Cek File
        if ($request->hasFile('file')) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $request->file->move(public_path('file/pengantar'), $fileName);
        }

        // Simpan Data
        $data = new Pengantar();
        $data->nomor = $request->input('nomor');
        $data->pengirim = $request->input('pengirim');
        $data->kepada = $request->input('kepada');
        $data->isi = $request->input('isi');
        $data->keterangan = $request->input('keterangan');
        $data->tanggal_surat = $tanggal_surat;
        $data->operator = $request->input('operator');
        $data->file = $fileName ?? null;
        $data->save();

        return redirect()->route('pengantar.index')->with('message', 'Data Berhasil Ditambahkan!');
    }

    public function edit(int $id)
    {
        $data = Pengantar::firstWhere('id', $id);

        // Konversi Tanggal
        $tanggal_surat = Carbon::parse($data->tanggal_surat)->format('d/m/Y');

        return view('arsip.pengantar.edit', [
            'title' => 'Edit Surat Pengantar',
            'data' => $data,
            'tanggal_surat' => $tanggal_surat,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $data = Pengantar::firstWhere('id', $id);

        $request->validate([
            'nomor' => 'nullable|string',
            'pengirim' => 'required|string',
            'kepada' => 'nullable|string',
            'isi' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'tanggal_surat' => 'required|string',
            'file' => 'file|nullable|mimes:pdf,docx,doc,jpg,jpeg',
            'operator' => 'required|string',
        ]);

        // Konversi Tanggal
        $tanggal_surat = Carbon::createFromFormat('d/m/Y', $request->input('tanggal_surat'))->format('Y-m-d');

        $data->nomor = $request->input('nomor');
        $data->pengirim = $request->input('pengirim');
        $data->kepada = $request->input('kepada');
        $data->isi = $request->input('isi');
        $data->keterangan = $request->input('keterangan');
        $data->tanggal_surat = $tanggal_surat;
        $data->operator = $request->input('operator');
        // Cek apakah ada berkas?
        if ($request->hasFile('file')) {
            // Hapus Berkas Lama (Jika Ada)
            $namaberkas = $data->file;
            if (is_file(public_path('file/pengantar/').$namaberkas)) {
                unlink(public_path('file/pengantar/').$namaberkas);
            }
            // Upload File Baru
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $request->file->move(public_path('file/pengantar'), $fileName);
            $data->file = $fileName;
        }
        $simpan = $data->save();

        if ($simpan) {
            return redirect()->route('pengantar.index')->with('message', 'Data Berhasil Diperbarui!');
        }

        return back()->with('error', 'Data Gagal Diperbarui!');
    }

    public function hapus_file(int $id)
    {
        $data = Pengantar::firstWhere('id', $id);
        $namaberkas = $data->file;

        // Hapus Berkas Lama
        unlink(public_path('file/pengantar/').$namaberkas);
        $data->file = null;
        $data->save();

        return redirect()->route('pengantar.index')->with('message', 'File Berhasil Dihapus!');
    }

    public function destroy(int $id)
    {
        $data = Pengantar::firstWhere('id', $id);
        // Cek apakah ada berkas?
        if ($data->file !== null) {
            // Hapus Berkas Lama
            unlink(public_path('file/pengantar/').$data->file);
        }
        $data->delete();

        return redirect()->route('pengantar.index')->with('message', 'Data Berhasil Dihapus!');
    }
}
