<?php

namespace App\Http\Controllers;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Milon\Barcode\DNS1D;
use Validator;
use App\Pinjaman;
use App\Transaksi;
use App\Periodepinjaman;
use App\Pembayaranpinjaman;
use App\Simpanansukarela;
use App\VGetpinjaman;
use App\VPinjaman;
use App\VUser;
use PDF;
class PinjamanController extends Controller
{
    public function index(request $request){
        $menu='Daftar Pinjaman';
        return view('pinjaman.index',compact('menu'));
    }
    public function index_riwayat(request $request){
        $menu='Riwayat Pinjaman';
        return view('pinjaman.index_riwayat',compact('menu'));
    }
    public function tambah(request $request){
        error_reporting(0);
        $menu='Ajukan Pinjaman';
        $id=$request->id;
        $data=VPinjaman::where('id',$request->id)->first();
        $get=VUser::where('sts_anggota',1)->where('pinjaman_aktif',0)->orderBy('name','Asc')->get();
        return view('pinjaman.tambah',compact('menu','get','data','id'));
    }
    public function bayar(request $request){
        error_reporting(0);
        $menu='Ajukan Pinjaman';
        $id=$request->id;
        $data=VPinjaman::where('id',$request->id)->first();
        $get=Pembayaranpinjaman::where('pinjaman_id',$request->id)->get();
        
        return view('pinjaman.tambah_bayar',compact('menu','data','id','get'));
    }
    public function get_import(request $request){
        $data=VGetpinjaman::orderBy('no_register','Asc')->get();
        $nomor='PJ'.date('ymdhis');
        foreach($data as $no=>$o){
            
            $save=Pinjaman::UpdateOrcreate([
                'no_register'=>$o->no_register,
            ],[
                'nomortransaksi'=>$nomor,
                'nominal'=>$o->pinjaman,
                'waktu'=>$o->tenor,
                'dibayar'=>$o->dibayar,
                'sts_pinjaman'=>2,
                'created_at'=>date('Y-m-d H:i:s'),
                
            ]);
        }
        
    }
    public function get_detail_import(request $request){
        $data=VPinjaman::orderBy('no_register','Asc')->get();
        $bulan='04';
        $tahun=2023;
        foreach($data as $no=>$o){
            
            $save=Pembayaranpinjaman::UpdateOrcreate([
                'pinjaman_id'=>$o->id,
                'angsuran_ke'=>$o->angsuran_masuk,
                'no_register'=>$o->no_register,
            ],[
                'bulan'=>$bulan,
                'tahun'=>$tahun,
                'total_angsuran'=>$o->waktu,
                'nilai_koperasi'=>$o->nilai_koperasi,
                'nilai_sukarela'=>$o->nilai_sukarela,
                'angsuran_pokok'=>$o->pokok_cicilan,
                'bunga'=>$o->bunga,
                'created_at'=>date('Y-m-d H:i:s'),
                
            ]);
        }
        
    }

