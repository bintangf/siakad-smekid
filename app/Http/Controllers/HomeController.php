<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\User;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $hari = date('w');
        $tabeljadwal = Jadwal::OrderBy('jam_mulai')->OrderBy('jam_selesai')->OrderBy('kelas_id')->where('hari_id', $hari)->get();
        $jadwal = Jadwal::count();
        $guru = Guru::count();
        $siswa = Siswa::count();
        $kelas = Kelas::count();
        $mapel = Mapel::count();
        $user = User::count();
        $jurusan = Jurusan::all();

        return view('home', compact(
            'jadwal',
            'guru',
            'siswa',
            'kelas',
            'mapel',
            'user',
            'jurusan',
            'hari',
            'tabeljadwal'
        ));
    }
}
