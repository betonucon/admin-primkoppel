<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RiwayatpinjamanController extends Controller
{
    public function index(request $request){
        $menu='Riwayat Pinjaman';
        return view('riwayatpinjaman.index',compact('menu'));
    }
}
