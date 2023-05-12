<?php

function uang($nilai){
   return number_format($nilai,0);

}
function aplikasi()
{
   $data=App\Cost::where('id',Auth::user()['cost'])->first();
   return $data['name'];
}
function name_app()
{
   return 'PRIMKOPPEL';
}
function bulan($bulan)
{
   Switch ($bulan){
      case '01' : $bulan="Januari";
         Break;
      case '02' : $bulan="Februari";
         Break;
      case '03' : $bulan="Maret";
         Break;
      case '04' : $bulan="April";
         Break;
      case '05' : $bulan="Mei";
         Break;
      case '06' : $bulan="Juni";
         Break;
      case '07' : $bulan="Juli";
         Break;
      case '08' : $bulan="Agustus";
         Break;
      case '09' : $bulan="September";
         Break;
      case 10 : $bulan="Oktober";
         Break;
      case 11 : $bulan="November";
         Break;
      case 12 : $bulan="Desember";
         Break;
      }
   return $bulan;
}
function o_bulan($bulan)
{
   Switch ($bulan){
      case 'Januari' : $bulan="01";
         Break;
      case 'Februari' : $bulan="02";
         Break;
      case 'Maret' : $bulan="03";
         Break;
      case 'April' : $bulan="04";
         Break;
      case 'Mei' : $bulan="05";
         Break;
      case 'Juni' : $bulan="06";
         Break;
      case 'Juli' : $bulan="07";
         Break;
      case '08' : $bulan="Agustus";
         Break;
      case 'Agustus' : $bulan="09";
         Break;
      case 'Oktober' : $bulan="11";
         Break;
      case 'November' : $bulan="12";
         Break;
      case 'Desember' : $bulan="12";
         Break;
      }
   return $bulan;
}
function bulan_kedepan($tanggal,$lama)
{
   $tgl=explode(' ',$tanggal);
   $hari=$lama;
   $kedepan = date('Y-m-27', strtotime("$hari Month", strtotime($tgl[0])));
   return  $kedepan;
}
function ubah_bulan($id){
   if($id>9){
      $data=$id;
   }else{
      $data='0'.$id;
   }
   return $data;
}

function get_user(){
   $data=App\User::orderBy('sts_anggota','Asc')->get();
   return $data;
}
function get_status(){
   $data=App\Status::orderBy('id','Asc')->get();
   return $data;
}
function get_akses_bayar($id){
   if($id==2){
      $data=App\Aksesbayar::whereIn('id',array(1,3,4,5))->orderBy('id','Asc')->get();
   }else{
      $data=App\Aksesbayar::whereIn('id',array(3,4,5))->orderBy('id','Asc')->get();
   }
   
   return $data;
}
function total_anggota(){
   $data=App\Anggota::where('cost',Auth::user()['cost'])->where('status',1)->count();
   return $data;
}
function pinjaman_active(){
  $data=App\VPinjaman::whereIn('sts_pinjaman',array(1,2))->orWhere('status_nya',0)->count();
   return $data;
}
function saldo_pinjaman_active(){
  $data=App\VPinjaman::whereIn('sts_pinjaman',array(1,2))->orWhere('status_nya',0)->sum('nominal');
   return $data;
}
function saldo_pinjaman_terbayar(){
  $data=App\VPinjaman::whereIn('sts_pinjaman',array(1,2))->orWhere('status_nya',0)->sum('terbayar');
   return $data;
}
function notifikasi_pengajuan(){
   if(Auth::user()['role_id']==1){
      $app=App\Pinjaman::where('sts_pinjaman',3)->count();
      
   }
   if(Auth::user()['role_id']==2){
      $app=App\Pinjaman::where('sts_pinjaman',2)->count();
      
   }

   if($app>0){
      $data='<span class="badge pull-right">'.$app.'</span>'; 
   }else{
      $data='';
   }
   
   return $data;
}
function notifikasi_pencairan(){
   if(Auth::user()['role_id']==1){
      $app=App\Pinjaman::where('sts_pinjaman',4)->where('sts_pencairan',1)->count();
      
   }
   if(Auth::user()['role_id']==2){
      $app=App\Pinjaman::where('sts_pinjaman',4)->where('sts_pencairan',1)->count();
      
   }

   if($app>0){
      $data='<span class="badge pull-right">'.$app.'</span>'; 
   }else{
      $data='';
   }
   
   return $data;
}

function bulanberikut($tanggal,$waktu){
   $exp=explode('-',$tanggal);
   $tgl=$exp[0].'-'.$exp[1].'-27';
   $bulan = date('F Y', strtotime('+'.$waktu.' month', strtotime($tgl)));
   return $bulan;
}

