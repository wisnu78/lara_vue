<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang;

class BarangController extends Controller
{
    public function index(){
        $barang = Barang::with('kategori')->latest()->orderBy('created_at','desc')->get();
        $data = array('results'=>$barang);
        return response()->json($data);
    }

    public function getImg($img){
        return asset('images/barang'."/".$img);
    }

    public function store(Request $request){
        $barang = new Barang;
        $barang->nama_barang = $request->nama_barang;
        $barang->spesifikasi  = '';
        
        if ($request->hasFile('file')){
            $request->file('file')->storeAs('public/upload/',$request->file->getClientOriginalName());
            $barang->gambar = $request->file->getClientOriginalName();
        }else{
            $barang->gambar = "Tidak ada";
        }

        

        $barang->stok = $request->stok;
        $barang->status = $request->status;
        $barang->harga = $request->harga;
        $barang->kategori_id = $request->kategori_id;
        $barang->save();
      
        $data = array(
            'status'    => 'ok'
        );

        return response()->json($data);
        
    }

    public function destroy($id){
        $barang = Barang::find($id);
        $barang->delete();
        $data = array(
            'status'    => 'ok'
        );

        return response()->json($data);
    }
}
