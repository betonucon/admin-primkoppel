<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Pinjaman;
use App\Transaksi;
use App\Pembayaranpinjaman;
use App\Periodepinjaman;
use Validator;
class TransaksiController extends Controller
{
    public function index(request $request){
        $menu='Daftar Transaksi Keuangan';
        if(Auth::user()['role_id']==1 || Auth::user()['role_id']==2){
            if($request->tahun==''){
                $tahun=date('Y');
            }else{
                $tahun=$request->tahun;
            }
            if($request->kategori==''){
                $kategori='all';
            }else{
                $kategori=$request->kategori;
            }
            return view('transaksi.index',compact('menu','tahun','kategori'));
        }
        else{
            return view('pinjaman.index',compact('menu'));
        }
        
    }
    
    public function index_pinjaman(request $request){
        $menu='Saldo Pinjaman';
        if($request->tahun==""){
            $tahun=date('Y');
        }else{
            $tahun=$request->tahun;
        }
        if(Auth::user()['role_id']==1){
            return view('saldo.index',compact('menu','tahun'));
        }
        if(Auth::user()['role_id']==2){
            return view('saldo.index',compact('menu','tahun'));
        }
        if(Auth::user()['role_id']==3){
            return view('pinjaman.index',compact('menu','tahun'));
        }
        
    }

    public function get_data_pinjaman(request $request){
        $data=Pembayaranpinjaman::where('tahun',$request->tahun)->get();
       
        return  Datatables::of($data)->addIndexColumn()
                ->addColumn('keterangan', function($data){
                    return $data['name'].' '.$data->anggota['name'];
                })
                ->addColumn('uang_total', function($data){
                    return uang($data['total']);
                })
                ->addColumn('uang_pinjaman', function($data){
                    return uang($data['pinjaman']);
                })
                ->addColumn('uang_margin', function($data){
                    return uang($data['margin']);
                })
                ->addColumn('bulannya', function($data){
                    return bulan($data['bulan']);
                })
                
                ->addColumn('status', function($data){
                    if($data['sts']==1){
                        return '<font color="#000">Masuk</font>';
                    }else{
                        return '<font color="red">Keluar</font>';
                    }
                })
                ->addColumn('action', function($data){
                    return'<span class="btn btn-yellow btn-xs" onclick="tambah('.$data['nik'].')"><i class="fas fa-pencil-alt fa-fw"></i></span>';
                })
                ->rawColumns(['action','status'])
                ->make(true);
    }

    public function get_data(request $request){
        if($request->kategori=='all'){
            $data=Transaksi::where('tahun',$request->tahun)->orderBy('id','Desc')->get();
        }
        else{
            $data=Transaksi::where('tahun',$request->tahun)->where('kategori_id',$request->kategori)->orderBy('id','Desc')->get();
        }
        $data=Transaksi::get();
       
        return  Datatables::of($data)->addIndexColumn()
                ->addColumn('nama_transaksi', function($data){
                    return $data['name'].' '.$data['kodetransaksi'];
                })
                ->addColumn('nominal_uang', function($data){
                    return uang($data['nominal']);
                })
                ->addColumn('margin_uang', function($data){
                    return uang($data['margin']);
                })
                ->addColumn('kategori', function($data){
                    return $data->kategori['name'];
                })
                ->addColumn('status', function($data){
                    if($data['sts']==1){
                        return '<font color="blue">Masuk</font>';
                    }else{
                        return '<font color="red">Keluar</font>';
                    }
                    
                })
                ->rawColumns(['nama_transaksi','nominal_uang','margin_uang','kategori','status'])
                ->make(true);
    }

    public function proses_tagihan(request $request){
        error_reporting(0);
        $count=count($request->id);
        if (trim($count) == '0') {$error[] = '- Pilih tagihan yang akan dibayar';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:12px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            for($x=0;$x<$count;$x++){
                $data=Periodepinjaman::find($request->id[$x]);
                $transaksi=Transaksi::create([
                    'kodetransaksi'=>$data['nomorpinjaman'],
                    'kategori_id'=>1,
                    'name'=>'Pembayaran pinjaman '.$data['name'].' '.$data->pinjaman['nik'].' '.$data->pinjaman->user['name'],
                    'bulan'=>date('m'),
                    'tahun'=>date('Y'),
                    'tanggal'=>date('Y-m-d'),
                    'nominal'=>$data['nominal'],
                    'sts'=>1,
                ]);

                if($transaksi){
                    $periode=Periodepinjaman::where('id',$request->id[$x])->update([
                        'sts'=>1,
                    ]);
                }
            }

            echo'ok';
        }
    }