function tgl_tagihan($tanggal,$waktu){
   $exp=explode('-',$tanggal);
   $tgl=$exp[0].'-'.$exp[1].'-27';
   $bulan = date('Y-m-27', strtotime('+'.$waktu.' month', strtotime($tgl)));
   return $bulan;
}

function pinjaman_sebelumnya($nik){
   $data=App\Pinjaman::where('sts_pinjaman','4')->where('nik',$nik)->count();
   if($data>0){
      $pinjaman=App\Pinjaman::where('sts_pinjaman','4')->where('nik',$nik)->first();
      $bayar=App\Periodepinjaman::where('nomorpinjaman',$pinjaman['nomorpinjaman'])->where('sts',0)->count();
      $sts=$bayar;
   }else{
      $sts='Tidak ada pinjaman';
   }

   return $sts;
}

function total_pinjaman_sebelumnya($nik){
   $data=App\Pinjaman::where('sts_pinjaman','4')->where('nik',$nik)->count();
   if($data>0){
      $pinjaman=App\Pinjaman::where('sts_pinjaman','4')->where('nik',$nik)->first();
      $sts=($pinjaman['nominal']-$pinjaman['terbayar'])+$pinjaman['bunga'];
   }else{
      $sts='0';
   }

   return $sts;
}

function total_saldo_pinjaman($tahun){
   $data=App\Pembayaranpinjaman::where('tahun',$tahun)->count();
   if($data>0){
      $masuk=App\Pembayaranpinjaman::where('tahun',$tahun)->where('sts',1)->sum('pinjaman');
      $keluar=App\Pembayaranpinjaman::where('tahun',$tahun)->where('sts',2)->sum('pinjaman');
      $sts=($masuk-$keluar);
   }else{
      $sts='0';
   }

   return $sts;
}
function total_bagihasil($tahun){
   $data=App\Pembayaranpinjaman::where('tahun',$tahun)->where('sts',1)->count();
   if($data>0){
      $masuk=App\Pembayaranpinjaman::where('tahun',$tahun)->where('sts',1)->sum('margin');
      $sts=$masuk;
   }else{
      $sts='0';
   }

   return $sts;
}


