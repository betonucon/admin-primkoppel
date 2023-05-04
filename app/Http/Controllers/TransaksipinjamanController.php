<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Pinjaman;
use App\Transaksi;
use App\Periodepinjaman;
use App\Pembayaranpinjaman;
use Validator;
use App\Exports\PinjamanExport;
use Maatwebsite\Excel\Facades\Excel;
class TransaksipinjamanController extends Controller
{
    public function index(request $request){
        $menu='Daftar Pinjaman';
        if(Auth::user()['role_id']==1){
            return view('transaksipinjaman.index',compact('menu'));
        }
        if(Auth::user()['role_id']==2){
            return view('transaksipinjaman.index',compact('menu'));
        }
        if(Auth::user()['role_id']==3){
            return view('pinjaman.index',compact('menu'));
        }
        
    }
    
    
    public function proses_tagihan(request $request){
        error_reporting(0);
        $count=count($request->id);
        if (trim($count) == '0') {$error[] = '- Pilih tagihan yang akan dibayar';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:12px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            for($x=0;$x<$count;$x++){
                $data=Pinjaman::find($request->id[$x]);
                $cicil=($data['jumlah_dibayar']+1);
                $total=$data['terbayar']+$data['total_bunga'];
                $transaksi=Transaksi::create([
                    'kodetransaksi'=>$data['nomorpinjaman'],
                    'kategori_id'=>1,
                    'name'=>'Pembayaran pinjaman '.$data['nik'].' Periode cicilan ke '.$cicil.' '.$data['berikutnya'],
                    'bulan'=>date('m'),
                    'tahun'=>date('Y'),
                    'tanggal'=>date('Y-m-d'),
                    'nominal'=>($data['total_bunga']+$data['bunga']),
                    'margin'=>$data['bunga'],
                    'sts'=>1,
                ]);

                if($transaksi){
                    if($total==$data['nominal']){$sts=5;}else{$sts=4;}
                    $pinjaman=Pinjaman::where('id',$request->id[$x])->update([
                        'berikutnya'=>bulan_kedepan($data['berikutnya'],1),
                        'terbayar'=>($data['terbayar']+$data['total_bunga']),
                        'jumlah_dibayar'=>$cicil,
                        'sts_pinjaman'=>$sts,
                    ]);
                    $bayar=Pembayaranpinjaman::create([
                        'nik'=>$data['nik'],
                        'bulan'=>date('m'),
                        'tahun'=>date('Y'),
                        'total'=>($data['total_bunga']+$data['bunga']),
                        'pinjaman'=>$data['total_bunga'],
                        'margin'=>$data['bunga'],
                        'cost'=>Auth::user()['cost'],
                        'tanggal'=>date('Y-m-d'),
                        'pinjaman_id'=>$data['id'],
                        'angsuran'=>$cicil,
                        'sts'=>1,
                        'kategori'=>1,
                        'name'=>'Pembayaran angsuran '.$cicil,
                    ]);
                }
            }

            echo'ok';
        }
    }

