<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner;
use App\Kategori;
use App\Barang;

class FlutterController extends Controller
{
    public function banner(){
        $banner = Banner::all();
        $data = [];
        foreach ($banner as $banner){
            $data[] = array(
                'gambar'    => 'http://192.168.8.101/laravel/lara_vue/public/api/flutter/banner'.'/'.$banner->gambar
            );
        }

        return response()->json($data);
    }

    public function bannerImg($id){
        return asset('storage/slide').'/'.$id;
    }

    public function kategori(){
        $kategori = Kategori::all();
        return response()->json($kategori);
    }

    public function barang(){
        $barang = Barang::all();
        return response()->json($barang);
    }
}
