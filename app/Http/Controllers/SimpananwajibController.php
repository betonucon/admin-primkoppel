<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Simpananwajib;
use App\VSim;
use Session;
use Validator;
use App\Imports\SimpananwajibImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
class SimpananwajibController extends Controller
{
    public function index(request $request){
        $menu='Simpanan wajib';
        return view('simpananwajib.index',compact('menu'));
    }
    public function get_import(request $request){
        $data=VSim::orderBy('no_register','Asc')->get();
        $nomor='M'.date('ymdhis');
        foreach($data as $no=>$o){
            
            $save=Simpananwajib::UpdateOrcreate([
                'no_register'=>$o->no_register,
            ],[
                'nomortransaksi'=>$nomor,
                'nominal'=>$o->wajib,
                'kategori_status'=>1,
                'sts'=>1,
                'bulan'=>date('m'),
                'tahun'=>date('Y'),
                'created_at'=>date('Y-m-d H:i:s'),
                
            ]);
        }
        
    }
    
}