function count_sisabayar($kode){
  
   $bayar=App\Periodepinjaman::where('nomorpinjaman',$kode)->where('sts',0)->count();
   if($bayar>0){
      $sts=$bayar.'X';
   }else{
      $sts='Lunas';
   }
   return $sts;
}
function sum_transaksi($tahun,$bulan,$kat){
  
   $bayar=App\Transaksi::where('bulan',$bulan)->where('tahun',$tahun)->where('sts',$kat)->count();
   if($bayar>0){
      $tot=App\Transaksi::where('bulan',$bulan)->where('tahun',$tahun)->where('sts',$kat)->sum('margin');
      $sts=$tot;
   }else{
      $sts=0;
   }
   return $sts;
}
function url_plug(){
   $data=url('public');
   return $data;
}
function nama_user($no_register){
   $data=App\VUser::where('username',$no_register)->firstOrfail();
   return $data->name;
}
function ubah_uang($uang){
   $patr='/([^0-9]+)/';
   $ug=explode('.',$uang);
   $data=preg_replace($patr,'',$ug[0]);
   return $data;
}
function tanggal_eng($date=null){
   if($date=="" || $date==null){
      return null;
   }else{
      return date('d M Y H:i:s',strtotime($date));
   }
   
}
function cetak_item_kasir($no_transaksi,$x){
   if($x==1){
       $data=App\VStok::where('no_transaksi',$no_transaksi)->whereBetween('urut',[1,18])->orderBy('urut','Asc')->get();
   }
   if($x==2){
       $data=App\VStok::where('no_transaksi',$no_transaksi)->whereBetween('urut',[19,36])->orderBy('urut','Asc')->get();
   }
   if($x==3){
       $data=App\VStok::where('no_transaksi',$no_transaksi)->whereBetween('urut',[37,54])->orderBy('urut','Asc')->get();
   }
   if($x==4){
       $data=App\VStok::where('no_transaksi',$no_transaksi)->whereBetween('urut',[55,72])->orderBy('urut','Asc')->get();
   }
   if($x==5){
       $data=App\VStok::where('no_transaksi',$no_transaksi)->whereBetween('urut',[73,90])->orderBy('urut','Asc')->get();
   }
   if($x==6){
       $data=App\VStok::where('no_transaksi',$no_transaksi)->whereBetween('urut',[91,108])->orderBy('urut','Asc')->get();
   }
   if($x==7){
       $data=App\VStok::where('no_transaksi',$no_transaksi)->whereBetween('urut',[109,126])->orderBy('urut','Asc')->get();
   }
   if($x==8){
       $data=App\VStok::where('no_transaksi',$no_transaksi)->whereBetween('urut',[127,144])->orderBy('urut','Asc')->get();
   }
   if($x==9){
       $data=App\VStok::where('nomor_transaksi',$nomor_transaksi)->whereBetween('urut',[145,162])->orderBy('urut','Asc')->get();
   }
   if($x==10){
       $data=App\VStok::where('nomor_transaksi',$nomor_transaksi)->whereBetween('urut',[163,180])->orderBy('urut','Asc')->get();
   }
   
   return $data;
}
function setting_font_print(){
   $data=App\Setting::where('id',3)->first();
   return $data->setting_int;
}
function jumlah_item_order_kasir($no_transaksi){
   $data=App\VStok::where('no_transaksi',$no_transaksi)->count();
   return $data;
}
function sum_item_order_kasir($no_transaksi){
   $data=App\VStok::where('no_transaksi',$no_transaksi)->sum('total_jual');
   return $data;
}
function get_slid(){
   $data=App\Slipgaji::select('tahun')->groupBy('tahun')->orderBy('tahun','Desc')->get();
   return $data;
}
function get_satuan(){
   $data=App\Satuan::where('active',1)->orderBy('satuan','Desc')->get();
   return $data;
}
function get_group(){
   $data=App\Group::orderBy('id','Asc')->get();
   return $data;
}
function get_kategori_barang(){
   $data=App\Kategoribarang::orderBy('id','Desc')->get();
   return $data;
}
function get_perusahaan(){
   $data=App\VPerusahaan::orderBy('perusahaan','Desc')->get();
   return $data;
}
function ubah_int($nilai){
   $patr='/([^0-9]+)/';
   $data=preg_replace($patr,'',$nilai);
   return $data;
}
function cek_user($nik){
   $data=App\Anggota::where('nik',$nik)->count();
   return $data;
}
function get_slip_gaji($tahun,$bulan){
   $data=App\Slipgaji::where('bulan',$bulan)->where('tahun',$tahun)->get();
   return $data;
}
function sum_transaksi_tahunan($tahun,$kat){
  
   $bayar=App\Transaksi::where('tahun',$tahun)->where('sts',$kat)->count();
   if($bayar>0){
      $tot=App\Transaksi::where('tahun',$tahun)->where('sts',$kat)->sum('margin');
      $sts=$tot;
   }else{
      $sts=0;
   }
   return $sts;
}

function get_pengajuan(){
   if(Auth::user()['role_id']==1){
      $data=App\Pinjaman::where('sts_pinjaman','3')->orderBy('sts_pinjaman','Asc')->get();
   }
   if(Auth::user()['role_id']==2){
      $data=App\Pinjaman::where('sts_pinjaman','2')->orderBy('sts_pinjaman','Asc')->get();
   }
   if(Auth::user()['role_id']==3){
      $data=App\Pinjaman::where('sts_pinjaman','1')->orderBy('sts_pinjaman','Asc')->get();
   }
   
   return $data;
}

function get_pengajuan_cair(){
   $data=App\Pinjaman::where('sts_pinjaman','4')->where('sts_pencairan',1)->orderBy('sts_pinjaman','Asc')->get();
   
   return $data;
}

function saldo_wajib_all(){
   
   $masuk=App\Simpananwajib::where('sts',1)->sum('nominal');
   $keluar=App\Simpananwajib::where('sts',2)->sum('nominal');
   $data=$masuk-$keluar;
   
   return $data;
}

function bagi_anggota(){
   $data=10;
   return $data;
}
function bagi_koperasi(){
   $data=90;
   return $data;
}
function saldo_pokok_all(){
   
   $masuk=App\Simpananpokok::where('sts',1)->sum('nominal');
   $keluar=App\Simpananpokok::where('sts',2)->sum('nominal');
   $data=$masuk-$keluar;
   
   return $data;
}
function saldo_sukarela_all(){
   
   $masuk=App\Simpanansukarela::where('sts',1)->sum('nominal');
   $keluar=App\Simpanansukarela::where('sts',2)->sum('nominal');
   $data=$masuk-$keluar;
   
   return $data;
}
function saldo_sukarela($no_register){
   
   $masuk=App\Simpanansukarela::where('sts',1)->where('no_register',$no_register)->sum('nominal');
   $keluar=App\Simpanansukarela::where('sts',2)->where('no_register',$no_register)->sum('nominal');
   $data=$masuk-$keluar;
   
   return $data;
}
function total_simpananwajib(){
   $data=App\Simpananwajib::sum('nominal');
   
   return $data;
}