    public function get_data(request $request){
        error_reporting(0);
        $data=VPinjaman::whereIn('sts_pinjaman',array(1,2))->where('status_nya',0)->orderBy('id','Desc')->get();
       
        return  Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($data){
                        if(in_array($data->sts_pinjaman,array(0,1))){
                            $btn='
                            <div class="btn-group btn-group-sm dropup m-r-5">
                                <a href="#" data-toggle="dropdown" class="btn btn-green btn-xs dropdown-toggle">Act <b class="caret"></b></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="javascript:;" class="dropdown-item">Action Button</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="javascript:;" onclick="tambah('.$data->id.')" class="dropdown-item"><i class="fas fa-pencil-alt fa-fw"></i> Ubah</a>
                                    <a href="javascript:;" onclick="approve('.$data->id.')" class="dropdown-item"><i class="fas fa-pencil-alt fa-fw"></i> Ubah</a>
                                    <a href="javascript:;" onclick="delete_data('.$data->id.')"  class="dropdown-item"><i class="fas fa-trash-alt fa-fw"></i> Hapus</a>
                                    
                                </div>
                            </div>
                        ';
                        }else{
                            $btn='
                            <div class="btn-group btn-group-sm dropup m-r-5">
                                <a href="#" data-toggle="dropdown" class="btn btn-blue btn-xs dropdown-toggle">Bayar <b class="caret"></b></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="javascript:;" class="dropdown-item">Action Button</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="javascript:;" onclick="tambah_bayar('.$data->id.')" class="dropdown-item"><i class="fas fa-money fa-fw"></i> Form Pembayaran</a>
                                    
                                </div>
                            </div>
                        ';
                        }
                    
                        
                    return $btn;
                })
                ->addColumn('uang_nominal', function($data){
                    return uang($data->nominal);
                })
                ->addColumn('uang_angsuran', function($data){
                    return uang($data->angsuran);
                })
                ->addColumn('uang_pokok', function($data){
                    return uang($data->cicilan_pokok);
                })
                ->addColumn('waktu_pinjaman', function($data){
                    return $data->angsuran_masuk.'/'.$data->waktu;
                })
                
                
                ->rawColumns(['action','file'])
                ->make(true);
    }
    public function get_data_riwayat(request $request){
        error_reporting(0);
        $data=VPinjaman::where('status_nya',1)->orderBy('id','Desc')->get();
       
        return  Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn='
                            <div class="btn-group btn-group-sm dropup m-r-5">
								<a href="#" data-toggle="dropdown" class="btn btn-green btn-xs dropdown-toggle">Act <b class="caret"></b></a>
								<div class="dropdown-menu dropdown-menu-right">
									<a href="javascript:;" class="dropdown-item">Action Button</a>
									<div class="dropdown-divider"></div>
                                    <a href="javascript:;" onclick="tambah_bayar('.$data->id.')" class="dropdown-item"><i class="fas fa-money fa-fw"></i> Riwayat Pembayaran</a>
								</div>
							</div>
                    ';
                    return $btn;
                })
                ->addColumn('uang_nominal', function($data){
                    return uang($data->nominal);
                })
                ->addColumn('uang_angsuran', function($data){
                    return uang($data->angsuran);
                })
                ->addColumn('uang_pokok', function($data){
                    return uang($data->cicilan_pokok);
                })
                ->addColumn('waktu_pinjaman', function($data){
                    return $data->angsuran_masuk.'/'.$data->waktu;
                })
                
                
                ->rawColumns(['action','file'])
                ->make(true);
    }
    public function delete_cicilan(request $request){
        error_reporting(0);
        $sukarela=Simpanansukarela::where('transaksi_id',$request->id)->where('kategori_status',2)->delete();
        $detail=Pembayaranpinjaman::where('id',$request->id)->delete();
        
       
    }
    public function save_data(request $request){
        error_reporting(0);
        
        $rules = [];
        $messages = [];
        
        $rules['no_register']= 'required';
        $messages['no_register.required']= 'Pilih anggota';
        
        $rules['nominal']= 'required|min:0|not_in:0';
        $messages['nominal.required']= 'Masukan nominal ';
        $messages['nominal.not_in']= 'Masukan nominal ';

        $rules['waktu']= 'required|min:0|not_in:0';
        $messages['waktu.required']= 'Masukan waktu ';
        $messages['waktu.not_in']= 'Masukan waktu ';

        $rules['tgl_pengajuan']= 'required|date';
        $messages['tgl_pengajuan.required']= 'Masukan tanggal pengajuan ';
        $messages['tgl_pengajuan.date']= 'Masukan tanggal salah ';

        $validator = Validator::make($request->all(), $rules, $messages);
        $val=$validator->Errors();


        if ($validator->fails()) {
            echo'<div style="padding:1%;background:##f3f3f3">Error !<br>';
            foreach(parsing_validator($val) as $value){
                foreach($value as $isi){
                    echo'-&nbsp;'.$isi.'<br>';
                }
            }
            echo'</div>';
        }else{
            if($request->id==0){
                    $no_register=no_register();
                    if($request->email!=""){
                        $email=$request->email;
                    }else{
                        $email=$no_register.'@gmail.com';
                    }
                    $save=Anggota::create([
                        'nama'=>$request->nama,
                        'no_register'=>$no_register,
                        'perusahaan'=>$request->perusahaan,
                        'email'=>$email,
                        'no_hp'=>$request->no_hp,
                        'active'=>1,
                        'bulan'=>date('m'),
                        'tahun'=>date('Y'),
                        'tgl_masuk'=>date('Y-m-d'),
                        'created_at'=>date('Y-m-d H:i:s'),
                        
                    ]);

                    $saveuser=User::UpdateOrcreate([
                        'username'=>$no_register,
                    ],[
                        'name'=>$request->nama,
                        'email'=>$email,
                        'role_id'=>4,
                        'sts_anggota'=>1,
                        'active'=>1,
                        'password'=>Hash::make('admin'),
                        'created_at'=>date('Y-m-d H:i:s'),
                        
                    ]);
                    echo'@ok';
                   
                
                
            }else{
                $mst=Anggota::where('id',$request->id)->first();
                $save=Anggota::UpdateOrcreate([
                    'id'=>$request->id,
                ],[
                    'nama'=>$request->nama,
                    'no_hp'=>$request->no_hp,
                    'perusahaan'=>$request->perusahaan,
                    'updated_at'=>date('Y-m-d H:i:s'),
                    
                ]);
                $saveuser=User::UpdateOrcreate([
                    'username'=>$mst->no_register,
                ],[
                    'name'=>$request->nama,
                    'updated_at'=>date('Y-m-d H:i:s'),
                    
                ]);
                echo'@ok';
                
            }
        }
    }

    public function save_bayar(request $request){
        error_reporting(0);
        
        $rules = [];
        $messages = [];
        
        $rules['angsuran_masuk']= 'required';
        $messages['angsuran_masuk.required']= 'Pilih angsuran';
        
        $validator = Validator::make($request->all(), $rules, $messages);
        $val=$validator->Errors();


        if ($validator->fails()) {
            echo'<div style="padding:1%;background:##f3f3f3">Error !<br>';
            foreach(parsing_validator($val) as $value){
                foreach($value as $isi){
                    echo'-&nbsp;'.$isi.'<br>';
                }
            }
            echo'</div>';
        }else{
            
                $mst=VPinjaman::where('id',$request->id)->first();
                $kali=$request->angsuran_masuk-$mst->angsuran_masuk;
                if($request->angsuran_masuk>$mst->waktu){
                    echo'<div style="padding:1%;background:##f3f3f3">Error !<br> Angsuran maximal adalah '.$mst->masuk.'</div>';
                }else{
                    $pokok=($kali*$mst->pokok_cicilan);
                    $angsuran=$pokok+$mst->bunga;
                    $save=Pembayaranpinjaman::UpdateOrcreate([
                        'pinjaman_id'=>$mst->id,
                        'angsuran_ke'=>$request->angsuran_masuk,
                        'no_register'=>$mst->no_register,
                    ],[
                        'bulan'=>date('m'),
                        'tahun'=>date('Y'),
                        'total_angsuran'=>$mst->waktu,
                        'nilai_koperasi'=>$mst->nilai_koperasi,
                        'nilai_sukarela'=>$mst->nilai_sukarela,
                        'angsuran_pokok'=>$pokok,
                        'bunga'=>$mst->bunga,
                        'created_at'=>date('Y-m-d H:i:s'),
                        
                    ]);
                    $sukarela=Simpanansukarela::create([
                        'no_register'=>$mst->no_register,
                   
                        'nomortransaksi'=>$mst->nomortransaksi,
                        'transaksi_id'=>$save->id,
                        'nominal'=>$mst->nilai_sukarela,
                        'kategori_status'=>2,
                        'sts'=>1,
                        'bulan'=>date('m'),
                        'tahun'=>date('Y'),
                        'created_at'=>date('Y-m-d H:i:s'),
                        
                    ]);
                    $sukarela=Simpanansukarela::create([
                        'no_register'=>'admin',
                   
                        'nomortransaksi'=>$mst->nomortransaksi,
                        'transaksi_id'=>$save->id,
                        'nominal'=>$mst->nilai_koperasi,
                        'kategori_status'=>2,
                        'sts'=>1,
                        'bulan'=>date('m'),
                        'tahun'=>date('Y'),
                        'created_at'=>date('Y-m-d H:i:s'),
                        
                    ]);
                    echo'@ok';
                }
                
                // $save=Anggota::UpdateOrcreate([
                //     'id'=>$request->id,
                // ],[
                //     'nama'=>$request->nama,
                //     'no_hp'=>$request->no_hp,
                //     'perusahaan'=>$request->perusahaan,
                //     'updated_at'=>date('Y-m-d H:i:s'),
                    
                // ]);
                // $saveuser=User::UpdateOrcreate([
                //     'username'=>$mst->no_register,
                // ],[
                //     'name'=>$request->nama,
                //     'updated_at'=>date('Y-m-d H:i:s'),
                    
                // ]);
                // echo'@ok';
                
           
        }
    }
}
