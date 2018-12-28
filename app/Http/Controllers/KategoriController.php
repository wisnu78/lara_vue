<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;

class KategoriController extends Controller
{
    public function index(){
        $kategori = Kategori::latest()->orderBy('created_at','desc')->get();
        $data = array('results'=>$kategori);
        return response()->json($data);
    }

    public function store(Request $request){
        $kategori = new Kategori;
        $kategori->kategori = $request->kategori;
        $kategori->status = 'on';
        $kategori->save();
        $data = array('status'=>'ok');
        return response()->json($data);
    }

    public function destroy($id){
        $kategori = Kategori::find($id);
        $kategori->delete();
        $data = array('status'=>'ok');
        return response()->json($data);
    }

    public function update($id,Request $request){
        $kategori = Kategori::find($id);
        $kategori->kategori = $request->kategori;
        $kategori->status = 'on';
        $kategori->update();
        $data = array('status'=>'ok');
        return response()->json($data);
    }
}