function get_simpananwajib(){
   $data=App\Simpananwajib::select('nik')->where('cost',Auth::user()['cost'])->groupBy('nik')->orderBy('nik','Asc')->get();
   
   return $data;
}
function saldo_simpanansukarela($nik){
   $data=App\Simpanansukarela::where('nik',$nik)->sum('nominal');
   
   return $data;
}

function get_simpanansukarela(){
   $data=App\Simpanansukarela::select('nik')->groupBy('nik')->orderBy('nik','Asc')->get();
   
   return $data;
}
function get_pengajuan_barucair(){
   $data=App\Pinjaman::where('sts_pinjaman','4')->where('sts_pencairan',2)->where('tgl_cair',date('Y-m-d'))->orderBy('sts_pinjaman','Asc')->get();
   
   return $data;
}

function parsing_validator($url){
   $content=utf8_encode($url);
   $data = json_decode($content,true);

   return $data;
}

function get_pinjaman(){
   
  $data=App\Pinjaman::where('sts_pinjaman','4')->where('sts_pencairan','>',1)->orderBy('nomorpinjaman','Asc')->get();
   
   return $data;
}

function kode_kategori($id){
   
  $data=App\Kategori::where('id',$id)->first();
   
   return $data['kode'];
}

function get_transaksi($tahun,$kategori){
  if($kategori=='all'){
      $data=App\Transaksi::where('tahun',$tahun)->orderBy('id','Desc')->get();
  }
  else{
      $data=App\Transaksi::where('tahun',$tahun)->where('kategori_id',$kategori)->orderBy('id','Desc')->get();
  }
  
   
   return $data;
}

function masuk_transaksi($tahun){
   
  $cek=App\Transaksi::where('tahun',($tahun-1))->where('sts',1)->whereIn('kategori_id',array('1','6'))->count();
  if($cek>0){
      $data=App\Transaksi::where('tahun',$tahun)->where('sts',1)->whereIn('kategori_id',array('1','6'))->sum('nominal');
      $saldo=$data;
  }else{
      $data=App\Transaksi::where('tahun',$tahun)->where('sts',1)->sum('nominal');
      $saldo=$data;
  }
  
   
   return $saldo;
}

function keluar_transaksi($tahun){
   
  $data=App\Transaksi::where('tahun',$tahun)->where('sts',2)->whereIn('kategori_id',array('1','6'))->sum('nominal');
   
   return $data;
}

function margin_transaksi($tahun){
   
  $data=App\Transaksi::where('tahun',$tahun)->sum('margin');
   
   return $data;
}

function get_tahun_transaksi(){
   
  $data=App\Transaksi::select('tahun')->groupBy('tahun')->get();
   
   return $data;
}
function get_anggota(){
   
  $data=App\VUser::where('sts_anggota',1)->orderBy('name','Asc')->get();
   
   return $data;
}

function get_kategori(){
   
  $data=App\Kategori::all();
   
   return $data;
}

function get_kategori_transaksi(){
   
  $data=App\Kategori::whereIn('id',array('5','6'))->get();
   
   return $data;
}
function data_simpanan_wajib($no_register,$bulan,$tahun){
   
  $cek=App\Simpananwajib::where('no_register',$no_register)->where('bulan',$bulan)->where('tahun',$tahun)->count();
  if($cek>0){
      $data=App\Simpananwajib::where('no_register',$no_register)->where('bulan',$bulan)->where('tahun',$tahun)->firstOrfail();
      return $data->id;
   }else{
      return 0;
   }
   
}

function bln($id){
   if($id>9){
      $data=$id;
   }else{
      $data='0'.$id;
   }

   return substr(bulan($data),0,3);
}
function barcoderr($id){
   $d = new Milon\Barcode\DNS1D();
   $d->setStorPath(__DIR__.'/cache/');
   $data='<img src="data:image/png;base64,'.$d->getBarcodePNG("$id", 'C39+',1,43,array(1,1,1), true).'" alt="barcode" />';
   return $data;
}
function blnfull($id){
   if($id>9){
      $data=$id;
   }else{
      $data='0'.$id;
   }

   return bulan($data);
}

