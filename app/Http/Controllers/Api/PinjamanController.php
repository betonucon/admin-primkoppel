<?php
   
namespace App\Http\Controllers\Api;
   
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Nilai;
use App\Cicilan;
use App\User;
use App\VUser;
use App\Tujuan;
use App\Pinjaman;
use App\VPinjaman;
use Illuminate\Support\Facades\Auth;
use Validator;
   
class PinjamanController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function reset_pinjaman(Request $request)
    {
        $data=VPinjaman::where('status_nya',1)->orderBy('no_register','Asc')->get();
        foreach($data as $o){
            // echo $o->no_register.'-'.$o->id.'<br>';
            $upd=Pinjaman::where('id',$o->id)->update([
                'sts_pinjaman'=>3,
            ]);
        }
    }
    public function store(Request $request)
    {
        $auth = Auth::user(); 
        $user = VUser::where('username',$auth->username)->first(); 
        
        try{
            $rules = [];
            $messages = [];
                $rules['nominal'] = 'required|numeric';
                $rules['waktu'] = 'required|numeric';

                
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
                    $count=VPinjaman::where('no_register',$auth->username)->whereIn('sts_pinjaman',array(1,2))->count();
                    if($count>0){
                        $errorapp='Masih terdapat pinjaman aktif';
                        return $this->sendResponseerror($errorapp);
                    }else{
                        $nomor='PJ'.date('ymdhis');
                        $bunga=ceil(($request->nominal*10)/100);
                        $cicilan=ceil(($request->nominal/$request->waktu)+$bunga);
                        $save=Pinjaman::UpdateOrcreate([
                            'no_register'=>$auth->username,
                            'sts_pinjaman'=>1,
                            'sts_pencairan'=>0,
                        ],[
                            'nomortransaksi'=>$nomor,
                            'nominal'=>$request->nominal,
                            'bunga_bulanan'=>$bunga,
                            'cicilan'=>$cicilan,
                            'waktu'=>$request->waktu,
                            'periode_masuk'=>0,
                            'dibayar'=>0,
                            
                            'created_at'=>date('Y-m-d H:i:s'),
                            
                        ]);
                    }
                }
        } catch(\Exception $e){
            return $this->sendResponseerror($e->getMessage());
        } 
    }

    
    
    
    
}