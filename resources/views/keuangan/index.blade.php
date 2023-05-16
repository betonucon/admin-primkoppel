@extends('layouts.web')

@push('ajax')
<style>
	th{text-transform:uppercase;}
	.nav.nav-tabs .nav-item .nav-link.active, .nav.nav-tabs .nav-item .nav-link:focus, .nav.nav-tabs .nav-item .nav-link:hover {
		color: #2d353c;
		background: #eeeeef;
	}
</style>
<script>
        var handleDataTableDefault = function() {
			"use strict";
			
			if ($('#data-table-default').length !== 0) {
				var table=$('#data-table-default').DataTable({
					lengthMenu: [30],
					responsive: false,
					lengthChange:false,
					processing: false,
					ordering: false,
					serverSide: false,
					dom: 'lrtip',
					ajax:"{{ url('keuangan/get_data')}}?bulan={{$bulan}}&tahun={{$tahun}}",
					columns: [
						{ data: 'id', render: function (data, type, row, meta) 
                            {
                              return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
						{ data: 'action', className: "text-center" },
						{ data: 'no_transaksi' },
						{ data: 'name' },
						{ data: 'group' },
						{ data: 'keterangan' },
						{ data: 'status_keuangan' , className: "text-center" },
						{ data: 'nilai_nominal', className: "text-right" },
						{ data: 'nilai_tagihan', className: "text-right" },
						{ data: 'nilai_profit', className: "text-right" },
						
						
					],
					language: {
						paginate: {
							// remove previous & next text from pagination
							previous: '<< previous',
							next: 'Next>>'
						}
					}
				});
				$('#cari_datatable').keyup(function(){
                  table.search($(this).val()).draw() ;
                })
				
				
				
				
			}
		};
		function pilih_kategori(kategori){
			var tables=$('#data-table-default').DataTable();
                tables.ajax.url("{{ url('keuangan/get_data')}}?bulan={{$bulan}}&tahun={{$tahun}}&tgl={{$tgl}}&kategori="+kategori).load();
        }
		var TableManageDefault = function () {
			"use strict";
			return {
				//main function
				init: function () {
					handleDataTableDefault();
				}
			};
		}();

		$(document).ready(function() {
			TableManageDefault.init();
		});
    </script>
@endpush
@section('contex')
        <div id="content" class="content">
			
			<div class="row">
				<!-- begin col-6 -->
				<div class="col-xl-12">
					<!-- begin panel -->
					<div class="panel panel-inverse" data-sortable-id="form-plugins-1">
						<!-- begin panel-heading -->
						<div class="panel-heading">
							<h4 class="panel-title">KEUANGAN</h4>
							<div class="panel-heading-btn">
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
							</div>
						</div>
						<!-- end panel-heading -->
						<!-- begin panel-body -->
						<div class="panel-body">
								<div class="row" style="margin-bottom:1%">
									<div class="col-md-2" >
										<select class="form-control form-control-sm" onchange="pilih_tahun(this.value)">
											@for($x=2023;$x<(date('Y')+2);$x++)
												<option value="{{$x}}" @if($tahun==$x) selected @endif >{{$x}}</option>
											@endfor
										</select>
									</div>
									<div class="col-md-3" >
										<select class="form-control form-control-sm" onchange="pilih_bulan(this.value)">
											@for($x=1;$x<13;$x++)
												<option value="{{ubah_bulan($x)}}" @if($bulan==ubah_bulan($x)) selected @endif >{{bulan(ubah_bulan($x))}}</option>
											@endfor
										</select>
									</div>
									<div class="col-md-1" >
										<select class="form-control form-control-sm" onchange="pilih_tanggal(this.value)">
											@for($x=1;$x<31;$x++)
												<option value="{{$x}}" @if($tgl==$x) selected @endif >{{$x}}</option>
											@endfor
										</select>
										
									</div>
									<div class="col-md-4" >
									
									</div>
								</div>
								<ul class="nav nav-tabs">
									<li class="nav-item" style="border: solid 1px #cfcfe3; border-bottom: none;">
										<a href="#default-tab-1" data-toggle="tab" class="nav-link active">
											<span class="d-sm-none">Keseluruhan</span>
											<span class="d-sm-block d-none">Keseluruhan</span>
										</a>
									</li>
									<li class="nav-item" style="border: solid 1px #cfcfe3; border-bottom: none;">
										<a href="#default-tab-2" data-toggle="tab" class="nav-link">
											<span class="d-sm-none">Group</span>
											<span class="d-sm-block d-none">Group</span>
										</a>
									</li>
									
								</ul>
								<div class="tab-content" style="border: solid 1px #cdcde1;background: #eff1e9;">
									<div class="tab-pane fade active show" id="default-tab-1">
										<div class="row" style="margin-bottom:1%">
											<div class="col-md-4" style="background:aqua;border-left:solid 1px #fff">
												<b>TAHUN {{$tahun}}</b>
												<table class="table table-sm m-b-0 text-inverse">
													<tr>
														<td width="30%"><b>- Pemasukan</b></td>
														<td><b>:</b>  Rp. {{uang(uang_dashboard($tahun,0,0,'masuk'))}}</td>
													</tr>
													<tr>
														<td><b>- Pengeluaran</b></td>
														<td><b>:</b> Rp. {{uang(uang_dashboard($tahun,0,0,'keluar'))}}</td>
													</tr>
													<tr>
														<td><b>- Profit</b></td>
														<td><b>:</b> Rp. {{uang(uang_dashboard($tahun,0,0,'profit'))}}</td>
													</tr>
													<tr>
														<td><b>- Piutang</b></td>
														<td><b>:</b> Rp. {{uang(uang_dashboard($tahun,0,0,'piutang'))}}</td>
													</tr>
													<tr>
														<td><b>- Tempo</b></td>
														<td><b>:</b> Rp. {{uang(uang_dashboard($tahun,0,0,'tempo'))}}</td>
													</tr>
												</table>
											</div>
											<div class="col-md-4" style="background:#dee9bb;border-left:solid 1px #fff">
											
												<b style="text-transform:uppercase">BULAN {{bulan($bulan)}}</b>
												<table class="table table-sm m-b-0 text-inverse">
													<tr>
														<td width="30%"><b>- Pemasukan</b></td>
														<td><b>:</b>  Rp. {{uang(uang_dashboard($tahun,$bulan,0,'masuk'))}}</td>
													</tr>
													<tr>
														<td><b>- Pengeluaran</b></td>
														<td><b>:</b> Rp. {{uang(uang_dashboard($tahun,$bulan,0,'keluar'))}}</td>
													</tr>
													<tr>
														<td><b>- Profit</b></td>
														<td><b>:</b> Rp. {{uang(uang_dashboard($tahun,$bulan,0,'profit'))}}</td>
													</tr>
													<tr>
														<td><b>- Piutang</b></td>
														<td><b>:</b> Rp. {{uang(uang_dashboard($tahun,$bulan,0,'piutang'))}}</td>
													</tr>
													<tr>
														<td><b>- Tempo</b></td>
														<td><b>:</b> Rp. {{uang(uang_dashboard($tahun,$bulan,0,'tempo'))}}</td>
													</tr>
												</table>
											</div>
											<div class="col-md-4" style="background:aqua;border-left:solid 1px #fff">
												<b style="text-transform:uppercase">TANGGAL  {{$lengkap}}</b>
												<table class="table table-sm m-b-0 text-inverse">
													<tr>
														<td width="30%"><b>- Pemasukan</b></td>
														<td><b>:</b>  Rp. {{uang(uang_dashboard($tahun,$bulan,$tgl,'masuk'))}}</td>
													</tr>
													<tr>
														<td><b>- Pengeluaran</b></td>
														<td><b>:</b> Rp. {{uang(uang_dashboard($tahun,$bulan,$tgl,'keluar'))}}</td>
													</tr>
													<tr>
														<td><b>- Profit</b></td>
														<td><b>:</b> Rp. {{uang(uang_dashboard($tahun,$bulan,$tgl,'profit'))}}</td>
													</tr>
													<tr>
														<td><b>- Piutang</b></td>
														<td><b>:</b> Rp. {{uang(uang_dashboard($tahun,$bulan,$tgl,'piutang'))}}</td>
													</tr>
													<tr>
														<td><b>- Tempo</b></td>
														<td><b>:</b> Rp. {{uang(uang_dashboard($tahun,$bulan,$tgl,'tempo'))}}</td>
													</tr>
												</table>
											</div>
										</div>
									</div>
									<div class="tab-pane fade" id="default-tab-2">
										<div class="row" style="margin-bottom:1%">
											<div class="col-md-4" style="background:aqua;border-left:solid 1px #fff">
												<b>TAHUN {{$tahun}}</b>
												<table class="table table-sm m-b-0 text-inverse">
													<tr>
														<th width="30%"><b>GROUP</b></th>
														<th>PROFIT</th>
													</tr>
													@foreach(get_group() as $o)
													<tr>
														<td><b>{{$o->id}}</b></td>
														<td>{{uang(uang_dashboard_group($tahun,0,0,'profit',$o->id))}}</td>
													</tr>
													@endforeach
												</table>
											</div>
											<div class="col-md-4" style="background:#dee9bb;border-left:solid 1px #fff">
											
												<b style="text-transform:uppercase">BULAN {{bulan($bulan)}}</b>
												<table class="table table-sm m-b-0 text-inverse">
													<tr>
														<th width="30%"><b>GROUP</b></th>
														<th>PROFIT</th>
													</tr>
													@foreach(get_group() as $o)
													<tr>
														<td><b>{{$o->id}}</b></td>
														<td>{{uang(uang_dashboard_group($tahun,$bulan,0,'profit',$o->id))}}</td>
													</tr>
													@endforeach
												</table>
											</div>
											<div class="col-md-4" style="background:aqua;border-left:solid 1px #fff">
												<b style="text-transform:uppercase">TANGGAL  {{$lengkap}}</b>
												<table class="table table-sm m-b-0 text-inverse">
													<tr>
														<th width="30%"><b>GROUP</b></th>
														<th>PROFIT</th>
													</tr>
													@foreach(get_group() as $o)
													<tr>
														<td><b>{{$o->id}}</b></td>
														<td>{{uang(uang_dashboard_group($tahun,$bulan,$tgl,'profit',$o->id))}}</td>
													</tr>
													@endforeach
												</table>
											</div>
										</div>
									</div>
								</div>
								
								<form id="data-all" action="{{url('/Warga/hapus')}}" method="post" enctype="multipart/form-data">
									@csrf
									<div class="row" style="margin-bottom:1%">
											<div class="col-md-5" >

											</div>
											<div class="col-md-3" >
												<select class="form-control form-control-sm" onchange="pilih_kategori(this.value)">
													<option value="">Semua kategori--</option>
													@foreach(get_kategorikeuangan() as $no=>$o)
														<option value="{{$o->id}}" >{{$o->kategori_keuangan}}</option>
													@endforeach
												</select>
											</div>
											<div class="col-md-4" >
												<input type="text" id="cari_datatable" placeholder="Search....." class="form-control  form-control-sm">
											</div>
									</div>
									<table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
										<thead>
											<tr>
												<th width="5%">No</th>
												<th width="5%"></th>
												<th width="10%">NO TRANSAKSI</th>
												<th width="10%">OPERATOR</th>
												<th width="5%">GROUP</th>
												<th class="text-nowrap">KETERANGAN</th>
												<th width="8%" class="text-nowrap">STATUS</th>
												<th width="10%" class="text-nowrap">NOMINAL</th>
												<th width="10%" class="text-nowrap">TAGIHAN</th>
												<th width="10%" class="text-nowrap">PROFIT</th>
											</tr>
											
										</thead>
									</table>
								</form>
						</div>
						<!-- end panel-body -->
					</div>
					<!-- end panel -->
					
				</div>
				
			</div>

			<div class="row">
				<div class="modal fade" id="modal-tambah" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
								<form  class="form-horizontal " id="mydata" action="{{url('/Warga/')}}" method="post" enctype="multipart/form-data">
                                    @csrf
									
                                    	<div id="tampil_tambah"></div>
									
                                </form>   
                            </div>
                            <div class="modal-footer">
                                <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Tutup</a>
                                <a href="javascript:;" class="btn btn-blue" onclick="simpan_data()">Simpan</a>
                                
                            </div>
                        </div>
                    </div>
                </div>
				<div class="modal fade" id="modal-file" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="background: #0c0c0c;">
                                <h4 class="modal-title"></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body text-center">
                                <div id="tampil_file"></div>
							</div>
                            <div class="modal-footer">
                                <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Tutup</a>
                            </div>
                        </div>
                    </div>
                </div>

			</div>
			
			<!-- end row -->
		</div>

@endsection

@push('ajax')
	<script>
		
		function tambah(id){
			$('#modal-tambah').modal('show');
			$('#tampil_tambah').load("{{url('anggota/tambah')}}?id="+id);
			
		}
		function view_data(no_transaksi,kategori){
			if(kategori==2){
				location.assign("{{url('kasir/view')}}?nomor="+no_transaksi);
			}
			
			
		}
		function pilih_bulan(bulan){
			location.assign("{{url('keuangan')}}?tahun={{$tahun}}&tgl={{$tgl}}&bulan="+bulan);
			
		}
		function pilih_tahun(tahun){
			location.assign("{{url('keuangan')}}?bulan={{$bulan}}&tgl={{$tgl}}&tahun="+tahun);
			
		}
		function pilih_tanggal(tgl){
			location.assign("{{url('keuangan')}}?bulan={{$bulan}}&tahun={{$tahun}}&tgl="+tgl);
			
		}
		function show_foto(file){
			$('#modal-file').modal('show');
			$('#tampil_file').html("<img src='{{url('/public/_icon')}}/"+file+"' width='100%'>");
			
		}
		function show_foto(file,kode_qr){
			$('#modal-file').modal('show');
			$('#tampil_file').load("{{url('anggota/view_file')}}?file="+file+"&kode_qr="+kode_qr);
			
		}
		function delete_data(id){
           
           swal({
               title: "Yakin menghapus data ini ?",
               text: "",
               type: "warning",
               icon: "info",
               showCancelButton: true,
               align:"center",
               confirmButtonClass: "btn-danger",
               confirmButtonText: "Yes, delete it!",
               closeOnConfirm: false
           }).then((willDelete) => {
               if (willDelete) {
                       $.ajax({
                           type: 'GET',
                           url: "{{url('anggota/delete')}}",
                           data: "id="+id,
                           success: function(msg){
                               swal("Success! berhasil terhapus!", {
                                   icon: "success",
                               });
                               var tables=$('#data-table-default').DataTable();
                                tables.ajax.url("{{ url('anggota/get_data')}}").load();
                           }
                       });
                   
                   
               } else {
                   
               }
           });
           
        }
		function simpan_data(){
                
				var form=document.getElementById('mydata');
				$.ajax({
					type: 'POST',
					url: "{{ url('anggota/') }}",
					data: new FormData(form),
					contentType: false,
					cache: false,
					processData:false,
					beforeSend: function() {
						document.getElementById("loadnya").style.width = "100%";
					},
					success: function(msg){
						var bat=msg.split('@');
						if(bat[1]=='ok'){
							document.getElementById("loadnya").style.width = "0px";
							$('#modal-tambah').modal('hide');
							$('#tampil_tambah').html("");
							var tables=$('#data-table-default').DataTable();
                                tables.ajax.url("{{ url('anggota/get_data')}}").load();
						}else{
							document.getElementById("loadnya").style.width = "0px";
							
							swal({
								title: 'Notifikasi',
							
								html:true,
								text:'ss',
								icon: 'error',
								buttons: {
									cancel: {
										text: 'Tutup',
										value: null,
										visible: true,
										className: 'btn btn-dangers',
										closeModal: true,
									},
									
								}
							});
							$('.swal-text').html('<div style="width:100%;background:#f2f2f5;padding:1%;text-align:left;font-size:13px">'+msg+'</div>')
						}
						
						
					}
				
				});
		}
	</script>
@endpush