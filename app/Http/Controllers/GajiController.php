<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use PDF;
use App\Slipgaji;
use Session;
use Validator;
use App\Imports\GajiImport;
use Maatwebsite\Excel\Facades\Excel;
class GajiController extends Controller
{
    public function index(request $request){
        $menu='Slip Gaji';
        if($request->tahun==''){
            $tahun=date('Y');
        }else{
            $tahun=$request->tahun;
        }
        if($request->bulan==''){
            $bulan=date('m');
        }else{
            $bulan=$request->bulan;
        }
        return view('gaji.index',compact('menu','tahun','bulan'));
    }

    public function cetak(request $request){
        
        $data=Slipgaji::where('nik',$request->nik)->where('bulan',$request->bulan)->where('tahun',$request->tahun)->first();
        
    //    dd($data);
        $pdf = PDF::loadView('gaji.cetak', compact('data'));
        $pdf->setPaper('A4', 'Potrait');
        return $pdf->stream();
    }

    public function import_data(request $request)
    {
       error_reporting(0);
		if($request->file==''){
            echo' Format file upload harus excel';
        }else{
            $filess = $request->file('file');
            
            if($filess->getClientOriginalExtension()=='xlsx'){
            
                $nama_file = rand().$filess->getClientOriginalName();
                $filess->move('file_excel',$nama_file);
                Excel::import(new GajiImport, public_path('/file_excel/'.$nama_file));
                echo'ok';
            }else{
                echo' Format file upload harus excel';
            }
        }
    }
}
