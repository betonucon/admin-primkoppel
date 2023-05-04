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
					ajax:"{{ url('Anggota/get_data')}}",
					columns: [
						{ data: 'id', render: function (data, type, row, meta) 
							{
								return '<input type="checkbox" name="id[]" value="'+data+'" >';
							} 
						},
						{ data: 'nik' },
						{ data: 'name' },
						{ data: 'dept' },
						{ data: 'email' },
						{ data: 'status' },
						{ data: 'action' },
						
					],
					language: {
						paginate: {
							// remove previous & next text from pagination
							previous: '<< previous',
							next: 'Next>>'
						}
					}
				});
				$('#data-table-default thead td:eq(1)').each(function () {
					var title = $(this).text();
					$(this).html(title+' <input type="text" class="col-search-input" style="display:block;border: solid 1px #b9a4a4; padding: 3px; width: 100%;" placeholder="CARI ' + title + '" />');
				});
				$('#data-table-default thead td:eq(2)').each(function () {
					var title = $(this).text();
					$(this).html(title+' <input type="text" class="col-search-input" style="display:block;border: solid 1px #b9a4a4; padding: 3px; width: 100%;" placeholder="CARI ' + title + '" />');
				});
				$('#data-table-default thead td:eq(3)').each(function () {
					var title = $(this).text();
					$(this).html(title+' <input type="text" class="col-search-input" style="display:block;border: solid 1px #b9a4a4; padding: 3px; width: 100%;" placeholder="CARI ' + title + '" />');
				});
				$('#data-table-default thead td:eq(4)').each(function () {
					var title = $(this).text();
					$(this).html(title+' <input type="text" class="col-search-input" style="display:block;border: solid 1px #b9a4a4; padding: 3px; width: 100%;" placeholder="CARI ' + title + '" />');
				});
				$('#data-table-default thead td:eq(5)').each(function () {
					var title = $(this).text();
					$(this).html(title+' <input type="text" class="col-search-input" style="display:block;border: solid 1px #b9a4a4; padding: 3px; width: 100%;" placeholder="CARI ' + title + '" />');
				});
				$('#data-table-default thead td:eq(6)').each(function () {
					var title = $(this).text();
					$(this).html(title+' <input type="text" class="col-search-input" style="display:block;border: solid 1px #b9a4a4; padding: 3px; width: 100%;" placeholder="CARI ' + title + '" />');
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
							<h4 class="panel-title">DATA</h4>
							<div class="panel-heading-btn">
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
							</div>
						</div>
						<!-- end panel-heading -->
						<!-- begin panel-body -->
						<div class="panel-body">
								<div class="form-grup" style="margin-bottom:2%">
									
									<a href="javascript:;" class="btn btn-blue m-r-2" onclick="tambah(`0`)"><i class="fa fa-plus"></i> Tambah</a>
									<a href="javascript:;" class="btn btn-red m-r-2" onclick="hapus()"><i class="fa fa-times"></i> Hapus</a>
								</div>
								
								<form id="data-all" action="{{url('/Warga/hapus')}}" method="post" enctype="multipart/form-data">
									@csrf
									<table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
										<thead>
											<tr>
												<th width="5%">No</th>
												<th width="10%">NIK</th>
												<th class="text-nowrap">Name</th>
												<th class="text-nowrap">Depart</th>
												<th class="text-nowrap">Status</th>
												<th class="text-nowrap" width="5%">Act</th>
											</tr>
											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
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
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header" style="background: #0c0c0c;">
                                <h4 class="modal-title"></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <form id="data-tambah" action="{{url('/Warga/')}}" method="post" enctype="multipart/form-data">
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
				<div class="modal fade" id="modal-confirmasi" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="background: #0c0c0c;">
                                <h4 class="modal-title"></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <div id="confirmasi"></div>
							</div>
                            <div class="modal-footer">
                                <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Batal</a>
                                <a href="javascript:;" class="btn btn-blue" onclick="hapus_data()">Hapus</a>
                                
                            </div>
                        </div>
                    </div>
                </div>

			</div>
			
			<!-- end row -->
		</div>

@endsection

@push('ajax')
	
@endpush