    public function proses_bayar(request $request){
        error_reporting(0);
        
        $rules = [
            'jumlah_dibayar'=> 'required|numeric',
            'tertagih'=> 'required|numeric',
        ];

        $messages = [
            'jumlah_dibayar.required'=> 'Pilih jumlah bulan', 
            'tertagih.required'=> 'Pilih jumlah bulan',   
            
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $val=$validator->Errors();


        if ($validator->fails()) {
            
            foreach(parsing_validator($val) as $value){
                foreach($value as $isi){
                    echo'-&nbsp;'.$isi.'<br>';
                }
            }
        }else{
                $data=Pinjaman::find($request->id);
                $cicil=($data['jumlah_dibayar']+$request->jumlah_dibayar);
                $dibayar=($data['total_bunga']*$request->jumlah_dibayar);
                $total=$data['terbayar']+$dibayar;
                $bayar=Pembayaranpinjaman::create([
                    'nik'=>$data['nik'],
                    'bulan'=>date('m'),
                    'tahun'=>date('Y'),
                    'total'=>($dibayar+$data['bunga']),
                    'pinjaman'=>$dibayar,
                    'margin'=>$data['bunga'],
                    'cost'=>Auth::user()['cost'],
                    'tanggal'=>date('Y-m-d'),
                    'pinjaman_id'=>$data['id'],
                    'angsuran'=>$cicil,
                    'sts'=>1,
                    'kategori'=>1,
                    'name'=>'Pembayaran angsuran '.$cicil.' '.$data->user['name'],
                ]);

                if($bayar){
                    if($total==$data['nominal']){$sts=5;}else{$sts=4;}
                    $pinjaman=Pinjaman::where('id',$request->id)->update([
                        'berikutnya'=>bulan_kedepan($data['berikutnya'],$request->jumlah_dibayar),
                        'terbayar'=>($data['terbayar']+$dibayar),
                        'jumlah_dibayar'=>$cicil,
                        'sts_pinjaman'=>$sts,
                    ]);

                    echo'ok@'.$data['nomorpinjaman'];
                }
        }
    }

    public function tampil_tagihan(request $request){
        $data=Pinjaman::whereYear('berikutnya',date('Y'))->whereMonth('berikutnya',date('m'))->where('sts_pinjaman',4)->get();
        echo'    
            <table class="table table-striped table-bordered table-td-valign-middle" id="dataheader">
                <thead>
                    <tr>
                        <th>No</th>
                        <th><input type="checkbox" id="pilihsemua"/></th>
                        <th>Karyawan</th>
                        <th>Nomor</th>
                        <th>Periode</th>
                        <th>Nominal</th>
                        <th>Ke-</th>
                    </tr>
                </thead>
                <tbody>';
                
                    foreach($data as $no=>$o){
                        echo'
                            <tr>
                                <td>'.($no+1).'</td>
                                <td><input type="checkbox" class="pilih"  name="id[]" value="'.$o['id'].'"> </td>
                                <td>'.$o['nik'].'</td>
                                <td>'.$o['nomorpinjaman'].'</td>
                                <td>'.$o['berikutnya'].'</td>
                                <td>'.uang($o['total_bunga']+$o['bunga']).'</td>
                                <td>'.($o['jumlah_dibayar']+1).'</td>
                            </tr>
                        ';
                    }
                
                    
                echo'    
                </tbody>
            </table>
        ';
        echo'
            <script>
                $(function(){
    
                    $("#pilihsemua").click(function () { 
                        $(".pilih").attr("checked", this.checked);
                    });
                    $(".pilih").click(function(){
                    
                    if($(".pilih").length == $(".pilih:checked").length) {
                        $("#pilihsemua").attr("checked", "checked");
                    } else {
                        $("#pilihsemua").removeAttr("checked");
                    }
                    
                    });
                });
                $(document).ready(function () {
                    

                    $("#dataheader").DataTable({
                        lengthMenu: [20, 40, 60],
                        fixedHeader: {
                            header: true,
                            headerOffset: $("#header").height()
                        },
                        responsive: false,
                        langth: false,
                        paging: false,
                        order: false,
                        ordering: false,
                        info: false,
                    });
                });
            </script>
            
        ';
    }

    public function view_tagihan(request $request){
        $data=Pinjaman::where('nomorpinjaman',$request->nomorpinjaman)->first();
        echo'  
            <input type="hidden" name="id" value="'.$data['id'].'">
            <div class="row" style="margin-bottom:1%">
                <div class="col-4">
                    <select name="jumlah_dibayar" onchange="pilih_bulan(this.value)" class="form-control">
                        <option value="">Pilih-----</option>';
                        for($x=1;$x<=($data['waktu']-$data['jumlah_dibayar']);$x++){
                            echo'<option value="'.$x.'">'.$x.' Bulan</option>';
                        }
                    echo'
                    </select>
                </div>
                <div class="col-5">
                    <input type="text" class="form-control" name="tertagih" id="tertagih">
                </div>
                <div class="col-2">
                    <span class="btn btn-blue" onclick="bayar()">Bayar</span>
                </div>
            </div>  
            <table class="table table-striped table-bordered table-td-valign-middle" id="dataheader">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Periode</th>
                        <th>Nominal</th>
                        <th>1% Pinjaman</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>';
                    $jumlah=0;
                    for($x=1;$x<=$data['waktu'];$x++){
                        if($x>$data['jumlah_dibayar']){
                            $sts='<font style="color:red;font-weight:bold">Belum Lunas</font>';
                            $jumlah+=$data['total_bunga'];
                        }else{
                            $sts='<font style="color:blue;font-weight:bold">Lunas</font>';
                            $jumlah+=0;
                        }
                        echo'
                            <tr>
                                <td>'.$x.'</td>
                                <td>'.bulan_kedepan($data['tgl_cair'],$x).'</td>
                                <td>'.uang($data['total_bunga']).'</td>
                                <td>'.uang($data['bunga']).'</td>
                                <td>'.$sts.'</td>
                            </tr>
                        ';
                    }
                
                    
                echo'    
                </tbody>
            </table>
            @Nilai Pelunasan : Rp.'.uang($jumlah+$data['bunga']).'
            <script>
                
                function pilih_bulan(jum){
                    var tagih="'.$data['total_bunga'].'";
                    var bunga="'.$data['bunga'].'";
                        total=tagih*jum;
                        sub=parseInt(total)+parseInt(bunga);
                        $("#tertagih").val(sub);
                }
            </script>
        ';
    }

    public function export_excel_pinjaman(request $request)
	{
        $tanggal=$request->tanggal;
		return Excel::download(new PinjamanExport($tanggal), 'TAGIHAN'.date('Ym27').'.xlsx');
	}
    
}
