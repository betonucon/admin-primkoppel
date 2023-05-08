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
        $data=VStok::where('no_register',$auth->username)->where('status',0)->get();
        $success=[];
        $show=[];
        foreach($data as $o){
            $detail=[];
            $detail['kode_barang']=$o->kode_barang;
            $detail['nama_barang']=$o->nama_barang;
            $detail['satuan']=$o->satuan;
            $detail['qty']=$o->qty;
            $detail['harga_jual']=$o->harga_jual;
            $detail['total']=$o->total;
            $detail['kategori_barang']=$o->kategori_barang;
            $detail['foto']=url_plug().'/_icon/'.$o->file;
            $show[]=$detail;
        }
        $success=$show;
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

    public function store(Request $request)
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