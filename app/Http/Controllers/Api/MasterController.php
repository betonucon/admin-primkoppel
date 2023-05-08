<?php
   
namespace App\Http\Controllers\Api;
   
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Nilai;
use App\Cicilan;
use App\Aksesbayar;
use App\Tujuan;
use Illuminate\Support\Facades\Auth;
use Validator;
   
class MasterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function nilai(Request $request)
    {
        $data=Cicilan::orderBy('id','Asc')->get();
        $col = [];
            
            foreach($data as $o){
                
                $cl['waktu'] = $o->id;
                $cl['keterangan'] = $o->id.' Bulan';
                $col[]=$cl;
            }
            
            $success =  $col;
            
        
        

        return $this->sendResponse($success, 'success');
    }
    public function akses_bayar(Request $request)
    {
        $data=Aksesbayar::orderBy('id','Asc')->get();
        $col = [];
            
            foreach($data as $o){
                
                $cl['id'] = $o->id;
                $cl['akses_bayar'] = $o->akses_bayar;
                $col[]=$cl;
            }
            
            $success =  $col;
            
        
        

        return $this->sendResponse($success, 'success');
    }

    public function tujuan(Request $request)
    {
        $data=Tujuan::orderBy('id','Asc')->get();
        $col = [];
            
            foreach($data as $o){
                
                $cl['id'] = $o->id;
                $cl['tujuan'] = $o->name;
                $col[]=$cl;
            }
            
            $success =  $col;
            
        
        

        return $this->sendResponse($success, 'success');
    }

    
    
    
}