function nilai_wajib(){
   $data=100000;
   return $data;
}
function kode_barang(){
    
   $cek=App\Barang::count();
   if($cek>0){
       $mst=App\Barang::orderBy('kode_barang','Desc')->firstOrfail();
       $urutan = (int) substr($mst['kode_barang'], 1, 6);
       $urutan++;
       $nomor='B'.sprintf("%06s",  $urutan);
   }else{
       $nomor='B'.sprintf("%06s",  1);
   }
   return $nomor;
}
function no_register(){
    
   $cek=App\Anggota::where('tahun',date('Y'))->count();
   if($cek>0){
       $mst=App\Anggota::where('tahun',date('Y'))->orderBy('no_register','Desc')->firstOrfail();
       $urutan = (int) substr($mst['no_register'], 2, 5);
       $urutan++;
       $nomor=date('y').sprintf("%05s",  $urutan);
   }else{
       $nomor=date('y').sprintf("%05s",  1);
   }
   return $nomor;
}
function facebook_time_ago($timestamp){  
   $time_ago = strtotime($timestamp);  
   $current_time = time();  
   $time_difference = $current_time - $time_ago;  
   $seconds = $time_difference;  
   $minutes      = round($seconds / 60 );        // value 60 is seconds  
   $hours        = round($seconds / 3600);       //value 3600 is 60 minutes * 60 sec  
   $days         = round($seconds / 86400);      //86400 = 24 * 60 * 60;  
   $weeks        = round($seconds / 604800);     // 7*24*60*60;  
   $months       = round($seconds / 2629440);    //((365+365+365+365+366)/5/12)*24*60*60  
   $years        = round($seconds / 31553280);   //(365+365+365+365+366)/5 * 24 * 60 * 60  
   if($seconds <= 60) {  
    return "Just Now";  
   } else if($minutes <=60) {  
    if($minutes==1){  
      return "one minute ago";  
    }else {  
      return "$minutes minutes ago";  
    }  
   } else if($hours <=24) {  
    if($hours==1) {  
      return "an hour ago";  
    } else {  
      return "$hours hour ago";  
    }  
   }else if($days <= 7) {  
    if($days==1) {  
      return "yesterday";  
    }else {  
      return "$days days ago";  
    }  
   }else if($weeks <= 4.3) {  //4.3 == 52/12
    if($weeks==1){  
      return "a week ago";  
    }else {  
      return "$weeks weeks ago";  
    }  
   } else if($months <=12){  
    if($months==1){  
      return "a month ago";  
    }else{  
      return "$months months ago";  
    }  
   }else {  
    if($years==1){  
      return "one year ago";  
    }else {  
      return "$years years ago";  
    }  
   }  
} 
function singkat_angka($n, $presisi=1) {
	if ($n < 900) {
		$format_angka = number_format($n, $presisi);
		$simbol = '';
	} else if ($n < 900000) {
		$format_angka = number_format($n / 1000, $presisi);
		$simbol = 'rb';
	} else if ($n < 900000000) {
		$format_angka = number_format($n / 1000000, $presisi);
		$simbol = 'jt';
	} else if ($n < 900000000000) {
		$format_angka = number_format($n / 1000000000, $presisi);
		$simbol = 'M';
	} else {
		$format_angka = number_format($n / 1000000000000, $presisi);
		$simbol = 'T';
	}
 
	if ( $presisi > 0 ) {
		$pisah = '.' . str_repeat( '0', $presisi );
		$format_angka = str_replace( $pisah, '', $format_angka );
	}
	
	return $format_angka . $simbol;
}
function no_order(){
    
   $cek=App\Orderstok::where('tahun',date('Y'))->count();
   if($cek>0){
       $mst=App\Orderstok::where('tahun',date('Y'))->orderBy('no_order','Desc')->firstOrfail();
       $urutan = (int) substr($mst['no_order'], 3, 8);
       $urutan++;
       $nomor='S'.date('y').sprintf("%08s",  $urutan);
   }else{
       $nomor='S'.date('y').sprintf("%08s",  1);
   }
   return $nomor;
}
function no_kasir(){
    
   $cek=App\Kasir::where('tahun',date('Y'))->count();
   if($cek>0){
       $mst=App\Kasir::where('tahun',date('Y'))->orderBy('no_order','Desc')->firstOrfail();
       $urutan = (int) substr($mst['no_order'], 3, 8);
       $urutan++;
       $nomor='K'.date('y').sprintf("%08s",  $urutan);
   }else{
       $nomor='K'.date('y').sprintf("%08s",  1);
   }
   return $nomor;
}

?>