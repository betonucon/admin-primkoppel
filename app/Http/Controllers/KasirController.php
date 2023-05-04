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
use App\Kasir;
use App\VKasir;
use App\User;
class KasirController extends Controller
{
    public function index(request $request){
        $menu='Daftar Order Stok';
        return view('kasir.index',compact('menu'));
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
        return view('kasir.tambah',compact('data','id','read'));
    }
    public function bayar(request $request){
        error_reporting(0);
        $id=$request->id;
        $data=VKasir::where('id',$request->id)->first();
        return view('kasir.bayar',compact('data','id'));
    }
    public function view(request $request){
        error_reporting(0);
        $nomor=$request->nomor;
        if($request->method==""){
            $method=1;
        }else{
            $method=$request->method;
        }
        $data=Kasir::where('no_order',$request->nomor)->first();
        return view('kasir.view',compact('data','nomor','read','method'));
    }
    public function total_harga_kasir(request $request){
        
        $data=VKasir::where('id',$request->id)->first();
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
        $data=VKasir::orderBy('id','Desc')->get();
       
        return  Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn='
                            <div class="btn-group btn-group-sm dropup m-r-5">
								<a href="#" data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle">Act <b class="caret"></b></a>
								<div class="dropdown-menu dropdown-menu-right">
									<a href="javascript:;" class="dropdown-item">Action Button</a>
									<div class="dropdown-divider"></div>
                                    <a href="javascript:;" onclick="location.assign(`'.url('kasir/view').'?nomor='.$data->no_order.'`)" class="dropdown-item"><i class="fas fa-pencil-alt fa-fw"></i> View</a>';
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
        $data=VStok::where('no_transaksi',$request->no_transaksi)->where('status',2)->orderBy('nama_barang','Asc')->get();
       
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
                ->addColumn('uang_profit', function($data){
                    return uang($data->profit);
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
        if($request->kategori==1){
            $rules['konsumen']= 'required';
            $messages['konsumen .required']= 'Silahkan isi nama konsumen';
        }else{
            $rules['no_register']= 'required';
            $messages['no_register .required']= 'Silahkan isi nama konsumen';
        }
        

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
                if($request->kategori==1){
                    $no_register="K2300001";
                    $konsumen=$request->konsumen;
                }else{
                    $no_register=$request->no_register;
                    $konsumen=nama_user($request->no_register);
                }
                $no_order=no_kasir();
                $save=Kasir::create([
                    'no_order'=>$no_order,
                    'tgl_order'=>$request->tgl_order,
                    'kategori'=>$request->kategori,
                    'no_register'=>$no_register,
                    'konsumen'=>$konsumen,
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
        
        $rules['harga_jual']= 'required|min:0|not_in:0';
        $messages['harga_jual.required']= 'Masukan harga jual ';
        $messages['harga_jual.not_in']= 'Masukan harga jual ';

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
            $selisih=(ubah_uang($request->harga_jual)-$mst->harga_modal);
            $profit=($selisih*ubah_uang($request->qty));
            if(ubah_uang($request->qty)>$request->stok){
                echo'<div style="padding:1%;background:##f3f3f3">Error !<br> Stok tidak mencukupi</div>';
            }else{
                $save=Stok::UpdateOrcreate([
                    'no_transaksi'=>$no_order,
                    'kode_barang'=>$request->kode_barang,
                    'status'=>2,
                ],[
                    'qty'=>ubah_uang($request->qty),
                    'harga_jual'=>ubah_uang($request->harga_jual),
                    'total_modal'=>($mst->harga_modal*ubah_uang($request->qty)),
                    'total'=>(ubah_uang($request->harga_jual)*ubah_uang($request->qty)),
                    'harga_modal'=>$mst->harga_modal,
                    'profit'=>$profit,
                    'total_jual'=>($mst->harga_jual*ubah_uang($request->qty)),
                    'created_at'=>date('Y-m-d H:i:s'),
                    
                ]);
                echo'@ok@';
            }
                
           
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
