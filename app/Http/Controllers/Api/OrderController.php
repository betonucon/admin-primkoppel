<?php
   
namespace App\Http\Controllers\Api;
   
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Nilai;
use App\User;
use App\Cicilan;
use App\Barang;
use App\VUser;
use App\Stok;
use App\VStok;
use App\Tujuan;
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
            $detail['harga_jual']=$o->harga_jual;
            $detail['total']=$o->total;
            $detail['kategori_barang']=$o->kategori_barang;
            $detail['foto']=url_plug().'/_icon/'.$o->file;
            $show[]=$detail;
        }
        $success['total_bayar']=$total;
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
                    $mst = Barang::where('kode_barang',$request->kode_barang)->first(); 
                    $save=Stok::UpdateOrcreate([
                        'no_register'=>$auth->username,
                        'kode_barang'=>$request->kode_barang,
                        'status'=>0,
                    ],[
                        'qty'=>$request->qty,
                        'harga_modal'=>$mst->harga_modal,
                        'harga_jual'=>$mst->harga_jual,
                        'total_modal'=>($request->qty*$mst->harga_modal),
                        'total_jual'=>($request->qty*$mst->harga_jual),
                        'total'=>($request->qty*$mst->harga_jual),
                        'profit'=>(($request->qty*$mst->harga_jual)-($request->qty*$mst->harga_modal)),
                        'created_at'=>date('Y-m-d H:i:s'),
                        
                    ]);
                    return $this->sendResponse(true, 'success');
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
           
                
            $mst = Stok::where('id',$request->id)->delete(); 
            
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
           
                
            $mst = Stok::where('id',$request->id)->update('check',1)->update(); 
            
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
           
                
            $mst = Stok::where('id',$request->id)->update('check',0)->update(); 
            
            return $this->sendResponse(true, 'success');
                
        } catch(\Exception $e){
            return $this->sendResponseerror($e->getMessage());
        } 
    }

    public function store(Request $request)
    {
        $auth = Auth::user(); 
        $user = VUser::where('username',$auth->username)->first(); 
        $count=count((array) $request->stok_id);
        try{
            $rules = [];
            $messages = [];
                if($count>0){
                    $total=VStok::whereIn('id',$request->stok_id)->sum('total');
                    $rules['lokasi'] = 'required';
                    $messages['lokasi.required'] = 'Masukan lokasi pengiriman';
                    $rules['akses_bayar_id'] = 'required';
                    $messages['akses_bayar_id.required'] = 'Pilih Metode Pembayaran';
                    if($request->akses_bayar_id==1 && $request->lokasi!=""){
                        if(saldo_sukarela($auth->username)>=$total){
                            $rules['pin'] = 'required|numeric';
                            $messages['pin.required'] = 'Masukan PIN'.saldo_sukarela($auth->username);
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

                    }
                    if($request->akses_bayar_id==2){

                    }
                    if($request->akses_bayar_id==3){

                    }
                    $save=Stok::UpdateOrcreate([
                        'no_register'=>$auth->username,
                        'kode_barang'=>$request->kode_barang,
                        'status'=>0,
                    ],[
                        'qty'=>$request->qty,
                        
                    ]);

                }
        } catch(\Exception $e){
            return $this->sendResponseerror($e->getMessage());
        } 
    }

    
    
    
    
}