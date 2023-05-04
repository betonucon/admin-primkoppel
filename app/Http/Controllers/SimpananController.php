<?php

namespace App\Http\Controllers;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Milon\Barcode\DNS1D;
use Validator;
use App\Vanggota;
use App\Barang;
use App\VBarang;
use App\Anggota;
use App\Simpananwajib;
use App\Simpanansukarela;
use App\VSimpanansukarela;
use App\VSimpananwajib;
use App\Agt;
use App\User;
use App\VUser;
class SimpananController extends Controller
{
    public function index(request $request){
        $menu='Simpanan Anggota';
        return view('simpanan.index',compact('menu'));
    }

    public function cari_qr(request $request){
        $data=Barang::where('kode_qr',$request->kode_qr)->count();
        if($data>0){
            return '@'.$data;
        }else{
            return '@0';
        }
        
    }

    public function get_import(request $request){
        $data=Agt::orderBy('no_register','Asc')->get();;
        foreach($data as $no=>$o){
            
            if($o->bulan==0){
                $bulan=01;
            }else{
                $bulan=$o->bulan;
            }
            if($o->tahun==0){
                $tahun=2020;
            }else{
                $tahun=$o->tahun;
            }
            $masuk=$tahun.'-'.$bulan.'-01';
            $no_register=date('y').sprintf("%05s",  $o->no_register);
            $save=Anggota::UpdateOrcreate([
                'no_register'=>$no_register,
            ],[
                'nama'=>$o->nama,
                'perusahaan'=>$o->perusahaan,
                'bulan'=>$bulan,
                'tahun'=>$tahun,
                'tgl_masuk'=>$masuk,
                'active'=>1,
                'created_at'=>date('Y-m-d H:i:s'),
                
            ]);
        }
        
    }
    public function get_user(request $request){
        $data=Anggota::orderBy('id','Asc')->get();;
        foreach($data as $no=>$o){
            
            $save=User::UpdateOrcreate([
                'username'=>$o->no_register,
            ],[
                'name'=>$o->nama,
                'email'=>$o->no_register.'@gmail.com',
                'role_id'=>4,
                'sts_anggota'=>1,
                'active'=>1,
                'password'=>Hash::make('admin'),
                'created_at'=>date('Y-m-d H:i:s'),
                
            ]);
        }
        
    }
    public function tambah(request $request){
        error_reporting(0);
        $id=$request->id;
        if($id!=0){
            $read='readonly';
        }else{
            $read='';
        }
        $data=VUser::where('sts_anggota',1)->orderBy('name','Asc')->get();
        return view('simpanan.tambah',compact('data','id','read'));
    }
    public function tambah_wajib(request $request){
        error_reporting(0);
       
        if($request->bulan==""){
            $bulan=date('m');
        }else{
            $bulan=$request->bulan;
        }
        if($request->tahun==""){
            $tahun=date('Y');
        }else{
            $tahun=$request->tahun;
        }
        if($request->perusahaan==""){
            $perusahaan='ASDP';
        }else{
            $perusahaan=$request->perusahaan;
        }
        
       
        $data=VUser::where('sts_anggota',1)->where('perusahaan','LIKE','%'.$perusahaan.'%')->orderBy('perusahaan','Asc')->get();
        return view('simpanan.tambah_wajib',compact('data','bulan','tahun','perusahaan'));
    }
    public function view_file(request $request){
        error_reporting(0);
        $view='
        <img src="'.url('/public/_icon').'/'.$request->file.'" width="100%" height="300px">
        <div class="viewqr">
            '.barcoderr($request->kode_qr).'
        </div>
        ';
        return $view;
    }

