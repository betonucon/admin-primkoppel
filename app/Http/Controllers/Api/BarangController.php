<?php
   
namespace App\Http\Controllers\Api;
   
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Nilai;
use App\Cicilan;
use App\VBarang;
use Illuminate\Support\Facades\Auth;
use Validator;
   
class BarangController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function barang(Request $request)
    {
        
        if($request->page==""){
            $page=1;
        }else{
            $page=$request->page;
        }
        $query=VBarang::query();
        if($request->orderby=='1'){
            $data=$query->orderBy('harga_jual','Asc');
        }else{
            $data=$query->orderBy('nama_barang','Asc');
        }
        
        $data=$query->paginate(20);
        $cek=$query->count();
        $col = [];
            
            foreach($data as $o){
                
                $cl['id'] = $o->id;
                $cl['kode_barang'] = $o->kode_barang;
                $cl['nama_barang'] = $o->nama_barang;
                $cl['harga_modal'] = round($o->harga_modal);
                $cl['harga_jual'] = round($o->harga_jual);
                $cl['satuan'] = $o->satuan;
                $cl['stok'] = $o->stok;
                $cl['foto'] = url_plug().'/_icon/'.$o->file;
                $col[]=$cl;
            }
            $success['total_page'] =  ceil($cek/20);
            $success['total_item'] =  $cek;
            $success['current_page'] =  $page;
            $success['result'] =  $col;
            
        
        

        return $this->sendResponse($success, 'success');
    }

    
}