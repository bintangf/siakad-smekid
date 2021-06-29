<?php

namespace App\Http\Controllers;

use Auth;
use App\Nilai;
use App\Kelas;
use App\Guru;
use App\Jadwal;
use App\Mapel;
use App\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class NilaiController extends Controller
{

    public function index()
    {
        $jadwal = Jadwal::where('guru_id', Auth::user()->guru->id)->orderBy('kelas_id')->get();
        $kelas = $jadwal->groupBy(['kelas_id', 'mapel_id']);
        return view('nilai.index', compact('kelas'));
    }

    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $guru = Guru::where('user_id', Auth::user()->id)->first();
        $kelas = Kelas::findorfail($id[0]);
        $mapel = Mapel::findorfail($id[1]);
        $siswas = Siswa::where('kelas_id', $id[0])->get();
        return view('nilai.show', compact('guru', 'kelas', 'siswas', 'mapel'));
    }

    public function store(Request $request)
    {
        $guru = Guru::findorfail($request->guru_id);
        $cekJadwal = Jadwal::where('guru_id', $guru->id)->where('kelas_id', $request->kelas_id)->count();
        $walikelas = Kelas::where('id', $request->kelas_id)->first();
        if ($cekJadwal >= 1) {
            Nilai::updateOrCreate(
                [
                    'id' => $request->id
                ],
                [
                    'siswa_id' => $request->siswa_id,
                    'kelas_id' => $request->kelas_id,
                    'guru_id' => $request->guru_id,
                    'mapel_id' => $request->mapel_id,
                    'tahun_semester' => $request->tahun_semester,
                    'ulha' => $request->ulha,
                    'ketrampilan' => $request->ketrampilan,
                    'uts' => $request->uts,
                    'pat' => $request->pat,
                ]
            );
            return response()->json(['success' => 'Nilai ulangan siswa berhasil ditambahkan!']);
        } else {
            return response()->json(['error' => 'Maaf guru ini tidak mengajar kelas ini!']);
        }
    }

    public function acc(Request $request)
    {
        $acc = Nilai::findorfail($request->id)->update($request->all());
        return response()->json(['success' => 'Nilai ulangan berhasil diacc!']);
    }

    public function view()
    {
        if(auth()->user()->can('master') == true){
            $jadwal = Nilai::orderBy('kelas_id')->get();
        }elseif(auth()->user()->hasRole('wali kelas') == true){
            $wali = Kelas::where('guru_id', Auth::user()->guru->id)->first();
            $jadwal = Nilai::where('kelas_id', $wali->id)->get();
            $jadwal2 = Nilai::where('guru_id',  Auth::user()->guru->id)->get();
            $jadwal = $jadwal2->merge($jadwal);
        }else{
            $jadwal = Nilai::where('guru_id', Auth::user()->guru->id)->orderBy('kelas_id')->get();
        }
        $kelas = $jadwal->groupBy(['kelas_id', 'mapel_id']);
        return view('nilai.view', compact('kelas'));
    }

    public function view_detail($id)
    {
        $id = Crypt::decrypt($id);
        $nilai = Nilai::where('kelas_id', $id[0])
                ->where('guru_id', $id[1])
                ->where('mapel_id', $id[2])
                ->where('tahun_semester', $id[3])
                ->get();
                
        return view('nilai.viewDetail', compact('nilai'));
    }

    public function rapor()
    {
        if(auth()->user()->can('master') == true){
            $kelas = Kelas::orderBy('nama_kelas')->get();
        }else{
            $kelas = Kelas::where('guru_id', Auth::user()->guru->id)->orderBy('nama_kelas')->get();
        }
        return view('nilai.rapor.index', compact('kelas'));
    }

    public function rapor_show($id)
    {
        $id = Crypt::decrypt($id);
        $kelas = Kelas::findorfail($id);
        $siswa = Nilai::orderBy('siswa_id')->where('kelas_id', $id)->get();
        $siswa = $siswa->groupBy(['siswa_id']);
        //dd($siswa);
        return view('nilai.rapor.show', compact('kelas', 'siswa'));
    }

    public function rapor_detail($id)
    {
        $id = Crypt::decrypt($id);
        $siswa = Siswa::findorfail($id);
        $kelas = Kelas::findorfail($siswa->kelas_id);
        $nilai = Nilai::orderBy('mapel_id')->where('kelas_id', $kelas->id)->where('siswa_id', $siswa->id)->get();
        return view('nilai.rapor.detail', compact('nilai', 'siswa', 'kelas'));
    }
}