    public function get_data(request $request){
        error_reporting(0);
        $data=VUser::where('anggota_active',1)->orderBy('no_register','Asc')->get();
       
        return  Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn='
                            <div class="btn-group btn-group-sm dropup m-r-5">
								<a href="#" data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle">Act <b class="caret"></b></a>
								<div class="dropdown-menu dropdown-menu-right">
									<a href="javascript:;" class="dropdown-item">Action Button</a>
									<div class="dropdown-divider"></div>
                                    <a href="javascript:;" onclick="view_wajib('.$data->no_register.')" class="dropdown-item"><i class="fas fa-search fa-fw"></i> Detail  Wajib</a>
									<a href="javascript:;" onclick="view_sukarela('.$data->no_register.')"  class="dropdown-item"><i class="fas fa-search fa-fw"></i> Detail  Sukarela</a>
									
								</div>
							</div>
                    ';
                    return $btn;
                })
                ->addColumn('file', function($data){
                    $btn='<span  class="btn btn-info btn-xs" onclick="show_foto(`'.$data->file.'`,`'.$data->kode_qr.'`)"><i class="fas fa-image"></i></span>';
                    return $btn;
                })
                ->addColumn('uang_wajib', function($data){
                    return uang($data->saldo_wajib);
                })
                ->addColumn('uang_sukarela', function($data){
                    return uang($data->saldo_sukarela);
                })
                ->addColumn('uang_pokok', function($data){
                    return uang($data->saldo_pokok);
                })
                
                
                ->rawColumns(['action','file'])
                ->make(true);
    }
    public function get_data_wajib(request $request){
        error_reporting(0);
        $data=VSimpananwajib::where('no_register',$request->no_register)->orderBy('id','Asc')->get();
       
        return  Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn='
                            <div class="btn-group btn-group-sm dropup m-r-5">
								<a href="#" data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle">Act <b class="caret"></b></a>
								<div class="dropdown-menu dropdown-menu-right">
									<a href="javascript:;" class="dropdown-item">Action Button</a>
									<div class="dropdown-divider"></div>
                                    <a href="javascript:;" onclick="view_wajib('.$data->no_register.')" class="dropdown-item"><i class="fas fa-search fa-fw"></i> Detail  Wajib</a>
									<a href="javascript:;" onclick="view_sukarela('.$data->no_register.')"  class="dropdown-item"><i class="fas fa-search fa-fw"></i> Detail  Sukarela</a>
									
								</div>
							</div>
                    ';
                    return $btn;
                })
                ->addColumn('uang_nominal', function($data){
                    return uang($data->nominal);
                })
                
                
                ->rawColumns(['action'])
                ->make(true);
    }
    public function get_data_sukarela(request $request){
        error_reporting(0);
        $data=VSimpanansukarela::where('no_register',$request->no_register)->orderBy('id','Asc')->get();
       
        return  Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn='<span class="btn btn-danger btn-xs" onclick="delete_sukarela('.$data->id.',`'.$data->no_register.'`)">Hapus</span>';
                    return $btn;
                })
                ->addColumn('uang_nominal', function($data){
                    return uang($data->nominal);
                })
                ->addColumn('statusnya', function($data){
                    if($data->sts==1){
                        return 'MASUK';
                    }else{
                        return 'KELUAR';
                    }
                })
                
                
                ->rawColumns(['action'])
                ->make(true);
    }

    public function hapus_wajib(request $request){
        error_reporting(0);
        $delanggota=Simpananwajib::where('id',$request->id)->delete();
        echo'@'.$request->bulan.'@'.$request->tahun;
    }
    public function delete_sukarela(request $request){
        error_reporting(0);
        $delanggota=Simpanansukarela::where('id',$request->id)->delete();
        echo'@'.$request->no_register.'@';
    }
    public function store_sukarela(request $request){
        error_reporting(0);
        
        $rules = [];
        $messages = [];
        
        $rules['no_register']= 'required';
        $messages['no_register.required']= 'Pilih nama anggota';
        $rules['nominal']= 'required|min:0|not_in:0';
        $messages['nominal.required']= 'Masukan nilai ';
        $messages['nominal.not_in']= 'Masukan nilai ';
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
            $nomor='M'.date('ymd000001');
            $save=Simpanansukarela::create([
                'no_register'=>$request->no_register,
           
                'nomortransaksi'=>$nomor,
                'nominal'=>ubah_uang($request->nominal),
                'kategori_status'=>1,
                'sts'=>1,
                'bulan'=>date('m'),
                'tahun'=>date('Y'),
                'created_at'=>date('Y-m-d H:i:s'),
                
            ]);
                echo'@ok';
           
        }
    }

    public function store_wajib(request $request){
        $nomor='M'.date('ymd000001');
        $save=Simpananwajib::UpdateOrcreate([
            'no_register'=>$request->no_register,
            'bulan'=>$request->bulan,
            'tahun'=>$request->tahun,
        ],[
            'nomortransaksi'=>$nomor,
            'nominal'=>nilai_wajib(),
            'kategori_status'=>1,
            'sts'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
            
        ]);
        echo'@'.$request->bulan.'@'.$request->tahun.'@'.$request->perusahaan;
    }
    public function save_wajib_all(request $request){
        error_reporting(0);
        $count=count((array) $request->no_register);
        $nomor='M'.date('ymd000001');
        if($count>0){
            for($x=0;$x<$count;$x++){
                $save=Simpananwajib::UpdateOrcreate([
                    'no_register'=>$request->no_register[$x],
                    'bulan'=>$request->bulan,
                    'tahun'=>$request->tahun,
                ],[
                    'nomortransaksi'=>$nomor,
                    'nominal'=>nilai_wajib(),
                    'kategori_status'=>1,
                    'sts'=>1,
                    'created_at'=>date('Y-m-d H:i:s'),
                    
                ]);
            }
            echo'@ok@'.$request->bulan.'@'.$request->tahun.'@'.$request->perusahaan;
        }else{
            echo'<div style="padding:1%;background:##f3f3f3">Error !<br> Ceklis Data Anggota</div>';
        }
        

        // $nomor='M'.date('ymd000001');
        // $save=Simpananwajib::UpdateOrcreate([
        //     'no_register'=>$request->no_register,
        //     'bulan'=>$request->bulan,
        //     'tahun'=>$request->tahun,
        // ],[
        //     'nomortransaksi'=>$nomor,
        //     'nominal'=>nilai_wajib(),
        //     'kategori_status'=>1,
        //     'sts'=>1,
        //     'created_at'=>date('Y-m-d H:i:s'),
            
        // ]);
        
    }

    
}
