<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Imports\GuruImport;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mapels = Mapel::orderBy('nama_mapel')->get();
        $max = Guru::count();

        return view('admin.guru.index', compact('mapels', 'max'));
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
        $this->validate($request, [
            'nip' => 'required|unique:guru',
            'nama_guru' => 'required',
            'mapel_id.*' => 'required',
            'jk' => 'required',
        ]);

        $guru = Guru::create([
            'nip' => $request->nip,
            'nama_guru' => $request->nama_guru,
            'jk' => $request->jk,
            'telp' => $request->telp,
            'tmp_lahir' => $request->tmp_lahir,
            'tgl_lahir' => $request->tgl_lahir,
        ]);

        foreach ($request->mapel_id as $i) {
            $mapel = Mapel::find($i);
            $guru->mapel()->attach($mapel);
        }

        return redirect()->back()->with('success', 'Berhasil menambahkan data guru baru!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $guru = Guru::findorfail($id);
        //dd($id);
        return view('admin.guru.details', compact('guru'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $guru = Guru::findorfail($id);
        $mapels = Mapel::all();

        return view('admin.guru.edit', compact('guru', 'mapels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama_guru' => 'required',
            'mapel_id.*' => 'required',
            'jk' => 'required',
        ]);

        $guru = Guru::findorfail($id);
        $guru_data = [
            'nama_guru' => $request->nama_guru,
            'jk' => $request->jk,
            'telp' => $request->telp,
            'tmp_lahir' => $request->tmp_lahir,
            'tgl_lahir' => $request->tgl_lahir,
        ];

        $guru->update($guru_data);
        $guru->mapel()->sync($request->mapel_id);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $guru = Guru::findorfail($id);
        $guru->delete();

        return back()->with('warning', 'Data guru berhasil dihapus! (Silahkan cek trash data guru)');
    }

    public function trash()
    {
        $gurus = Guru::onlyTrashed()->get();
        $mapels = Mapel::all();
        //dd($gurus[0]->mapel);
        return view('admin.guru.trash', compact('gurus', 'mapels'));
    }

    public function restore($id)
    {
        $id = Crypt::decrypt($id);
        $guru = Guru::withTrashed()->findorfail($id);
        $guru->restore();

        return redirect()->back()->with('info', 'Data guru berhasil direstore! (Silahkan cek data guru)');
    }

    public function kill($id)
    {
        $guru = Guru::withTrashed()->findorfail($id);
        $guru->forceDelete();

        return redirect()->back()->with('success', 'Data guru berhasil dihapus secara permanent');
    }

    public function mapel($id)
    {
        $id = Crypt::decrypt($id);
        $mapel = Mapel::findorfail($id);
        $gurus = Mapel::find($id)->guru()->orderBy('nip', 'asc')->where('deleted_at', null)->get();

        return view('admin.guru.show', compact('mapel', 'gurus'));
    }

    public function getMapelGuru(Request $request)
    {
        $mapels = Guru::find($request->id)->mapel->pluck('id', 'nama_mapel');

        return response()->json($mapels);
    }

    public function import_excel(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx',
        ]);
        $file = $request->file('file');
        $nama_file = rand().$file->getClientOriginalName();
        $file->move('file_guru', $nama_file);
        Excel::import(new GuruImport, public_path('/file_guru/'.$nama_file));

        return redirect()->back()->with('success', 'Data Guru Berhasil Diimport!');
    }
}
