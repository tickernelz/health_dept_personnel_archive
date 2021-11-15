<?php

namespace App\Http\Controllers;

use App\Models\Suratmasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Validator;

class SuratmasukController extends Controller
{
    public function index()
    {
        $data = Suratmasuk::get();

        return view('arsip.suratmasuk.list', [
            'title' => 'List Surat Masuk',
            'data' => $data,
        ]);
    }

    public function create()
    {
        return view('arsip.suratmasuk.create', [
            'title' => 'Tambah Surat Masuk',
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'kode' => 'nullable|string',
            'nomor_surat' => 'required|string|unique:suratmasuks',
            'tanggal_masuk' => 'required|string',
            'tanggal_surat' => 'required|string',
            'pengirim' => 'required|string',
            'kepada' => 'required|string',
            'perihal' => 'required|string',
            'file' => 'file|nullable|mimes:pdf,docx,doc,jpg,jpeg',
            'operator' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        // Konversi Tanggal
        $tanggal_masuk = Carbon::createFromFormat('d/m/Y', $request->input('tanggal_masuk'))->format('Y-m-d');
        $tanggal_surat = Carbon::createFromFormat('d/m/Y', $request->input('tanggal_surat'))->format('Y-m-d');

        // Cek File
        if ($request->hasFile('file')) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $request->file->move(public_path('file/suratmasuk'), $fileName);
        }

        // Cek Tanggal
        if ($tanggal_surat > $tanggal_masuk) {
            return back()->with('error', 'Tanggal Surat Tidak Boleh Lebih Dari Tanggal Masuk!');
        }

        Suratmasuk::create([
            'kode' => $request->input('kode'),
            'nomor_surat' => $request->input('nomor_surat'),
            'tanggal_masuk' => $tanggal_masuk,
            'tanggal_surat' => $tanggal_surat,
            'pengirim' => $request->input('pengirim'),
            'kepada' => $request->input('kepada'),
            'perihal' => $request->input('perihal'),
            'operator' => $request->input('operator'),
            'file' => $fileName ?? null,
        ]);

        return redirect()->route('suratmasuk.index')->with('message', 'Data Berhasil Ditambahkan!');
    }

    public function edit(int $id)
    {
        $data = Suratmasuk::firstWhere('id', $id);

        // Konversi Tanggal
        $tanggal_masuk = Carbon::parse($data->tanggal_masuk)->format('d/m/Y');
        $tanggal_surat = Carbon::parse($data->tanggal_surat)->format('d/m/Y');

        return view('arsip.suratmasuk.edit', [
            'title' => 'Edit Surat Masuk',
            'data' => $data,
            'tanggal_masuk' => $tanggal_masuk,
            'tanggal_surat' => $tanggal_surat,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $data = Suratmasuk::firstWhere('id', $id);

        $rules = [
            'kode' => 'nullable|string',
            'nomor_surat' => 'required|string|unique:suratmasuks,nomor_surat,'.$data->id,
            'tanggal_masuk' => 'required|string',
            'tanggal_surat' => 'required|string',
            'pengirim' => 'required|string',
            'kepada' => 'required|string',
            'perihal' => 'required|string',
            'file' => 'file|nullable|mimes:pdf,docx,doc,jpg,jpeg',
            'operator' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        // Konversi Tanggal
        $tanggal_masuk = Carbon::createFromFormat('d/m/Y', $request->input('tanggal_masuk'))->format('Y-m-d');
        $tanggal_surat = Carbon::createFromFormat('d/m/Y', $request->input('tanggal_surat'))->format('Y-m-d');

        // Cek Tanggal
        if ($tanggal_surat > $tanggal_masuk) {
            return back()->with('error', 'Tanggal Surat Tidak Boleh Lebih Dari Tanggal Masuk!');
        }

        $data->kode = $request->input('kode');
        $data->nomor_surat = $request->input('nomor_surat');
        $data->tanggal_masuk = $tanggal_masuk;
        $data->tanggal_surat = $tanggal_surat;
        $data->pengirim = $request->input('pengirim');
        $data->kepada = $request->input('kepada');
        $data->perihal = $request->input('perihal');
        $data->operator = $request->input('operator');
        // Cek apakah ada berkas?
        if ($request->hasFile('file')) {
            // Hapus Berkas Lama (Jika Ada)
            $namaberkas = $data->file;
            if (is_file(public_path('file/suratmasuk').'/'.$namaberkas)) {
                unlink(public_path('file/suratmasuk').'/'.$namaberkas);
            }
            // Upload File Baru
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $request->file->move(public_path('file/suratmasuk'), $fileName);
            $data->file = $fileName;
        }
        $simpan = $data->save();

        if ($simpan) {
            return redirect()->route('suratmasuk.index')->with('message', 'Data Berhasil Diperbarui!');
        }

        return back()->with('error', 'Data Gagal Diperbarui!');
    }

    public function hapus_file(int $id)
    {
        $data = Suratmasuk::firstWhere('id', $id);
        $namaberkas = $data->file;

        // Hapus Berkas Lama ()
        unlink(public_path('file/suratmasuk/').$namaberkas);
        $data->file = null;
        $data->save();

        return redirect()->route('suratmasuk.index')->with('message', 'File Berhasil Dihapus!');
    }

    public function destroy(int $id)
    {
        $data = Suratmasuk::firstWhere('id', $id);
        $data->delete();

        return redirect()->route('suratmasuk.index')->with('message', 'Data Berhasil Dihapus!');
    }
}
