<?php

namespace App\Http\Controllers;

use App\Models\detailTagihan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $detailTagihan = detailTagihan::all()->sortBy('keterangan');

        return view('admin.pembayaran.index', compact('detailTagihan'));
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
            'jumlah' => 'numeric',
            'keterangan' => 'nullable',
        ]);

        $detailTagihan = detailTagihan::find($request->detail_tagihan_id);
        $totalTagihan = $detailTagihan->tagihan->jumlah - $detailTagihan->pembayaran->sum('jumlah');

        if ($request->jumlah > $totalTagihan) {
            return redirect()->back()->with('error', 'pembayaran melebihi tunggakan!');
        } else {
            $bayar = Pembayaran::create([
                'detail_tagihan_id' => $request->detail_tagihan_id,
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan,
            ]);
            $bayar->save();

            $totalBayarAkhir = Pembayaran::where('detail_tagihan_id', $request->detail_tagihan_id)->sum('jumlah');
            if ($detailTagihan->tagihan->jumlah == $totalBayarAkhir) {
                $detailTagihan->keterangan = 'lunas';
                $detailTagihan->save();

                return redirect()->back()->with('success', 'pembayaran lunas!');
            } else {
                return redirect()->back()->with('success', 'pembayaran berhasil, cek di histori!');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function view(Request $request)
    {
        $pembayarans = Pembayaran::where('detail_tagihan_id', $request->id)->get();

        foreach ($pembayarans as $pembayaran) {
            if (! $pembayaran->keterangan) {
                $ket = '-';
            } else {
                $ket = $pembayaran->keterangan;
            }

            $newForm[] = [
                'jumlah' => $pembayaran->jumlah,
                'keterangan' => $ket,
                'tanggal' => date('d M Y H:i:s', strtotime($pembayaran->created_at)),
            ];
        }

        return response()->json($newForm);
    }
}
