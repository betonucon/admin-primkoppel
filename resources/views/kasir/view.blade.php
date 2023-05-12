@extends('layouts.web')

@push('ajax')
<style>
	table.dataTable th{text-transform:uppercase;text-align:left !important}
	td{background:#fdf2f2}
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
					lengthMenu: [20,50,100],
                    searching:true,
                    lengthChange:false,
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
                    dom: 'lrtip',
					ajax:"{{ url('kasir/get_data_stok')}}?no_transaksi={{$data->no_order}}",
					columns: [
						{ data: 'id', render: function (data, type, row, meta) 
                            {
                              return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
						{ data: 'action', className: "text-center" },
						{ data: 'kode_barang' },
						{ data: 'nama_barang' },
						{ data: 'satuan' , className: "text-center" },
						{ data: 'diskon' , className: "text-center" },
						
						{ data: 'uang_qty' , className: "text-center" },
						{ data: 'uang_harga_jual', className: "text-right" },
						{ data: 'uang_profit', className: "text-right" },
						{ data: 'uang_total', className: "text-right" },
						
						
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
			$('#qtyty').val(0);
			$("#diskon").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
			$("#qtyty").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
			$("#harga_modal").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
			$("#harga_jual").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
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
							<h4 class="panel-title">STOK ORDER {{$data->no_order}}</h4>
							<div class="panel-heading-btn">
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
							</div>
						</div>
						<!-- end panel-heading -->
						<!-- begin panel-body -->
						<div class="panel-body">
								<div class="btn-group btn-group-justified" style="margin-bottom:2%">
									@if($method==1)
										<a class="btn btn-default btn-sm active" >QR Code</a>
										<a class="btn btn-default btn-sm " onclick="location.assign(`{{url('kasir/view')}}?nomor={{$data->no_order}}&method=2`)">Search By</a>
									@else
									
										<a class="btn btn-default btn-sm " onclick="location.assign(`{{url('kasir/view')}}?nomor={{$data->no_order}}&method=1`)">QR Code</a>
										<a class="btn btn-default btn-sm active" >Search By</a>
									@endif
								</div>
								<form id="mydata" class="form-horizontal" action="{{url('/kasir/store_barang')}}" method="post" enctype="multipart/form-data">
									@csrf
									<input type="hidden" name="no_order" value="{{$data->no_order}}">
									@if($method==1)
									<div class="form-group row">
										<label class="col-lg-2 col-form-label text-right">QR Code</label>
										<div class="col-lg-4">
											<div class="input-group input-group-sm">
												<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-qrcode"></i></span></div>
												<input type="text" value="{{$data->kode_qr}}" class="form-control" name="kode_qr" id="kode_qr"  onkeypress="show_qr(this.value)" placeholder="Ketik disini....">
												
											</div>
										</div>
									</div>
									@else
									<div class="form-group row">
										<label class="col-lg-2 col-form-label text-right">Cari Barang</label>
										<div class="col-lg-5">
											<div class="input-group input-group-sm">
												<select name="kode" onchange="show_qr(this.value)" class="form-control form-control-sm sele2" id="default-select2" placeholder="Ketik disini....">
                           
													<option value="">Cari Nama Barang</option>
													
												</select>
												
											</div>
										</div>
									</div>
									@endif
									<div class="form-group row">
										<label class="col-lg-2 col-form-label text-right">Barang</label>
										<div class="col-lg-2">
											<div class="input-group input-group-sm">
												<input type="hidden" class="form-control" readonly name="kode_barang" id="kode_barang_key" value="{{$data->kode_barang}}" placeholder="Ketik disini....">
												<input type="text" class="form-control" disabled  id="kode_barang" value="{{$data->kode_barang}}" placeholder="Ketik disini....">
											</div>
										</div>
										<div class="col-lg-1">
											<div class="input-group input-group-sm">
												<input type="text" class="form-control" readonly name="stok" id="stok" value="{{$data->stok}}" placeholder="Ketik disini....">
											</div>
										</div>
										<div class="col-lg-6">
											<div class="input-group input-group-sm">
												<input type="text" class="form-control" disabled name="nama_barang" id="nama_barang" value="{{$data->nama_barang}}" placeholder="Ketik disini....">
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-2 col-form-label text-right">Harga Jual & Modal</label>
										<div class="col-lg-2">
											<div class="input-group input-group-sm">
												<input type="text" class="form-control" readonly name="harga_jual" id="harga_jual" onkeypress="proses_enter(event)" value="{{$data->nama_barang}}" placeholder="Ketik disini....">
											</div>
										</div>
										<div class="col-lg-2">
											<div class="input-group input-group-sm">
												<input type="text" class="form-control" disabled name="harga_modal" id="harga_modal" onkeypress="proses_enter(event)" value="{{$data->nama_barang}}" placeholder="Ketik disini....">
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-2 col-form-label text-right">Qty & Discon (%)</label>
										<div class="col-lg-1">
											<div class="input-group input-group-sm">
												<input type="text" class="form-control" onkeypress="proses_enter(event)" name="qty" id="qtyty"  placeholder="Ketik disini....">
											</div>
										</div>
										<div class="col-lg-2">
											<div class="input-group input-group-sm">
												<input type="text" class="form-control"  name="diskon" id="diskon" onkeypress="proses_enter(event)" value="{{$data->nama_barang}}" placeholder="Ketik disini....">
											</div>
										</div>
										
									</div>
								</form>
						</div>
						
						<div class="panel-body" style="background: #d4d4e3;">
							<div class="row" style="margin: 0px; margin-bottom: 1%; padding-top: 0.5%;">
								<div class="col-md-5">
									
									@if($data->status==1)
										<span class="btn btn-primary btn-sm text-white" onclick="proses_bayar({{$data->id}})">Selesai</span>
										<span class="btn  btn-sm text-white" >Cetak</span>
									@endif
									@if($data->status==2)
										<span class="btn btn-default btn-sm text-white" >Selesai</span>
										<span class="btn btn-info btn-sm text-white" >Cetak</span>
									@endif
									
								</div>
								<div class="col-md-4">
									<input type="text" id="cari_datatable" placeholder="Search....." class="form-control input-sm">
								</div>
								<div class="col-md-3" style="padding: 0px 0px;">
									<div id="total_harga_kasir" style="background: #f3f096; font-size: 22px; padding: 1%;text-align:right"></div>
								</div>
							</div>
							<table id="data-table-default"  class="table table-bordered table-td-valign-middle">
								<thead>
									<tr>
										<th width="5%">No</th>
										<th width="5%"></th>
										<th width="6%">KODE</th>
										<th class="text-nowrap">NAMA BARANG</th>
										<th width="6%" class="text-nowrap">SATUAN</th>
										<th width="6%" class="text-nowrap">DISC %</th>
										<th width="6%" class="text-nowrap">QTY</th>
										<th width="9%" class="text-nowrap">HARGA </th>
										<th width="9%" class="text-nowrap">PROFIT </th>
										<th width="10%" class="text-nowrap">TOTAL</th>
										
									</tr>
									
								</thead>
							</table>
						</div>
						<!-- end panel-body -->
					</div>
					<!-- end panel -->
				</div>
				
			</div>

			<div class="row">
				<div class="modal fade" id="modal-bayar" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
								<form  class="form-horizontal " id="mydatabayar" action="{{url('/Warga/')}}" method="post" enctype="multipart/form-data">
                                    @csrf
									
                                    	<div id="tampil_bayar"></div>
									
                                </form>   
                            </div>
                            <div class="modal-footer">
                                <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Tutup</a>
                                <a href="javascript:;" class="btn btn-blue" onclick="simpan_bayar()">Simpan</a>
                                
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

		$('#total_harga_kasir').load("{{url('kasir/total_harga_kasir')}}?id={{$data->id}}");
		function proses_bayar(id){
			$('#modal-bayar').modal('show');
			$('#tampil_bayar').load("{{url('kasir/bayar')}}?id="+id);
			
		}
		$('#default-select2').select2({
            minimumInputLength: 1,
            allowClear: true,
            placeholder: 'Masukan Nama Barang',
            ajax: {
                dataType: 'json',
                url: "{{url('barang/get_data_barang')}}",
                delay: 1000,
                data: function(params) {
                    return {
                        search: params.term
                    }
                },
                processResults: function (data, page) {
                    return {
                        results: data
                    };
                },
            }
        });

		@if($method==2)
        	$("#default-select2").select2('open');
        @endif

		function show_qr(text){

			setTimeout(exce(text), 19000);
			
			
		}
		function show_qr(text){
			
				$.ajax({
					type: 'GET',
					url: "{{url('barang/cari_barang')}}?act={{$method}}",
					data: "text="+text,
					success: function(msg){
						var bat=msg.split('@');
						
						$('#kode_barang_key').val(bat[1]);
						$('#kode_barang').val(bat[1]);
						$('#nama_barang').val(bat[2]);
						$('#harga_modal').val(bat[3]);
						$('#harga_jual').val(bat[4]);
						$('#stok').val(bat[5]);
						$('#qtyty').val(0);
						$('#qtyty').focus();
						
					}
				});
			
			
			
		}

		function delete_barang(id){
           
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
                           url: "{{url('kasir/delete_barang')}}",
                           data: "id="+id,
                           success: function(msg){
                               swal("Success! berhasil terhapus!", {
                                   icon: "success",
                               });
                               var tables=$('#data-table-default').DataTable();
                                tables.ajax.url("{{ url('kasir/get_data_stok')}}?no_transaksi={{$data->no_order}}").load();
                           }
                       });
                   
                   
               } else {
                   
               }
           });
           
        }
		function proses_enter(e){
			if(e.keyCode === 13){
				
                var form=document.getElementById('mydata');
				$.ajax({
					type: 'POST',
					url: "{{ url('kasir/store_barang') }}",
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
							$('#kode_barang_key').val("");
							$('#kode_qr').val("");
							$('#kode_barang').val("");
							$('#nama_barang').val("");
							$('#harga_modal').val("");
							$('#harga_jual').val("");
							$('#stok').val("");
							$('#qtyty').val(0);
							$('#kode_qr').focus();
							@if($method==2)
								$("#default-select2").select2('open');
							@else
								$('#kode_qr').focus();
							@endif
							$('#total_harga_kasir').load("{{url('kasir/total_harga_kasir')}}?id={{$data->id}}");
							var tables=$('#data-table-default').DataTable();
                                tables.ajax.url("{{ url('kasir/get_data_stok')}}?no_transaksi={{$data->no_order}}").load();
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
        }

		function simpan_bayar(){
                
				var form=document.getElementById('mydatabayar');
				$.ajax({
					type: 'POST',
					url: "{{ url('kasir/store_bayar') }}",
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
							location.assign("{{url('kasir')}}")
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