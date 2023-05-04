<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Saldowajib;
use App\User;
use App\Transaksi;
use App\Anggota;
use App\Karyawan;
use App\Simpanansukarela;
use App\Simpananwajib;
use App\Periodepinjaman;
use Illuminate\Support\Facades\Hash;
class MasterController extends Controller
{
    public function buatanggota(request $request){
        $data=User::all();
        foreach($data as $no=>$o){
            $save  = New Simpanansukarela;
            $save->bulan = '02';
            $save->nominal = '0';
            $save->tahun = 2022;
            $save->nomortransaksi = 'SS202109'.sprintf("%05s", ($no+1));
            $save->nik = $o['username'];
            $save->save();
        }
    }
    // public function buatanggota(request $request){
    //     $data=Anggota::all();
    //     foreach($data as $o){
    //         $save  = New User;
    //         $save->name = $o['name'];
    //         $save->username = $o['nik'];
    //         $save->status = $o['status'];
    //         $save->email = $o['nik'].'@gmail.com';
    //         $save->role_id = 4;
    //         $save->sts_anggota = 1;
    //         $save->password = Hash::make($o['nik']);
    //         $save->save();
    //     }
    // }
    public function map(request $request){
        $data=Karyawan::orderBy('nik','asc')->get();
        
        foreach($data as $no=>$o){
            
            // $transaksi=User::where('username',$o['nik'])->update([
            //     'email'=>$o['email'],
            //     'name'=>$o['name'],
            //     'role_id'=>4,
            //     'sts_anggota'=>4,
            //     'sts_password'=>0,
            //     'aktif'=>0,
            //     'status'=>'Kontrak',
            // ]);
            
        }

        // $data=Periodepinjaman::where('sts',1)->orderBy('id','asc')->get();
        // foreach($data as $no=>$o){
            
        //     $transaksi=Transaksi::create([
        //         'kodetransaksi'=>$o['nomorpinjaman'],
        //         'kategori_id'=>1,
        //         'name'=>'Pembayaran Pinjaman '.$o['name'].' '.$o->pinjaman->user['name'],
        //         'bulan'=>date('m',strtotime($o['tanggal'])),
        //         'tahun'=>date('Y',strtotime($o['tanggal'])),
        //         'tanggal'=>$o['tanggal'],
        //         'nominal'=>$o['nominal'],
        //         'margin'=>$o['margin'],
        //         'sts'=>1,
        //     ]);
            
        // }
        // $data=Pinjaman::orderBy('id','asc')->get();
        // foreach($data as $no=>$o){
            
        //     $transaksi=Transaksi::create([
        //         'kodetransaksi'=>$o['nomorpinjaman'],
        //         'kategori_id'=>1,
        //         'name'=>'Pengajuan Pinjaman  '.$o->user['name'],
        //         'bulan'=>date('m',strtotime($o['tgl_pengajuan'])),
        //         'tahun'=>date('Y',strtotime($o['tgl_pengajuan'])),
        //         'tanggal'=>$o['tgl_pengajuan'],
        //         'nominal'=>$o['nominal'],
        //         'sts'=>2,
        //     ]);
            
        // }
    }

    public function ubah_rupiah(request $request){
        $data=number_format($request->nominal,0);
        echo $data;
    }
}
