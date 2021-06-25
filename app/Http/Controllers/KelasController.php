<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\Guru;
use App\Jurusan;
use App\Siswa;
use App\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelas = Kelas::OrderBy('nama_kelas', 'asc')->get();
        $gurus = Guru::OrderBy('nama_guru', 'asc')->get();
        $jurusans = Jurusan::all();

        return view('admin.kelas.index', compact('kelas', 'gurus', 'jurusans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->id != '') {
            $this->validate($request, [
                'nama_kelas' => 'required|min:6|max:10',
                'jurusan_id' => 'required',
                'guru_id' => 'required',
            ]);
        } else {
            $this->validate($request, [
                'nama_kelas' => 'required|unique:kelas|min:6|max:10',
                'jurusan_id' => 'required',
                'guru_id' => 'required|unique:kelas',
            ]);
        }
        if( $request->guru_id_lama != null ){
            $guruLama = Guru::find($request->guru_id_lama)->user;
            if( $guruLama != null ){
                $guruLama->removeRole('wali kelas');
            }
        }
        Kelas::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'nama_kelas' => $request->nama_kelas,
                'jurusan_id' => $request->jurusan_id,
                'guru_id' => $request->guru_id,
            ]
        );
        if( $request->guru_id != null ){
            $guru = Guru::find($request->guru_id)->user;
            if( $guru != null ){
                $guru->assignRole('wali kelas');
            }
        }
        
        

        return redirect()->back()->with('success', 'Data kelas berhasil diperbarui!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function show(Kelas $kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelas $kelas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kelas $kelas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kelas = Kelas::findorfail($id);
        $countJadwal = Jadwal::where('kelas_id', $kelas->id)->count();
        if ($countJadwal >= 1) {
            Jadwal::where('kelas_id', $kelas->id)->delete();
        }
        $countSiswa = Siswa::where('kelas_id', $kelas->id)->count();
        if ($countSiswa >= 1) {
            Siswa::where('kelas_id', $kelas->id)->delete();
        }
        $kelas->delete();
        return redirect()->back()->with('warning', 'Data kelas berhasil dihapus! (Silahkan cek trash data kelas)');
    }

    public function trash()
    {
        $kelas = Kelas::onlyTrashed()->get();
        $gurus = Guru::OrderBy('nama_guru', 'asc')->get();
        return view('admin.kelas.trash', compact('kelas','gurus'));
    }

    public function restore($id)
    {
        $id = Crypt::decrypt($id);
        $kelas = Kelas::withTrashed()->findorfail($id);
        $countJadwal = Jadwal::withTrashed()->where('kelas_id', $kelas->id)->count();
        if ($countJadwal >= 1) {
            Jadwal::withTrashed()->where('kelas_id', $kelas->id)->restore();
        }
        $countSiswa = Siswa::withTrashed()->where('kelas_id', $kelas->id)->count();
        if ($countSiswa >= 1) {
            Siswa::withTrashed()->where('kelas_id', $kelas->id)->restore();
        }
        $kelas->restore();
        return redirect()->back()->with('info', 'Data kelas berhasil direstore! (Silahkan cek data kelas)');
    }

    public function kill($id)
    {
        $kelas = Kelas::withTrashed()->findorfail($id);
        $countJadwal = Jadwal::withTrashed()->where('kelas_id', $kelas->id)->count();
        if ($countJadwal >= 1) {
            Jadwal::withTrashed()->where('kelas_id', $kelas->id)->forceDelete();
        }
        $countSiswa = Siswa::withTrashed()->where('kelas_id', $kelas->id)->count();
        if ($countSiswa >= 1) {
            Siswa::withTrashed()->where('kelas_id', $kelas->id)->forceDelete();
        }
        $kelas->forceDelete();
        return redirect()->back()->with('success', 'Data kelas berhasil dihapus secara permanent');
    }

    public function getEdit(Request $request)
    {
        $kelas = Kelas::where('id', $request->id)->get();
        foreach ($kelas as $val) {
            $newForm[] = array(
                'id' => $val->id,
                'nama' => $val->nama_kelas,
                'jurusan_id' => $val->jurusan_id,
                'guru_id' => $val->guru_id,
            );
        }
        return response()->json($newForm);
    }
}
