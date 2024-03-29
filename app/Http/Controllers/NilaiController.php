<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Siswa;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use PDF;

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
                    'id' => $request->id,
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

            return response()->json(['success' => 'Nilai siswa berhasil ditambahkan!']);
        } else {
            return response()->json(['error' => 'Maaf guru ini tidak mengajar kelas ini!']);
        }
    }

    public function acc(Request $request)
    {
        $cek = Nilai::where('id', $request->id)
        ->whereNotNull('ulha')
        ->whereNotNull('ketrampilan')
        ->whereNotNull('uts')
        ->whereNotNull('pat')->count();
        if ($cek == 1) {
            $acc = Nilai::findorfail($request->id)->update($request->all());

            return response()->json(['success' => 'Nilai berhasil diacc!']);
        } else {
            return response()->json(['error' => 'Nilai belum terisi semua!'], 412);
        }
    }

    public function view()
    {
        if (auth()->user()->can('master') == true) {
            $jadwal = Nilai::orderBy('kelas_id')->get();
        } elseif (auth()->user()->hasRole('wali kelas') == true) {
            $wali = Kelas::where('guru_id', Auth::user()->guru->id)->first();
            $jadwal = Nilai::where('kelas_id', $wali->id)->get();
            $jadwal2 = Nilai::where('guru_id', Auth::user()->guru->id)->get();
            $jadwal = $jadwal2->merge($jadwal);
        } else {
            $jadwal = Nilai::where('guru_id', Auth::user()->guru->id)->orderBy('kelas_id')->get();
        }
        $kelas = $jadwal->groupBy(['tahun_semester', 'kelas_id', 'mapel_id']);
        //dd($kelas);
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
        if (auth()->user()->can('master') == true) {
            $kelas = Nilai::get();
            $kelas = $kelas->groupBy(['kelas_id', 'tahun_semester']);
        } else {
            $kelas = Nilai::where('guru_id', Auth::user()->guru->id)->get();
            $kelas = $kelas->groupBy(['kelas_id', 'tahun_semester']);
        }
        //dd($kelas);
        return view('nilai.rapor.index', compact('kelas'));
    }

    public function rapor_show($id)
    {
        $id = Crypt::decrypt($id);
        $kelas = Kelas::findorfail($id[0]);
        $siswa = Nilai::orderBy('siswa_id')->where('kelas_id', $id[0])->where('tahun_semester', $id[1])->get();
        $siswa = $siswa->groupBy(['siswa_id']);
        $tahun_semester = $id[1];

        return view('nilai.rapor.show', compact('kelas', 'siswa', 'tahun_semester'));
    }

    public function rapor_detail($id)
    {
        $id = Crypt::decrypt($id);
        $siswa = Siswa::findorfail($id);
        $kelas = Kelas::findorfail($siswa->kelas_id);
        $nilai = Nilai::orderBy('mapel_id')->where('kelas_id', $kelas->id)->where('siswa_id', $siswa->id)->get();

        return view('nilai.rapor.detail', compact('nilai', 'siswa', 'kelas'));
    }

    public function raporpdf($id)
    {
        $id = Crypt::decrypt($id);
        $siswa = Siswa::findorfail($id);
        $kelas = Kelas::findorfail($siswa->kelas_id);
        $nilai = Nilai::orderBy('mapel_id')->where('kelas_id', $kelas->id)->where('siswa_id', $siswa->id)->get();
        $data = [
            'siswa' => $siswa,
            'kelas' => $kelas,
            'nilai' => $nilai,
        ];
        $html = view('nilai.rapor.export', $data);
        $pdf = PDF::loadHtml($html);

        return $pdf->download('Raport '.$siswa->nama_siswa.' '.date('d-m-Y').'.pdf');
    }
}
