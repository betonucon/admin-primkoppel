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
use App\VSatuan;
use App\Satuan;
use App\User;
class MasterController extends Controller
{
    public function index_satuan(request $request){
        $menu='Daftar Satuan';
        return view('master.index_satuan',compact('menu'));
    }
    public function index_group(request $request){
        $menu='Daftar group';
        return view('master.index_group',compact('menu'));
    }

    
    
    public function tambah_satuan(request $request){
        error_reporting(0);
        $id=$request->id;
        if($id!=0){
            $read='readonly';
        }else{
            $read='';
        }
        $data=Satuan::where('id',$request->id)->first();
        return view('master.tambah_satuan',compact('data','id','read'));
    }
    public function tambah_group(request $request){
        error_reporting(0);
        $id=$request->id;
        if($id!=0){
            $read='readonly';
        }else{
            $read='';
        }
        $data=Group::where('id',$request->id)->first();
        return view('master.tambah_group',compact('data','id','read'));
    }
    
    public function get_data_satuan(request $request){
        $data=VSatuan::where('active',1)->orderBy('satuan','Asc')->get();
       
        return  Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn='
                            <div class="btn-group btn-group-sm dropup m-r-5">
								<a href="#" data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle">Act <b class="caret"></b></a>
								<div class="dropdown-menu dropdown-menu-right">
									<a href="javascript:;" class="dropdown-item">Action Button</a>
									<div class="dropdown-divider"></div>
                                    <a href="javascript:;" onclick="tambah('.$data->id.')" class="dropdown-item"><i class="fas fa-pencil-alt fa-fw"></i> Ubah</a>
									<a href="javascript:;" onclick="delete_data('.$data->id.')"  class="dropdown-item"><i class="fas fa-trash-alt fa-fw"></i> Hapus</a>
									
								</div>
							</div>
                    ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }
    public function get_data_group(request $request){
        $data=VGroup::orderBy('group','Asc')->get();
       
        return  Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn='
                            <div class="btn-group btn-group-sm dropup m-r-5">
								<a href="#" data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle">Act <b class="caret"></b></a>
								<div class="dropdown-menu dropdown-menu-right">
									<a href="javascript:;" class="dropdown-item">Action Button</a>
									<div class="dropdown-divider"></div>
                                    <a href="javascript:;" onclick="tambah('.$data->id.')" class="dropdown-item"><i class="fas fa-pencil-alt fa-fw"></i> Ubah</a>
									<a href="javascript:;" onclick="delete_data('.$data->id.')"  class="dropdown-item"><i class="fas fa-trash-alt fa-fw"></i> Hapus</a>
									
								</div>
							</div>
                    ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }
   

    public function hapus_data_satuan(request $request){
        error_reporting(0);
        $delanggota=Satuan::where('id',$request->id)->update(['active'=>0]);
       
    }
    public function hapus_data_group(request $request){
        error_reporting(0);
        $delanggota=Group::where('id',$request->id)->update(['active'=>0]);
       
    }
    
    public function save_data_satuan(request $request){
        error_reporting(0);
        
        $rules = [];
        $messages = [];
        
        $rules['satuan']= 'required';
        $messages['satuan.required']= 'Silahkan isi satuan';

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
           
                $save=Satuan::UpdateOrcreate([
                    'satuan'=>$request->satuan,
                ],[
                    'satuan_pecah'=>$request->satuan_pecah,
                    'active'=>1,
                    
                ]);
                
                echo'@ok';
                
           
        }
    }
    
}
