<?php
   
namespace App\Http\Controllers\Api;
   
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Nilai;
use App\User;
use App\Cicilan;
use App\Barang;
use App\VUser;
use App\VBarang;
use App\Orderstok;
use App\Stok;
use App\Kasir;
use App\VKasir;
use App\VStok;
use App\Tujuan;
use App\VOrderstok;
use Illuminate\Support\Facades\Auth;
use Validator;
   
class OrderController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function keranjang(Request $request)
    {
        $auth = Auth::user(); 
        $user = VUser::where('username',$auth->username)->first(); 
        $totalcheck=VStok::where('check',1)->where('no_register',$auth->username)->where('status',0)->sum('total');
        $total=VStok::where('no_register',$auth->username)->where('status',0)->sum('total');
        $data=VStok::where('no_register',$auth->username)->where('status',0)->get();
        $success=[];
        $show=[];
        foreach($data as $o){
            $detail=[];
            $detail['id']=$o->id;
            $detail['kode_barang']=$o->kode_barang;
            $detail['nama_barang']=$o->nama_barang;
            $detail['satuan']=$o->satuan;
            $detail['qty']=$o->qty;
            $detail['check']=$o->check;
            $detail['harga_jual']=(int) $o->harga_jual;
            $detail['total']=(int) $o->total;
            $detail['kategori_barang']=$o->kategori_barang;
            $detail['foto']=url_plug().'/_icon/'.$o->file;
            $show[]=$detail;
        }
        $success['total_check']=(int) $totalcheck;
        $success['total_bayar']=(int) $total;
        $success['item']=$show;
        return $this->sendResponse($success, 'success');
    }
    public function order(Request $request)
    {
        $auth = Auth::user(); 
        $user = VUser::where('username',$auth->username)->first(); 
        $belum=VKasir::where('no_register',$auth->username)->where('status_bayar_id',1)->count();
        $lunas=VKasir::where('no_register',$auth->username)->where('status_bayar_id',2)->count();
        $data=VKasir::where('no_register',$auth->username)->get();
        $success=[];
        $show=[];
        foreach($data as $o){
            $detail=[];
            $detail['id']=$o->id;
            $detail['akses_bayar']=$o->akses_bayar;
            $detail['status_bayar']=$o->status_bayar;
            $detail['akses_bayar_id']=$o->akses_bayar_id;
            $detail['status_bayar_id']=$o->status_bayar_id;
            $detail['konsumen']=$o->konsumen;
            $detail['created']=$o->created_at;
            $detail['waktu']=facebook_time_ago($o->created_at);
            $detail['total_barang']=(int) $o->total_barang;
            $detail['total_harga']=(int) $o->total_harga;
            $detail['icon_bayar']=url_plug().'/_icon/'.$o->icon;
            $show[]=$detail;
        }
        $success['total_belum_dibayar']=(int) $belum;
        $success['total_sudah_dibayar']=(int) $lunas;
        $success['item']=$show;
        return $this->sendResponse($success, 'success');
    }
    public function store_keranjang(Request $request)
    {
        $auth = Auth::user(); 
        $user = VUser::where('username',$auth->username)->first(); 
        
        try{
            $rules = [];
            $messages = [];
                $rules['kode_barang'] = 'required';
                $rules['qty'] = 'required|numeric';
                
                
                $validator = Validator::make($request->all(), $rules,$messages);
                $val=$validator->Errors();
                if($validator->fails()){
                    $error="";
                    foreach(parsing_validator($val) as $value){
                        foreach($value as $isi){
                        $error.=$isi."\n";
                        }
                    }
                    return $this->sendResponseerror($error);
                }else{
                    $mst = VBarang::where('kode_barang',$request->kode_barang)->first(); 
                    if($mst->stok>=$request->qty){
                        $save=Stok::UpdateOrcreate([
                            'no_register'=>$auth->username,
                            'kode_barang'=>$request->kode_barang,
                            'status'=>0,
                        ],[
                            'qty'=>$request->qty,
                            'check'=>0,
                        
                            'harga_modal'=>$mst->harga_modal,
                            'harga_jual'=>$mst->harga_jual,
                            'total_modal'=>($request->qty*$mst->harga_modal),
                            'total_jual'=>($request->qty*$mst->harga_jual),
                            'total'=>($request->qty*$mst->harga_jual),
                            'profit'=>(($request->qty*$mst->harga_jual)-($request->qty*$mst->harga_modal)),
                            'created_at'=>date('Y-m-d H:i:s'),
                            
                        ]);
                        return $this->sendResponse(true, 'success');
                    }else{
                        if($mst->stok>0){
                            return $this->sendResponse(1, 'Stok tidak mencukupi');
                        }else{
                            return $this->sendResponse(0, 'Stok kosong');
                        }
                    }
                    
                }
        } catch(\Exception $e){
            return $this->sendResponseerror($e->getMessage());
        } 
    }
    public function delete_keranjang(Request $request)
    {
        $auth = Auth::user(); 
        $user = VUser::where('username',$auth->username)->first(); 
        
        try{
           
                
            $mst = Stok::where('no_register',$auth->username)->where('status',0)->where('check',1)->delete(); 
            
            return $this->sendResponse(true, 'success');
                
        } catch(\Exception $e){
            return $this->sendResponseerror($e->getMessage());
        } 
    }
    public function check_keranjang(Request $request)
    {
        $auth = Auth::user(); 
        $user = VUser::where('username',$auth->username)->first(); 
        
        try{
           
                
            $mst = Stok::where('id',$request->id)->update(['check'=>1]); 
            
            return $this->sendResponse(true, 'success');
                
        } catch(\Exception $e){
            return $this->sendResponseerror($e->getMessage());
        } 
    }
    public function checkall_keranjang(Request $request)
    {
        $auth = Auth::user(); 
        $user = VUser::where('username',$auth->username)->first(); 
        
        try{
           
                
            $mst = Stok::where('no_register',$auth->username)->where('status',0)->update(['check'=>1]); 
            
            return $this->sendResponse(true, 'success');
                
        } catch(\Exception $e){
            return $this->sendResponseerror($e->getMessage());
        } 
    }
    public function uncheckall_keranjang(Request $request)
    {
        $auth = Auth::user(); 
        $user = VUser::where('username',$auth->username)->first(); 
        
        try{
           
                
            $mst = Stok::where('no_register',$auth->username)->where('status',0)->update(['check'=>0]); 
            
            return $this->sendResponse(true, 'success');
                
        } catch(\Exception $e){
            return $this->sendResponseerror($e->getMessage());
        } 
    }
    public function uncheck_keranjang(Request $request)
    {
        $auth = Auth::user(); 
        $user = VUser::where('username',$auth->username)->first(); 
        
        try{
           
                
            $mst = Stok::where('id',$request->id)->update(['check'=>0]);  
            
            return $this->sendResponse(true, 'success');
                
        } catch(\Exception $e){
            return $this->sendResponseerror($e->getMessage());
        } 
    }

    public function store(Request $request)
    {
        $auth = Auth::user(); 
        $user = VUser::where('username',$auth->username)->first(); 
        $count=Stok::where('no_register',$auth->username)->where('status',0)->where('check',1)->count();
        try{
            $rules = [];
            $messages = [];
                if($count>0){
                    $total=VStok::where('no_register',$auth->username)->where('status',0)->where('check',1)->sum('total');
                    $rules['lokasi'] = 'required';
                    $messages['lokasi.required'] = 'Masukan lokasi pengiriman';
                    $rules['akses_bayar_id'] = 'required';
                    $messages['akses_bayar_id.required'] = 'Pilih Metode Pembayaran';
                    if($request->akses_bayar_id==1 && $request->lokasi!=""){
                        if(saldo_sukarela($auth->username)>=$total){
                            $rules['pin'] = 'required|numeric';
                            $messages['pin.required'] = 'Masukan PIN';
                            if($request->pin!=$auth->pin){
                                $rules['orderes'] = 'required';
                                $messages['orderes.required'] = 'PIN yang anda masukan salah';
                            }
                        }else{
                            $rules['orderes'] = 'required';
                            $messages['orderes.required'] = 'Saldo tidak mencukupi';
                        }
                    }
                    
                    

                    
                }else{
                    $rules['orderes'] = 'required';
                    $messages['orderes.required'] = 'Pilih Barang Yang akan dicheckout';
                }
                

                
                $validator = Validator::make($request->all(), $rules,$messages);
                $val=$validator->Errors();
                if($validator->fails()){
                    $error="";
                    foreach(parsing_validator($val) as $value){
                        foreach($value as $isi){
                        $error.=$isi."\n";
                        }
                    }
                    return $this->sendResponseerror($error);
                }else{
                    if($request->akses_bayar_id==1){
                        $status_bayar=2;
                    }
                    if($request->akses_bayar_id==2){
                        $status_bayar=1;
                    }
                    if($request->akses_bayar_id==3){
                        $status_bayar=1;
                    }
                    $no_transaksi=no_kasir();
                    $save=Kasir::UpdateOrcreate([
                        'no_register'=>$auth->username,
                        'konsumen'=>$auth->name,
                        'no_order'=>$no_transaksi,
                    ],[
                        'akses_bayar_id'=>$request->akses_bayar_id,
                        'kategori'=>$auth->sts_anggota,
                        'akses_order_id'=>2,
                        'status_bayar_id'=>$status_bayar,
                        'tgl_order'=>date('Y-m-d'),
                        'created_at'=>date('Y-m-d H:i:s'),
                        'status'=>1,
                        'bulan'=>date('m'),
                        'tahun'=>date('Y'),
                    ]);
                    $totalcheck=VStok::where('check',1)->where('no_register',$auth->username)->where('status',0)->update(['no_transaksi'=>$no_transaksi,'status'=>2]);
                    return $this->sendResponse(true, 'success');
                }
        } catch(\Exception $e){
            return $this->sendResponseerror($e->getMessage());
        } 
    }

    
    
    
    
}