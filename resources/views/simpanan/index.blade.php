@extends('layouts.web')

@push('ajax')
<style>
	th{text-transform:uppercase;}
</style>
<script>
        var handleDataTableDefault = function() {
			"use strict";
			
			if ($('#data-table-default').length !== 0) {
				var table=$('#data-table-default').DataTable({
					responsive: false,
					processing: false,
					ordering: false,
					serverSide: false,
					ajax:"{{ url('simpanan/get_data')}}",
					columns: [
						{ data: 'id', render: function (data, type, row, meta) 
                            {
                              return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
						{ data: 'action', className: "text-center" },
						{ data: 'no_register' },
						{ data: 'name' },
						{ data: 'perusahaan' },
						{ data: 'uang_wajib', className: "text-right" },
						{ data: 'uang_sukarela', className: "text-right" },
						{ data: 'uang_pokok', className: "text-right" },
						
						
					],
					language: {
						paginate: {
							// remove previous & next text from pagination
							previous: '<< previous',
							next: 'Next>>'
						}
					}
				});
				
				
				
				table.columns().every(function () {
					var table = this;
					$('input', this.header()).on('keyup change', function () {
						if (table.search() !== this.value) {
							table.search(this.value).draw();
						}
					});
				});
				
				
			}
		};
        var handleDataTableDefaultwajib = function() {
			"use strict";
			
			if ($('#data-table-defaultwajib').length !== 0) {
				var tablewajib=$('#data-table-defaultwajib').DataTable({
					responsive: false,
					processing: false,
					ordering: false,
					serverSide: false,
					ajax:"{{ url('simpanan/get_data_wajib')}}",
					columns: [
						{ data: 'id', render: function (data, type, row, meta) 
                            {
                              return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
						{ data: 'no_register' },
						{ data: 'nama' },
						{ data: 'uang_nominal', className: "text-right" },
						{ data: 'created_at', className: "text-right" },
						
						
					],
					language: {
						paginate: {
							// remove previous & next text from pagination
							previous: '<< previous',
							next: 'Next>>'
						}
					}
				});
				
				
				
				tablewajib.columns().every(function () {
					var tablewajib = this;
					$('input', this.header()).on('keyup change', function () {
						if (tablewajib.search() !== this.value) {
							tablewajib.search(this.value).draw();
						}
					});
				});
				
				
			}
		};
        var handleDataTableDefaultsukarela = function() {
			"use strict";
			
			if ($('#data-table-defaultsukarela').length !== 0) {
				var tablesukarela=$('#data-table-defaultsukarela').DataTable({
					responsive: false,
					processing: false,
					ordering: false,
					serverSide: false,
					ajax:"{{ url('simpanan/get_data_sukarela')}}",
					columns: [
						{ data: 'id', render: function (data, type, row, meta) 
                            {
                              return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
						{ data: 'action' },
						
						{ data: 'no_register' },
						{ data: 'nama' },
						{ data: 'statusnya', className: "text-center" },
						{ data: 'uang_nominal', className: "text-right" },
						{ data: 'created_at', className: "text-right" },
						
						
					],
					language: {
						paginate: {
							// remove previous & next text from pagination
							previous: '<< previous',
							next: 'Next>>'
						}
					}
				});
				
				
				
				tablesukarela.columns().every(function () {
					var tablesukarela = this;
					$('input', this.header()).on('keyup change', function () {
						if (tablesukarela.search() !== this.value) {
							tablesukarela.search(this.value).draw();
						}
					});
				});
				
				
			}
		};

		var TableManageDefault = function () {
			"use strict";
			return {
				//main function
				init: function () {
					handleDataTableDefault();
				}
			};
		}();
		var TableManageDefaultwajib = function () {
			"use strict";
			return {
				//main function
				init: function () {
					handleDataTableDefaultwajib();
				}
			};
		}();
		var TableManageDefaultsukarela = function () {
			"use strict";
			return {
				//main function
				init: function () {
					handleDataTableDefaultsukarela();
				}
			};
		}();

		$(document).ready(function() {
			TableManageDefault.init();
			TableManageDefaultwajib.init();
			TableManageDefaultsukarela.init();
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
							<h4 class="panel-title">SIMPANAN ANGGOTA</h4>
							<div class="panel-heading-btn">
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
							</div>
						</div>
						<!-- end panel-heading -->
						<!-- begin panel-body -->
						<div class="panel-body">
								<div class="form-grup" style="margin-bottom:2%">
									
									<a href="javascript:;" class="btn btn-blue btn-sm m-r-2" onclick="tambah_wajib(`0`)"><i class="fa fa-plus"></i> Simpanan Wajib</a>
									<a href="javascript:;" class="btn btn-blue btn-sm m-r-2" onclick="tambah(`0`)"><i class="fa fa-plus"></i> Simpanan Sukarela</a>
								</div>
								
								<form id="data-all" action="{{url('/Warga/hapus')}}" method="post" enctype="multipart/form-data">
									@csrf
									
									<table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
										<thead>
											<tr>
												<th width="5%">No</th>
												<th width="5%"></th>
												<th width="10%">NO REGISTER</th>
												<th class="text-nowrap">NAMA</th>
												<th width="20%" class="text-nowrap">PERUSAHAAN</th>
												<th width="13%" class="text-nowrap">S.WAJIB</th>
												<th width="13%" class="text-nowrap">S.SUKARELA</th>
												<th width="13%" class="text-nowrap">S.POKOK</th>
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
				<div class="modal fade" id="modal-tambah-wajib" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
								<form  class="form-horizontal " id="mydatawajib" action="{{ url('simpanan/store_wajib_all') }}" method="post" enctype="multipart/form-data">
                                    @csrf
									<input type="submit">
									<div class="row">
										<div class="col-lg-3">
											<div class="input-group input-group-sm">
												<select class="form-control form-control-sm" onchange="pilih_perusahaan(this.value)"  name="perusahaan" id="perusahaan">
												<option value="ASDP">ASDP</option>	
												@foreach(get_perusahaan() as $per)
														<option value="{{$per->perusahaan}}">{{$per->perusahaan}}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="col-lg-3">
											<div class="input-group input-group-sm">
												<select class="form-control form-control-sm" onchange="pilih_bulan(this.value)"  name="bulan" id="bulan">
													@for($x=1;$x<13;$x++)
														<option value="{{ubah_bulan($x)}}" @if(date('m')==ubah_bulan($x)) selected @endif >{{bulan(ubah_bulan($x))}}</option>
													@endfor
												</select>
											</div>
										</div>
										<div class="col-lg-3">
											<div class="input-group input-group-sm">
												<select class="form-control form-control-sm"  onchange="pilih_tahun(this.value)" name="tahun" id="tahun">
													@for($x=2022;$x<(date('Y')+1);$x++)
														<option value="{{$x}}"  @if(date('Y')==$x) selected @endif >{{$x}}</option>
													@endfor
												</select>
											</div>
										</div>
										<div class="col-lg-3">
											<span class="btn btn-primary" onclick="proses_wajib_all()">Proses Seleksi</span>
										</div>
										<div class="col-lg-12">
                                    		<div id="tampil_tambah_wajib"></div>
										</div>
									</div>
									
                                </form>   
                            </div>
                            <div class="modal-footer">
                                <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Tutup</a>
                                
                            </div>
                        </div>
                    </div>
                </div>
				<div class="modal fade" id="modal-tambah" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
								<form  class="form-horizontal " id="mydata2" action="{{url('/Warga/')}}" method="post" enctype="multipart/form-data">
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
				<div class="modal fade" id="modal-wajib" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="background: #0c0c0c;">
                                <h4 class="modal-title"></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
									<table id="data-table-defaultwajib" width="100%" class="table table-striped table-bordered table-td-valign-middle">
										<thead>
											<tr>
												<th width="5%">No</th>
												<th width="15%">NO REGISTER</th>
												<th class="text-nowrap">NAMA</th>
												<th width="20%" class="text-nowrap">NILAI</th>
												<th width="20%">WAKTU</th>
											</tr>
											
										</thead>
									</table>
							</div>
                            <div class="modal-footer">
                                <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Tutup</a>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="modal fade" id="modal-sukarela" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="background: #0c0c0c;">
                                <h4 class="modal-title"></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
									<table id="data-table-defaultsukarela" width="100%" class="table table-striped table-bordered table-td-valign-middle">
										<thead>
											<tr>
												<th width="5%">No</th>
												<th width="5%"></th>
												<th width="15%">NO REGISTER</th>
												<th class="text-nowrap">NAMA</th>
												<th class="text-nowrap">STATUS</th>
												<th width="20%" class="text-nowrap">NILAI</th>
												<th width="20%">WAKTU</th>
											</tr>
											
										</thead>
									</table>
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
			$('#tampil_tambah').load("{{url('simpanan/tambah')}}?id="+id);
			
		}
		function view_wajib(id){
			$('#modal-wajib').modal('show');
			var tablewajib=$('#data-table-defaultwajib').DataTable();
				tablewajib.ajax.url("{{ url('simpanan/get_data_wajib')}}?no_register="+id).load();
			
		}
		function view_sukarela(id){
			$('#modal-sukarela').modal('show');
			var tablesukarela=$('#data-table-defaultsukarela').DataTable();
				tablesukarela.ajax.url("{{ url('simpanan/get_data_sukarela')}}?no_register="+id).load();
			
		}
		function pilih_bulan(bulan){
			var tahun=$('#tahun').val();
			$('#tampil_tambah_wajib').load("{{url('simpanan/tambah_wajib')}}?bulan="+bulan+"&tahun="+tahun);
			
		}
		function pilih_perusahaan(perusahaan){
			$('#tampil_tambah_wajib').load("{{url('simpanan/tambah_wajib')}}?perusahaan="+perusahaan);
			
		}
		function pilih_tahun(tahun){
			var bulan=$('#bulan').val();
			$('#tampil_tambah_wajib').load("{{url('simpanan/tambah_wajib')}}?bulan="+bulan+"&tahun="+tahun);
			
		}
		function tambah_wajib(id){
			$('#modal-tambah-wajib').modal('show');
			$('#tampil_tambah_wajib').load("{{url('simpanan/tambah_wajib')}}?id="+id);
			
		}
		function show_foto(file){
			$('#modal-file').modal('show');
			$('#tampil_file').html("<img src='{{url('/public/_icon')}}/"+file+"' width='100%'>");
			
		}
		function show_foto(file,kode_qr){
			$('#modal-file').modal('show');
			$('#tampil_file').load("{{url('simpanan/view_file')}}?file="+file+"&kode_qr="+kode_qr);
			
		}
		function hapus_wajib(id,bulan,tahun){
           
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
                           url: "{{url('simpanan/hapus_wajib')}}",
                           data: "id="+id+"&bulan="+bulan+"&tahun="+tahun,
                           success: function(msg){
                               swal("Success! berhasil terhapus!", {
                                   icon: "success",
                               });
							   var bat=msg.split('@');
                               $('#tampil_tambah_wajib').load("{{url('simpanan/tambah_wajib')}}?bulan="+bat[1]+"&tahun="+bat[2]);
                           }
                       });
                   
                   
               } else {
                   
               }
           });
           
        }
		function delete_sukarela(id,no_register){
           
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
                           url: "{{url('simpanan/delete_sukarela')}}",
                           data: "id="+id+"&no_register="+no_register,
                           success: function(msg){
                               swal("Success! berhasil terhapus!", {
                                   icon: "success",
                               });
							   var bat=msg.split('@');
                               var tablesukarela=$('#data-table-defaultsukarela').DataTable();
									tablesukarela.ajax.url("{{ url('simpanan/get_data_sukarela')}}?no_register="+bat[1]).load();
                           }
                       });
                   
                   
               } else {
                   
               }
           });
           
        }
		function proses_wajib(no_register,bulan,tahun){
           
           swal({
               title: "Yakin proses data ini ?",
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
                           url: "{{url('simpanan/store_wajib')}}",
                           data: "no_register="+no_register+"&bulan="+bulan+"&tahun="+tahun,
                           success: function(msg){
                               swal("Success! berhasil diproses", {
                                   icon: "success",
                               });
							   var bat=msg.split('@');
                               $('#tampil_tambah_wajib').load("{{url('simpanan/tambah_wajib')}}?bulan="+bat[1]+"&tahun="+bat[2]+"&perusahaan="+bat[3]);
                           }
                       });
                   
                   
               } else {
                   
               }
           });
           
        }
		function simpan_data(){
                
				var form=document.getElementById('mydata2');
				$.ajax({
					type: 'POST',
					url: "{{ url('simpanan/store_sukarela') }}",
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
		function proses_wajib_all(){
                
				var form=document.getElementById('mydatawajib');
				$.ajax({
					type: 'POST',
					url: "{{ url('simpanan/store_wajib_all') }}",
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
							swal("Success! berhasil diproses", {
								icon: "success",
							});
							$('#tampil_tambah_wajib').load("{{url('simpanan/tambah_wajib')}}?bulan="+bat[2]+"&tahun="+bat[3]+"&perusahaan="+bat[4]);
							var tables=$('#data-table-default').DataTable();
                                tables.ajax.url("{{ url('simpanan/get_data')}}").load();
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