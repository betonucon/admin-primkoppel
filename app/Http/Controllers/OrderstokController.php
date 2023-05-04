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
use App\VStok;
use App\Stok;
use App\VBarang;
use App\Orderstok;
use App\VOrderstok;
use App\User;
class OrderstokController extends Controller
{
    public function index(request $request){
        $menu='Daftar Order Stok';
        return view('orderstok.index',compact('menu'));
    }

    public function cari_qr(request $request){
        $data=Barang::where('kode_qr',$request->kode_qr)->count();
        if($data>0){
            return '@'.$data;
        }else{
            return '@0';
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
        $data=Barang::where('id',$request->id)->first();
        return view('orderstok.tambah',compact('data','id','read'));
    }
    public function bayar(request $request){
        error_reporting(0);
        $id=$request->id;
        $data=VOrderstok::where('id',$request->id)->first();
        return view('orderstok.bayar',compact('data','id'));
    }
    public function view(request $request){
        error_reporting(0);
        $nomor=$request->nomor;
        if($request->method==""){
            $method=1;
        }else{
            $method=$request->method;
        }
        $data=Orderstok::where('no_order',$request->nomor)->first();
        return view('orderstok.view',compact('data','nomor','read','method'));
    }
    public function total_harga_kasir(request $request){
        
        $data=VOrderstok::where('id',$request->id)->first();
        return uang($data->total_harga);
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
        $data=VOrderstok::orderBy('id','Desc')->get();
       
        return  Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn='
                            <div class="btn-group btn-group-sm dropup m-r-5">
								<a href="#" data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle">Act <b class="caret"></b></a>
								<div class="dropdown-menu dropdown-menu-right">
									<a href="javascript:;" class="dropdown-item">Action Button</a>
									<div class="dropdown-divider"></div>
                                    <a href="javascript:;" onclick="location.assign(`'.url('orderstok/view').'?nomor='.$data->no_order.'`)" class="dropdown-item"><i class="fas fa-pencil-alt fa-fw"></i> View</a>';
                                    if($data->status==1){
                                        $btn.='<a href="javascript:;" onclick="delete_data('.$data->id.')"  class="dropdown-item"><i class="fas fa-trash-alt fa-fw"></i> Hapus</a>';
                                    }
                                    $btn.='
									
									
								</div>
							</div>
                    ';
                    return $btn;
                })
               
                ->addColumn('uang_total_harga', function($data){
                    return uang($data->total_harga);
                })
                
                ->rawColumns(['action','file'])
                ->make(true);
    }
    public function get_data_stok(request $request){
        $data=VStok::where('no_transaksi',$request->no_transaksi)->where('status',1)->orderBy('nama_barang','Asc')->get();
       
        return  Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn='<span class="btn btn-xs btn-danger" onclick="delete_barang('.$data->id.')"><i class="fas fa-trash-alt fa-fw"></i></span>';
                    return $btn;
                })
                ->addColumn('file', function($data){
                    $btn='<span  class="btn btn-info btn-xs" onclick="show_foto(`'.$data->file.'`,`'.$data->kode_qr.'`)"><i class="fas fa-image"></i></span>';
                    return $btn;
                })
                ->addColumn('uang_harga_modal', function($data){
                    return uang($data->harga_modal);
                })
                ->addColumn('uang_harga_jual', function($data){
                    return uang($data->harga_jual);
                })
                ->addColumn('uang_total', function($data){
                    return uang($data->total);
                })
                ->addColumn('uang_qty', function($data){
                    return uang($data->qty);
                })
                
                ->rawColumns(['action','file'])
                ->make(true);
    }

    public function hapus_data(request $request){
        error_reporting(0);
        $delanggota=Barang::where('id',$request->id)->update(['active'=>0]);
       
    }
    public function hapus_barang(request $request){
        error_reporting(0);
        $delanggota=Stok::where('id',$request->id)->delete();
       
    }
    public function save_data(request $request){
        error_reporting(0);
        
        $rules = [];
        $messages = [];
        
        $rules['distributor']= 'required';
        $messages['distributor .required']= 'Silahkan isi nama distributor';

        $rules['tgl_order']= 'required|date';
        $messages['tgl_order.required']= 'Masukan tanggal order ';
        $messages['tgl_order.date']= 'Masukan tanggal order ';
        
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
                $no_order=no_order();
                $save=Orderstok::create([
                    'no_order'=>$no_order,
                    'tgl_order'=>$request->tgl_order,
                    'distributor'=>$request->distributor,
                    'status'=>1,
                    'tahun'=>date('Y'),
                    'bulan'=>date('m'),
                    'created_at'=>date('Y-m-d H:i:s'),
                    
                ]);
                echo'@ok@'.$no_order;
                
                
            }else{
                $mst=Orderstok::where('id',$request->id)->first();
                $save=Orderstok::UpdateOrcreate([
                    'id'=>$request->id,
                ],[
                    'tgl_order'=>$request->tgl_order,
                    'distributor'=>$request->distributor,
                    
                ]);
                echo'@ok@'.$mst->no_order;
                
            }
        }
    }
    public function save_barang(request $request){
        error_reporting(0);
        
        $rules = [];
        $messages = [];
        
        $rules['kode_barang']= 'required';
        $messages['kode_barang .required']= 'Masukan Kode Barang';

        $rules['qty']= 'required|numeric|min:0|not_in:0';
        $messages['qty.required']= 'Masukan qty ';
        $messages['qty.not_in']= 'Masukan qty ';
        $messages['qty.numeric']= 'Masukan qty ';
        
        $rules['harga_modal']= 'required|min:0|not_in:0';
        $messages['harga_modal.required']= 'Masukan harga modal ';
        $messages['harga_modal.not_in']= 'Masukan harga modal ';

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
            $no_order=$request->no_order;
            $mst=Barang::where('kode_barang',$request->kode_barang)->first();
            $save=Stok::UpdateOrcreate([
                'no_transaksi'=>$no_order,
                'kode_barang'=>$request->kode_barang,
                'status'=>1,
            ],[
                'qty'=>ubah_uang($request->qty),
                'harga_modal'=>ubah_uang($request->harga_modal),
                'total_modal'=>(ubah_uang($request->harga_modal)*ubah_uang($request->qty)),
                'total'=>(ubah_uang($request->harga_modal)*ubah_uang($request->qty)),
                'harga_jual'=>$mst->harga_jual,
                'total_jual'=>($mst->harga_jual*ubah_uang($request->qty)),
                'created_at'=>date('Y-m-d H:i:s'),
                
            ]);
            echo'@ok@';
                
           
        }
    }
    public function save_bayar(request $request){
        error_reporting(0);
        
        
            $save=Orderstok::where('id',$request->id)->update([
                'status'=>2,
               
            ]);
            echo'@ok@';
          
    }

    
}
