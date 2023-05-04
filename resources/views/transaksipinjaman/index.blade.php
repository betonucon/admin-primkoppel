@extends('layouts.web')

@section('contex')  
<div class="content">
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active">{{$menu}}</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">{{$menu}}&nbsp;&nbsp;<small>{{name_app()}}</small></h1>
    <div class="panel panel-success" data-sortable-id="ui-widget-11" >
        <div class="panel-heading">
            <h4 class="panel-title">Pengajuan Pinjaman</h4>
            <div class="panel-heading-btn">
                <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a> -->
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="panel-body">
            @if(Auth::user()->role_id==2)
            <div class="btn-group" style="margin-bottom:2%">
                <button type="button" class="btn btn-green btn-sm" onclick="tampil_tagihan()"><i class="fa fa-calendar-alt"></i> Tagihan Periode Ini</button>
                <!-- <button type="button" class="btn btn-blue btn-sm" onclick="tambah()"><i class="fa fa-plus"></i> Buat Pinjaman</button> -->
            </div>
            @endif
            <table id="datafixedheader" class="table table-striped table-bordered table-td-valign-middle">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="7%">Nomor</th>
                        <th class="text-wrap">Karyawan</th>
                        <th width="10%" class="text-nowrap">Nominal</th>
                        <th width="12" class="text-nowrap">Waktu</th>
                        <th width="10%" class="text-nowrap">Angsuran</th>
                        <th width="10%" class="text-nowrap">Sisa Cicilan</th>
                        <th width="10%" class="text-nowrap">Tertagih</th>
                        <th class="text-nowrap" width="9%">Act</th>
                    </tr>
                </thead>
                <tbody>
                  
                    @foreach(get_pinjaman() as $no=>$data)
                        <tr class="odd gradeX">
                            <td>{{$no+1}}</td>
                            <td>{{$data->nomorpinjaman}}</td>
                            <td><b>[{{$data->nik}}]</b> {{$data->user['name']}}</td>
                            <td>{{uang($data->nominal)}}</td>
                            <td>{{$data->waktu}} Bulan</td>
                            <td>{{uang($data->cicilan)}}</td>
                            <td>{{uang($data['nominal']-$data['terbayar'])}}</td>
                            <td>{{$data->berikutnya}}</td>
                            <td>
                            <span onclick="view_tagihan(`{{$data->nomorpinjaman}}`)" class="btn btn-purple active btn-xs"><i class="fas fa-edit fa-sm"></i> View</span> 
                            </td>
                        </tr>
                    @endforeach
                    
                    
                </tbody>
            </table>

        </div>
        
    </div>

    <div class="row">
        <div class="modal" id="modal-tambah" aria-hidden="true" style="display: none;background: #1717198a;">
			<div class="modal-dialog modal-lg" style="margin-top:0px">
				<div class="modal-content">
                    <div class="modal-header">
						<h4 class="modal-title">Tambah Pinjaman</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
                        <div class="alert alert-yellow fade show m-b-10" style="padding: 1%;text-align: center;">
                            <span class="close" data-dismiss="alert">×</span>
                            <strong>Notifikasi!</strong><br>Tambah data transaksi keuangan masuk atau keluar.
                            <div id="tampil-notifikasi-transaksi"></div>
                        </div>
                        
                        <div class="btn-group" style="margin-bottom:2%">
                            
                        </div>
                        <form id="mytransaksi" action="{{url('Pinjaman/simpan')}}" method="post" enctype="multipart/form-data">
                              
                            <div class="col-xl-10 offset-xl-2">
                                <div class="form-group row m-b-10">
                                    <label class="col-lg-3 text-lg-right col-form-label">NIK</label>
                                    <div class="col-lg-9 col-xl-2">
                                        <input type="text"  onkeypress="return hanyaAngka(event)" onkeyup="cari_anggota(this.value)" placeholder="Ketik disini...." class="form-control">
                                    </div>
                                    <div class="col-lg-9 col-xl-7">
                                        <input type="text" disabled id="name" placeholder="Ketik disini...." class="form-control">
                                        <input type="hidden"  name="nik" id="nik" placeholder="Ketik disini...." class="form-control">
                                    </div>
                                </div>
                                
                                <div class="form-group row m-b-10">
                                    <label class="col-lg-3 text-lg-right col-form-label">Nilai</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="text" name="nominal" onkeyup="ubah_rupiah(this.value)" onkeypress="return hanyaAngka(event)" placeholder="Ketik disini...." class="form-control">
                                    </div>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="text" disabled id="rupiah_nominal" placeholder="Ketik disini...." class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row m-b-10">
                                    <label class="col-lg-3 text-lg-right col-form-label">Tanggal Pengajuan</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="text" name="tgl_pengajuan" id="datepicker" placeholder="Ketik disini...." class="form-control">
                                    </div>
                                    <div class="col-lg-9 col-xl-2">

                                    </div>
                                </div>
                                
                                <div class="form-group row m-b-10">
                                    <label class="col-lg-3 text-lg-right col-form-label">Periode Bulan & Tahun</label>
                                    <div class="col-lg-9 col-xl-3">
                                        
                                        <select class="form-control" name="bulan">
                                            <option value="">-- Pilih --</option>
                                            @for($bul=1;$bul<13;$bul++)
                                                <option value="{{ubah_bulan($bul)}}">- {{bulan(ubah_bulan($bul))}}</option>
                                            @endfor
                                        </select>
                                            
                                    </div>
                                    <div class="col-lg-9 col-xl-3">
                                        
                                        <select class="form-control" name="tahun">
                                            <option value="">-- Pilih --</option>
                                            @for($thn=2020;$thn<=date('Y');$thn++)
                                                <option value="{{$thn}}">- {{$thn}}</option>
                                            @endfor
                                        </select>
                                            
                                    </div>
                                </div>

                                <div class="form-group row m-b-10">
                                    <label class="col-lg-3 text-lg-right col-form-label">Jangka Waktu</label>
                                    <div class="col-lg-9 col-xl-6">
                                        
                                        <select class="form-control" name="waktu">
                                            <option value="">-- Pilih --</option>
                                            @for($x=1;$x<31;$x++)
                                                <option value="{{$x}}">- {{$x}} Bulan</option>
                                            @endfor
                                        </select>
                                            
                                    </div>
                                </div>
                                
                                <input type="submit">
                                <!-- end form-group row -->
                            </div>
							
                        </form>
					</div>
					<div class="modal-footer">
                        <a href="javascript:;" class="btn btn-primary" onclick="simpan()" >Simpan</a>
                        <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Tutup</a>
                    </div>
				</div>
			</div>
		</div>
        <div class="modal" id="modal-tampil_tagihan" aria-hidden="true" style="display: none;background: #1717198a;">
			<div class="modal-dialog modal-lg" style="margin-top:0px;max-width:80%">
				<div class="modal-content">
                    <div class="modal-header">
						<h4 class="modal-title">Tagihan Pinjaman Periode {{date('F Y')}}</h4>
						<button type="button" class="close">×</button>
					</div>
					<div class="modal-body">
                        <div class="alert alert-yellow fade show m-b-10" style="padding: 1%;text-align: center;">
                            <span class="close" data-dismiss="alert">×</span>
                            <strong>Notifikasi!</strong><br>Daftar tagihan pembayaran periode {{date('F Y')}} -> Pilih Pembayaran yang akan diproses -> Klik Proses Pembayaran.
                            <div id="tampil-notifikasi-proses-tagihan"></div>
                        </div>
                        
                        <div class="btn-group" style="margin-bottom:2%">
                            <button type="button" class="btn btn-green btn-sm" onclick="proses_tagihan()"><i class="fa fa-cog"></i> Proses Pembayaran</button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="export_excel_pinjaman(`{{date('Y-m-27')}}`)"><i class="fa fa-excel"></i> Export Tagihan</button>
                        </div>
                        <form id="myproses_tagihan" action="{{url('/TransaksiPinjaman/proses_tagihan')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            
					        <div  id="tampil_tagihan" style="max-height: 450px;overflow-x: hidden;overflow-y: scroll;padding: 1%;" ></div>
                        </form>
					</div>
					<div class="modal-footer">
                        <a href="javascript:;" class="btn btn-white" onclick="tutup_tagihan()">Tutup</a>
                    </div>
				</div>
			</div>
		</div>
        <div class="modal" id="modal-view_tagihan" aria-hidden="true" style="display: none;background: #1717198a;">
			<div class="modal-dialog modal-lg" style="margin-top:0px">
				<div class="modal-content">
                    <div class="modal-header">
						<h4 class="modal-title">Rincian Pinjaman</h4>
						<button type="button" class="close" >×</button>
					</div>
					<div class="modal-body">
                        
                        <div  id="view_pelunasan" style="padding: 1%;width:100%;background:aqua" ></div>
                        <div  id="tampil-notifikasi-proses-bayar"></div>
                        <form id="myproses_bayar" action="{{url('/TransaksiPinjaman/proses_bayar')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div  id="view_tagihan" style="max-height: 450px;overflow-x: hidden;overflow-y: scroll;padding: 1%;" ></div>
                        </form>
					</div>
					<div class="modal-footer">
                        <a href="javascript:;" class="btn btn-white" onclick="tutup_tagihan()">Tutup</a>
                    </div>
				</div>
			</div>
		</div>
        <div class="modal fade" id="modal-notifikasi" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Notifikasi</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger m-b-0">
                            <h5><i class="fa fa-info-circle"></i> Erorr</h5>
                            <div id="isi-notifikasi"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Tutup</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('ajax')
    <script>
        var handleDataTableFixedHeader = function() {
            "use strict";
            
            if ($('#datafixedheader').length !== 0) {
                $('#datafixedheader').DataTable({
                    lengthMenu: [20, 40, 60],
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
                    responsive: false,
                    langth: false,
                    paging: true,
                    order: false,
                    info: false,
                });
            }
        };

        var TableManageFixedHeader = function () {
            "use strict";
            return {
                //main function
                init: function () {
                    handleDataTableFixedHeader();
                }
            };
        }();

        $(document).ready(function() {
            TableManageFixedHeader.init();
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd',
                
            });
        });

        function tutup_tagihan(){
            location.reload();
        }
        function tambah(){
            $('#modal-tambah').modal('show');
        }
        function cari_anggota(a){
            
			$.ajax({
				type: 'GET',
				url: "{{url('Anggota/cari_anggota')}}",
				data: "nik="+a,
				success: function(msg){
                    var data=msg.split('@');
					$('#nik').val(data[0]);
					$('#name').val(data[1]);
				}
			});
			
		}
        function export_excel_pinjaman(a){
            location.assign('{{url('TransaksiPinjaman/export_excel_pinjaman')}}?tanggal='+a);
		}
        function ubah_rupiah(nominal){
            
			$.ajax({
				type: 'GET',
				url: "{{url('ubah_rupiah')}}",
				data: "nominal="+nominal,
				success: function(msg){
					$('#rupiah_nominal').val(msg);
				}
			});
			
		}
        function tampil_tagihan(){
            
			$.ajax({
				type: 'GET',
				url: "{{url('TransaksiPinjaman/tampil_tagihan')}}",
				data: "id=1",
				success: function(msg){
					$('#modal-tampil_tagihan').modal({backdrop: 'static', keyboard: false});
					$('#tampil_tagihan').html(msg);
				}
			});
			
		}

        function view_tagihan(nomorpinjaman){
            
			$.ajax({
				type: 'GET',
				url: "{{url('TransaksiPinjaman/view_tagihan')}}",
				data: "nomorpinjaman="+nomorpinjaman,
				success: function(msg){
                    var mesg=msg.split('@');
					$('#modal-view_tagihan').modal({backdrop: 'static', keyboard: false});
					$('#view_pelunasan').html(mesg[1]);
					$('#view_tagihan').html(mesg[0]);
				}
			});
			
		}

        function proses_tagihan(){
            
            var form=document.getElementById('myproses_tagihan');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/TransaksiPinjaman/proses_tagihan')}}",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(msg){
                        if(msg=='ok'){
                            location.reload();
                               
                        }else{
                            $('#tampil-notifikasi-proses-tagihan').html(msg);
                        }
                        
                        
                    }
                });

        } 

        function bayar(){
            
            var form=document.getElementById('myproses_bayar');
            let text = "Lanjutkan proses ini?.";
                if (confirm(text) == true) {
                    $.ajax({
                        type: 'POST',
                        url: "{{url('/TransaksiPinjaman/proses_bayar')}}",
                        data: new FormData(form),
                        contentType: false,
                        cache: false,
                        processData:false,
                        beforeSend: function() {
                            document.getElementById("loadnya").style.width = "100%";
                        },
                        success: function(msg){
                            var pesan=msg.split('@');
                            if(pesan[0]=='ok'){
                                document.getElementById("loadnya").style.width = "0px";
                                $.ajax({
                                    type: 'GET',
                                    url: "{{url('TransaksiPinjaman/view_tagihan')}}",
                                    data: "nomorpinjaman="+pesan[1],
                                    success: function(eer){
                                        var mesg=eer.split('@');
                                        $('#view_pelunasan').html(mesg[1]);
                                        $('#view_tagihan').html(mesg[0]);
                                    }
                                });
                                
                            }else{
                                $('#tampil-notifikasi-proses-bayar').html(msg);
                            }
                            
                            
                        }
                    });
                } else {
                    
                }
        } 

        function simpan(){
            
            var form=document.getElementById('mytransaksi');
            var token= "{{csrf_token()}}";
                $.ajax({
                    type: 'POST',
                    url: "{{url('/Pinjaman/simpan')}}?_token="+token,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function() {
						document.getElementById("loadnya").style.width = "100%";
					},
                    success: function(msg){
                        if(msg=='ok'){
                            location.reload();
                               
                        }else{
                            document.getElementById("loadnya").style.width = "0px";
                            $('#modal-notifikasi').modal('show');
                            $('#isi-notifikasi').html(msg);
                        }
                        
                        
                    }
                });

        } 
    </script>

@endpush