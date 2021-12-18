<?php

namespace App\Http\Controllers;

use App\Models\Cutialasanpenting;
use App\Models\Cutimelahirkan;
use App\Models\Cutitahunan;
use App\Models\Mendudukijabatan;
use App\Models\Mutasi;
use App\Models\Pengantar;
use App\Models\Perintahtugas;
use App\Models\Suratkeluar;
use App\Models\Suratmasuk;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();
        $suratmasuk = Suratmasuk::count();
        $suratkeluar = Suratkeluar::count();
        $cutialasanpenting = Cutialasanpenting::count();
        $cutimelahirkan = Cutimelahirkan::count();
        $cutitahunan = Cutitahunan::count();
        $mendudukijabatan = Mendudukijabatan::count();
        $mutasi = Mutasi::count();
        $pengantar = Pengantar::count();
        $perintahtugas = Perintahtugas::count();
        $totalsurat = (Suratmasuk::count() + Suratkeluar::count() + Cutialasanpenting::count() + Cutimelahirkan::count() + Cutitahunan::count() + Mendudukijabatan::count() + Mutasi::count() + Pengantar::count() + Perintahtugas::count());

        $widget = [
            'users' => $users,
            'suratmasuk' => $suratmasuk,
            'suratkeluar' => $suratkeluar,
            'cutialasanpenting' => $cutialasanpenting,
            'cutimelahirkan' => $cutimelahirkan,
            'cutitahunan' => $cutitahunan,
            'mendudukijabatan' => $mendudukijabatan,
            'mutasi' => $mutasi,
            'pengantar' => $pengantar,
            'perintahtugas' => $perintahtugas,
            'totalsurat' => $totalsurat,
        ];

        return view('home', compact('widget'));
    }
}
