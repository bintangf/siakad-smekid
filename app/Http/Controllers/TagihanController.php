<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\Siswa;
use App\Tagihan;
use App\detailTagihan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelas = Kelas::OrderBy('nama_kelas', 'asc')->get();
        $tagihan = Tagihan::all();

        return view('admin.tagihan.index', compact('tagihan', 'kelas'));
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
                'nama' => 'required',
                'jumlah' => 'numeric',
                'keterangan' => 'nullable',
            ]);
        } else {
            $this->validate($request, [
                'nama' => 'required|unique:tagihans,nama',
                'jumlah' => 'numeric',
                'keterangan' => 'nullable',
            ]);
        }

        Tagihan::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'nama' => $request->nama,
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan,
            ]
        );

        return redirect()->back()->with('success', 'Data tagihan berhasil diperbarui!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function show(Tagihan $tagihan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function edit(Tagihan $tagihan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tagihan $tagihan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tagihan = Tagihan::findorfail($id);
        $tagihan->delete();

        return redirect()->back()->with('warning', 'Data tagihan berhasil dihapus! (Silahkan cek trash data kelas)');
    }

    public function trash()
    {
        $tagihan = Tagihan::onlyTrashed()->get();

        return view('admin.tagihan.trash', compact('tagihan'));
    }

    public function restore($id)
    {
        $id = Crypt::decrypt($id);
        $tagihan = Tagihan::withTrashed()->findorfail($id);
        $tagihan->restore();

        return redirect()->back()->with('info', 'Data tagihan berhasil direstore! (Silahkan cek data tagihan)');
    }

    public function kill($id)
    {
        $tagihan = Tagihan::withTrashed()->findorfail($id);
        $tagihan->forceDelete();

        return redirect()->back()->with('success', 'Data tagihan berhasil dihapus secara permanent');
    }

    public function getEdit(Request $request)
    {
        $tagihan = Tagihan::where('id', $request->id)->get();
        foreach ($tagihan as $val) {
            $newForm[] = array(
                'id' => $val->id,
                'nama' => $val->nama,
                'jumlah' => $val->jumlah,
                'keterangan' => $val->keterangan,
            );
        }
        return response()->json($newForm);
    }

    public function tagih(Request $request)
    {
        if (Str::contains($request->siswa_id, 'kelas')) {
            $siswas = Siswa::where('kelas_id', explode(".", $request->siswa_id)[1])->get();
            foreach ($siswas as $siswa) {
                detailTagihan::create(
                    [
                        'siswa_id' => $siswa->id,
                        'tagihan_id' => $request->tagihan_id
                    ]
                );
            }
        } else {
            detailTagihan::create(
                [
                    'siswa_id' => $request->siswa_id,
                    'tagihan_id' => $request->tagihan_id
                ]
            );
        }

        return redirect()->back()->with('success', 'Berhasil di tagihkan!');
    }
}
