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
use App\Agt;
use App\User;
use App\VUser;
class AnggotaController extends Controller
{
    public function index(request $request){
        $menu='Anggota';
        return view('anggota.index',compact('menu'));
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
        $data=Anggota::where('id',$request->id)->first();
        return view('anggota.tambah',compact('data','id','read'));
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
                                    <a href="javascript:;" onclick="tambah('.$data->anggota_id.')" class="dropdown-item"><i class="fas fa-pencil-alt fa-fw"></i> Ubah</a>
									<a href="javascript:;" onclick="delete_data('.$data->anggota_id.')"  class="dropdown-item"><i class="fas fa-trash-alt fa-fw"></i> Hapus</a>
									
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

    public function hapus_data(request $request){
        error_reporting(0);
        $delanggota=Anggota::where('id',$request->id)->update(['active'=>0]);
        
    }
    public function save_data(request $request){
        error_reporting(0);
        
        $rules = [];
        $messages = [];
        
        $rules['nama']= 'required';
        $messages['nama.required']= 'Silahkan isi nama anggota';
        $rules['perusahaan']= 'required';
        $messages['perusahaan.required']= 'Silahkan isi perusahaan';
        if($request->email!=""){
            $rules['email']= 'email';
            $messages['email.email']= 'Format email salah';
        }
        if($request->no_hp!=""){
            $rules['no_hp']= 'numeric';
            $messages['no_hp.numeric']= 'Format no handphone salah';
        }
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

    
}
