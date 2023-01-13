<?php

namespace App\Http\Controllers;

use App\Jurusan;
use App\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MapelController extends Controller
{
    public function index()
    {
        $mapels = Mapel::get();
        $jurusans = Jurusan::all();

        //dd($mapels[0]->jurusan[0]->id);

        return view('admin.mapel.index', compact('mapels', 'jurusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required',
            'jurusan_id' => 'required',
            'kelompok' => 'required',
        ]);
        $mapel = Mapel::updateOrCreate(
            [
                'id' => $request->mapel_id,
            ],
            [
                'jurusan_id' => $request->jurusan_id,
                'nama_mapel' => $request->nama_mapel,
                'kelompok' => $request->kelompok,
            ]
        );

        return back()->with('success', 'Data Mata Pelajaran berhasil disimpan!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $mapels = Mapel::findorfail($id);
        $jurusans = Jurusan::all();

        return view('admin.mapel.edit', compact('mapels', 'jurusans'));
    }

    public function destroy($id)
    {
        $mapels = Mapel::findorfail($id);
        /*$countGuru = Guru::where('mapel_id', $mapels->id)->count();
        if ($countGuru >= 1) {
            $guru = Guru::where('mapel_id', $mapels->id)->delete();
        }*/
        $mapels->delete();

        return back()->with('warning', 'Data mapel berhasil dihapus! (Silahkan cek trash data mapel)');
    }

    public function trash()
    {
        $mapels = Mapel::onlyTrashed()->get();

        return view('admin.mapel.trash', compact('mapels'));
    }

    public function restore($id)
    {
        $id = Crypt::decrypt($id);
        $mapels = Mapel::withTrashed()->findorfail($id);
        /*$countGuru = Guru::withTrashed()->where('mapel_id', $mapels->id)->count();
        if ($countGuru >= 1) {
            $guru = Guru::withTrashed()->where('mapel_id', $mapels->id)->restore();
        }*/
        $mapels->restore();

        return back()->with('info', 'Data mapel berhasil direstore! (Silahkan cek data mapel)');
    }

    public function kill($id)
    {
        $mapels = Mapel::withTrashed()->findorfail($id);
        /*$countGuru = Guru::withTrashed()->where('mapel_id', $mapels->id)->count();
        if ($countGuru >= 1) {
            $guru = Guru::withTrashed()->where('mapel_id', $mapels->id)->forceDelete();
        }*/
        $mapels->forceDelete();

        return back()->with('success', 'Data mapel berhasil dihapus secara permanent');
    }
}
