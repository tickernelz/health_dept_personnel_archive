<?php

namespace App\Http\Controllers;

use App\Models\Mendudukijabatan;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MendudukijabatanController extends Controller
{
    public function index()
    {
        $data = Mendudukijabatan::get();

        return view('arsip.mendudukijabatan.list', [
            'title' => 'List Surat Menduduki Jabatan',
            'data' => $data,
        ]);
    }

    public function create()
    {
        return view('arsip.mendudukijabatan.create', [
            'title' => 'Tambah Surat Menduduki Jabatan',
        ]);
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'nomor' => 'nullable|string',
            'nama_pengirim' => 'required|string',
            'nip_pengirim' => 'nullable|string',
            'pangkat_pengirim' => 'nullable|string',
            'jabatan_pengirim' => 'required|string',
            'nama_penerima' => 'required|string',
            'nip_penerima' => 'nullable|string',
            'pangkat_penerima' => 'nullable|string',
            'jabatan_penerima' => 'required|string',
            'tanggal_surat' => 'required|string',
            'file' => 'file|nullable|mimes:pdf,docx,doc,jpg,jpeg',
            'operator' => 'required|string',
        ]);

        // Konversi Tanggal
        $tanggal_surat = Carbon::createFromFormat('d/m/Y', $request->input('tanggal_surat'))->format('Y-m-d');

        // Cek File
        if ($request->hasFile('file')) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $request->file->move(public_path('file/mendudukijabatan'), $fileName);
        }

        // Simpan Data
        $data = new Mendudukijabatan();
        $data->nomor = $request->input('nomor');
        $data->nama_pengirim = $request->input('nama_pengirim');
        $data->nip_pengirim = $request->input('nip_pengirim');
        $data->pangkat_pengirim = $request->input('pangkat_pengirim');
        $data->jabatan_pengirim = $request->input('jabatan_pengirim');
        $data->nama_penerima = $request->input('nama_penerima');
        $data->nip_penerima = $request->input('nip_penerima');
        $data->pangkat_penerima = $request->input('pangkat_penerima');
        $data->jabatan_penerima = $request->input('jabatan_penerima');
        $data->tanggal_surat = $tanggal_surat;
        $data->operator = $request->input('operator');
        $data->file = $fileName ?? null;
        $data->save();

        return redirect()->route('mendudukijabatan.index')->with('message', 'Data Berhasil Ditambahkan!');
    }

    public function edit(int $id)
    {
        $data = Mendudukijabatan::firstWhere('id', $id);

        // Konversi Tanggal
        $tanggal_surat = Carbon::parse($data->tanggal_surat)->format('d/m/Y');

        return view('arsip.mendudukijabatan.edit', [
            'title' => 'Edit Surat Menduduki Jabatan',
            'data' => $data,
            'tanggal_surat' => $tanggal_surat,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $data = Mendudukijabatan::firstWhere('id', $id);

        $request->validate([
            'nomor' => 'nullable|string',
            'nama_pengirim' => 'required|string',
            'nip_pengirim' => 'nullable|string',
            'pangkat_pengirim' => 'nullable|string',
            'jabatan_pengirim' => 'required|string',
            'nama_penerima' => 'required|string',
            'nip_penerima' => 'nullable|string',
            'pangkat_penerima' => 'nullable|string',
            'jabatan_penerima' => 'required|string',
            'tanggal_surat' => 'required|string',
            'file' => 'file|nullable|mimes:pdf,docx,doc,jpg,jpeg',
            'operator' => 'required|string',
        ]);

        // Konversi Tanggal
        $tanggal_surat = Carbon::createFromFormat('d/m/Y', $request->input('tanggal_surat'))->format('Y-m-d');

        $data->nomor = $request->input('nomor');
        $data->nama_pengirim = $request->input('nama_pengirim');
        $data->nip_pengirim = $request->input('nip_pengirim');
        $data->pangkat_pengirim = $request->input('pangkat_pengirim');
        $data->jabatan_pengirim = $request->input('jabatan_pengirim');
        $data->nama_penerima = $request->input('nama_penerima');
        $data->nip_penerima = $request->input('nip_penerima');
        $data->pangkat_penerima = $request->input('pangkat_penerima');
        $data->jabatan_penerima = $request->input('jabatan_penerima');
        $data->tanggal_surat = $tanggal_surat;
        $data->operator = Auth::user()->nama;
        // Cek apakah ada berkas?
        if ($request->hasFile('file')) {
            // Hapus Berkas Lama (Jika Ada)
            $namaberkas = $data->file;
            if (is_file(public_path('file/mendudukijabatan/').$namaberkas)) {
                unlink(public_path('file/mendudukijabatan/').$namaberkas);
            }
            // Upload File Baru
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $request->file->move(public_path('file/mendudukijabatan'), $fileName);
            $data->file = $fileName;
        }
        $simpan = $data->save();

        if ($simpan) {
            return redirect()->route('mendudukijabatan.index')->with('message', 'Data Berhasil Diperbarui!');
        }

        return back()->with('error', 'Data Gagal Diperbarui!');
    }

    public function hapus_file(int $id)
    {
        $data = Mendudukijabatan::firstWhere('id', $id);
        $namaberkas = $data->file;

        // Hapus Berkas Lama
        unlink(public_path('file/mendudukijabatan/').$namaberkas);
        $data->file = null;
        $data->save();

        return redirect()->route('mendudukijabatan.index')->with('message', 'File Berhasil Dihapus!');
    }

    public function destroy(int $id)
    {
        $data = Mendudukijabatan::firstWhere('id', $id);
        // Cek apakah ada berkas?
        if ($data->file !== null) {
            // Hapus Berkas Lama
            unlink(public_path('file/mendudukijabatan/').$data->file);
        }
        $data->delete();

        return redirect()->route('mendudukijabatan.index')->with('message', 'Data Berhasil Dihapus!');
    }
}
