<?php

namespace App\Http\Controllers;

use App\Jadwal;
use App\Guru;
use App\Kehadiran;
use App\Kelas;
use App\Siswa;
use App\Mapel;
use App\User;
use App\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
