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
					responsive: true,
					processing: false,
					ordering: false,
					serverSide: false,
					ajax:"{{ url('master/satuan/get_data')}}",
					columns: [
						{ data: 'id', render: function (data, type, row, meta) 
                            {
                              return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
						{ data: 'action', className: "text-center" },
						{ data: 'satuan' },
						{ data: 'satuan_pecah' , className: "text-center" },
						
						
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
							<h4 class="panel-title">MASTER SATUAN</h4>
							<div class="panel-heading-btn">
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
							</div>
						</div>
						<!-- end panel-heading -->
						<!-- begin panel-body -->
						<div class="panel-body">
								<div class="form-grup" style="margin-bottom:2%">
									
									<a href="javascript:;" class="btn btn-blue btn-sm m-r-2" onclick="tambah(`0`)"><i class="fa fa-plus"></i> Tambah</a>
								</div>
								
								<form id="data-all" action="{{url('/Warga/hapus')}}" method="post" enctype="multipart/form-data">
									@csrf
									
									<table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
										<thead>
											<tr>
												<th width="5%">No</th>
												<th width="5%"></th>
												<th class="text-nowrap">SATUAN</th>
												<th width="10%" class="text-nowrap">PECAH</th>
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
								<form  class="form-horizontal " id="mydata" action="{{ url('master/satuan/') }}" method="post" enctype="multipart/form-data">
                                    
									@csrf
									<input type="submit">
									
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
			$('#tampil_tambah').load("{{url('master/satuan/tambah')}}?id="+id);
			
		}
		function show_foto(file){
			$('#modal-file').modal('show');
			$('#tampil_file').html("<img src='{{url('/public/_icon')}}/"+file+"' width='100%'>");
			
		}
		function show_foto(file,kode_qr){
			$('#modal-file').modal('show');
			$('#tampil_file').load("{{url('barang/view_file')}}?file="+file+"&kode_qr="+kode_qr);
			
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
                           url: "{{url('master/satuan/delete')}}",
                           data: "id="+id,
                           success: function(msg){
                               swal("Success! berhasil terhapus!", {
                                   icon: "success",
                               });
                               var tables=$('#data-table-default').DataTable();
                                tables.ajax.url("{{ url('master/satuan/get_data')}}").load();
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
					url: "{{ url('master/satuan/') }}",
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
                                tables.ajax.url("{{ url('master/satuan/get_data')}}").load();
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