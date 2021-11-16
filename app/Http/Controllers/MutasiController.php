<?php

namespace App\Http\Controllers;

use App\Models\Mutasi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MutasiController extends Controller
{
    public function index()
    {
        $data = Mutasi::get();

        return view('arsip.mutasi.list', [
            'title' => 'List Surat Mutasi',
            'data' => $data,
        ]);
    }

    public function create()
    {
        return view('arsip.mutasi.create', [
            'title' => 'Tambah Surat Mutasi',
        ]);
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'pengirim' => 'required|string',
            'nomor_induk' => 'required|string',
            'pangkat' => 'nullable|string',
            'jabatan' => 'nullable|string',
            'alasan' => 'nullable|string',
            'tanggal_surat' => 'required|string',
            'file' => 'file|nullable|mimes:pdf,docx,doc,jpg,jpeg',
            'operator' => 'required|string',
        ]);

        // Konversi Tanggal
        $tanggal_surat = Carbon::createFromFormat('d/m/Y', $request->input('tanggal_surat'))->format('Y-m-d');

        // Cek File
        if ($request->hasFile('file')) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $request->file->move(public_path('file/mutasi'), $fileName);
        }

        // Simpan Data
        $data = new Mutasi();
        $data->pengirim = $request->input('pengirim');
        $data->nomor_induk = $request->input('nomor_induk');
        $data->pangkat = $request->input('pangkat');
        $data->jabatan = $request->input('jabatan');
        $data->alasan = $request->input('alasan');
        $data->tanggal_surat = $tanggal_surat;
        $data->operator = $request->input('operator');
        $data->file = $fileName ?? null;
        $data->save();

        return redirect()->route('mutasi.index')->with('message', 'Data Berhasil Ditambahkan!');
    }

    public function edit(int $id)
    {
        $data = Mutasi::firstWhere('id', $id);

        // Konversi Tanggal
        $tanggal_surat = Carbon::parse($data->tanggal_surat)->format('d/m/Y');
        $tanggal_mulai = Carbon::parse($data->tanggal_mulai)->format('d/m/Y');
        $tanggal_selesai = Carbon::parse($data->tanggal_selesai)->format('d/m/Y');

        return view('arsip.mutasi.edit', [
            'title' => 'Edit Surat Mutasi',
            'data' => $data,
            'tanggal_surat' => $tanggal_surat,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $data = Mutasi::firstWhere('id', $id);

        $request->validate([
            'pengirim' => 'required|string',
            'nomor_induk' => 'required|string',
            'pangkat' => 'nullable|string',
            'jabatan' => 'nullable|string',
            'alasan' => 'nullable|string',
            'tanggal_surat' => 'required|string',
            'file' => 'file|nullable|mimes:pdf,docx,doc,jpg,jpeg',
            'operator' => 'required|string',
        ]);

        // Konversi Tanggal
        $tanggal_surat = Carbon::createFromFormat('d/m/Y', $request->input('tanggal_surat'))->format('Y-m-d');

        $data->pengirim = $request->input('pengirim');
        $data->nomor_induk = $request->input('nomor_induk');
        $data->pangkat = $request->input('pangkat');
        $data->jabatan = $request->input('jabatan');
        $data->alasan = $request->input('alasan');
        $data->tanggal_surat = $tanggal_surat;
        $data->operator = $request->input('operator');
        // Cek apakah ada berkas?
        if ($request->hasFile('file')) {
            // Hapus Berkas Lama (Jika Ada)
            $namaberkas = $data->file;
            if (is_file(public_path('file/mutasi/').$namaberkas)) {
                unlink(public_path('file/mutasi/').$namaberkas);
            }
            // Upload File Baru
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $request->file->move(public_path('file/mutasi'), $fileName);
            $data->file = $fileName;
        }
        $simpan = $data->save();

        if ($simpan) {
            return redirect()->route('mutasi.index')->with('message', 'Data Berhasil Diperbarui!');
        }

        return back()->with('error', 'Data Gagal Diperbarui!');
    }

    public function hapus_file(int $id)
    {
        $data = Mutasi::firstWhere('id', $id);
        $namaberkas = $data->file;

        // Hapus Berkas Lama
        unlink(public_path('file/mutasi/').$namaberkas);
        $data->file = null;
        $data->save();

        return redirect()->route('mutasi.index')->with('message', 'File Berhasil Dihapus!');
    }

    public function destroy(int $id)
    {
        $data = Mutasi::firstWhere('id', $id);
        // Cek apakah ada berkas?
        if ($data->file !== null) {
            // Hapus Berkas Lama
            unlink(public_path('file/mutasi/').$data->file);
        }
        $data->delete();

        return redirect()->route('mutasi.index')->with('message', 'Data Berhasil Dihapus!');
    }
}