    public function simpan(request $request){
        error_reporting(0);
        
        $rules = [
            'name'=> 'required',
            'nominal'=> 'required|numeric',
            'kategori_id'=> 'required|numeric',
            'bulan'=> 'required|numeric',
            'tahun'=> 'required|numeric',
            'sts'=> 'required|numeric',
        ];

        $messages = [
            'name.required'=> 'Isi Nama Transaksi', 
            'nominal.required'=> 'Isi Nominal transaksi', 
            'nominal.numeric'=> 'Nominal transaksi Hanya Numeric', 
            'kategori_id.required'=> 'Pilih Kategori ', 
            'kategori_id.numeric'=> 'Kategori Hanya Numeric',  
            'bulan.required'=> 'Pilih bulan', 
            'bulan.numeric'=> 'Bulan Hanya Angka', 
            'tahun.required'=> 'Pilih tahun', 
            'tahun.numeric'=> 'Tahun Hanya Angka',  
            'sts.required'=> 'Pilih Status', 
            'sts.numeric'=> 'Status Hanya Angka',  
            
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
            $cekcount=Transaksi::where('tahun',$request->tahun)->count();
            if($cekcount>0){
                $cek=Transaksi::where('tahun',$request->tahun)->orderBy('id','Desc')->firstOrfail();
                $urutan = (int) substr($cek['kodetransaksi'], 8, 4);
                $urutan++;
                $nomor=kode_kategori($request->kategori_id).date('Ym').sprintf("%04s", $urutan);
               
            }else{
                $nomor=kode_kategori($request->kategori_id).date('Ym').sprintf("%04s", 1);
            }
            $transaksi=Transaksi::create([
                'kodetransaksi'=>$nomor,
                'kategori_id'=>$request->kategori_id,
                'name'=>$request->name,
                'bulan'=>$request->bulan,
                'tahun'=>$request->tahun,
                'tanggal'=>$request->tanggal,
                'nominal'=>$request->nominal,
                'margin'=>$request->nominal,
                'sts'=>$request->sts,
            ]);

            echo'ok';
        }
    }
    public function simpan_saldo(request $request){
        error_reporting(0);
        
        $rules = [
            'name'=> 'required',
            'nominal'=> 'required|numeric',
            'bulan'=> 'required|numeric',
            'tahun'=> 'required|numeric',
        ];

        $messages = [
            'name.required'=> 'Isi Nama Transaksi', 
            'nominal.required'=> 'Isi Nominal transaksi', 
            'nominal.numeric'=> 'Nominal transaksi Hanya Numeric', 
            'bulan.required'=> 'Pilih bulan', 
            'bulan.numeric'=> 'Bulan Hanya Angka', 
            'tahun.required'=> 'Pilih tahun', 
            'tahun.numeric'=> 'Tahun Hanya Angka',  
            
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
            $bayar=Pembayaranpinjaman::create([
                'nik'=>1000001,
                'bulan'=>$request->bulan,
                'tahun'=>$request->tahun,
                'total'=>$request->nominal,
                'pinjaman'=>$request->nominal,
                'margin'=>0,
                'cost'=>Auth::user()['cost'],
                'tanggal'=>date('Y-m-d'),
                'pinjaman_id'=>'0',
                'angsuran'=>'0',
                'sts'=>1,
                'kategori'=>2,
                'name'=>$request->name,
            ]);

            echo'ok';
        }
    }

    public function tampil_tagihan(request $request){
        $data=Periodepinjaman::where('name','October 2021')->where('sts',0)->get();
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
                                <td>'.$o->pinjaman->user['name'].'</td>
                                <td>'.$o['nomorpinjaman'].'</td>
                                <td>'.$o['name'].'</td>
                                <td>'.uang($o['nominal']).'</td>
                                <td>'.$o['ke'].'</td>
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
        $data=Periodepinjaman::where('nomorpinjaman',$request->nomorpinjaman)->orderBy('id','Asc')->get();
        echo'    
            <table class="table table-striped table-bordered table-td-valign-middle" id="dataheader">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor</th>
                        <th>Periode</th>
                        <th>Nominal</th>
                        <th>Ke-</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>';
                
                    foreach($data as $no=>$o){
                        echo'
                            <tr>
                                <td>'.($no+1).'</td>
                                <td>'.$o['nomorpinjaman'].'</td>
                                <td>'.$o['name'].'</td>
                                <td>'.uang($o['nominal']).'</td>
                                <td>'.$o['ke'].'</td>
                                <td>';
                                    if($o['sts']==1){
                                        echo'Lunas';
                                    }else{
                                        echo'Proses'; 
                                    }
                                echo'
                                </td>
                            </tr>
                        ';
                    }
                
                    
                echo'    
                </tbody>
            </table>
        ';
    }
}
