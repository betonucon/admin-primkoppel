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
					ajax:"{{ url('Transaksi/get_data?tahun='.$tahun.'&kategori='.$kategori)}}",
					columns: [
						{ data: 'id', render: function (data, type, row, meta) 
							{
								return data;
							} 
						},
						{ data: 'nama_transaksi' },
						{ data: 'nominal_uang' },
						{ data: 'margin_uang' },
						{ data: 'tanggal' },
						{ data: 'kategori' },
						{ data: 'status' },
						
					],
					language: {
						paginate: {
							// remove previous & next text from pagination
							previous: '<< previous',
							next: 'Next>>'
						}
					}
				});
				// $('#data-table-default thead td:eq(1)').each(function () {
				// 	var title = $(this).text();
				// 	$(this).html(title+' <input type="text" class="col-search-input" style="display:block;border: solid 1px #b9a4a4; padding: 3px; width: 100%;" placeholder="CARI ' + title + '" />');
				// });
				// $('#data-table-default thead td:eq(2)').each(function () {
				// 	var title = $(this).text();
				// 	$(this).html(title+' <input type="text" class="col-search-input" style="display:block;border: solid 1px #b9a4a4; padding: 3px; width: 100%;" placeholder="CARI ' + title + '" />');
				// });
				// $('#data-table-default thead td:eq(3)').each(function () {
				// 	var title = $(this).text();
				// 	$(this).html(title+' <input type="text" class="col-search-input" style="display:block;border: solid 1px #b9a4a4; padding: 3px; width: 100%;" placeholder="CARI ' + title + '" />');
				// });
				// $('#data-table-default thead td:eq(4)').each(function () {
				// 	var title = $(this).text();
				// 	$(this).html(title+' <input type="text" class="col-search-input" style="display:block;border: solid 1px #b9a4a4; padding: 3px; width: 100%;" placeholder="CARI ' + title + '" />');
				// });
				// $('#data-table-default thead td:eq(5)').each(function () {
				// 	var title = $(this).text();
				// 	$(this).html(title+' <input type="text" class="col-search-input" style="display:block;border: solid 1px #b9a4a4; padding: 3px; width: 100%;" placeholder="CARI ' + title + '" />');
				// });
				// $('#data-table-default thead td:eq(6)').each(function () {
				// 	var title = $(this).text();
				// 	$(this).html(title+' <input type="text" class="col-search-input" style="display:block;border: solid 1px #b9a4a4; padding: 3px; width: 100%;" placeholder="CARI ' + title + '" />');
				// });
				
				
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
            <h4 class="panel-title">Transaksi Keuangan</h4>
            <div class="panel-heading-btn">
                <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a> -->
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <div class="input-group m-b-10" style="width: 60%;">
                @if(Auth::user()->role_id==2)
                <div class="input-group-append" style="border-right: solid 3px #f1eaea;"><span class="input-group-text" onclick="tambah()" style="cursor: pointer;"><i class="fa fa-plus"></i> Tambah Transaksi</span></div>
                @endif
                <select id="tahun" class="form-control" style="display:inline;width:15%">
                    @foreach(get_tahun_transaksi() as $get_tahun_transaksi)
                        <option value="{{$get_tahun_transaksi->tahun}}" @if($get_tahun_transaksi->tahun==$tahun) selected @endif>{{$get_tahun_transaksi->tahun}}</option>
                    @endforeach
                </select>
                <div class="input-group-append" style="border-right: solid 3px #f1eaea;"><span class="input-group-text" onclick="cari()" style="cursor: pointer;"><i class="fa fa-search"></i> Cari</span></div>
            
                <select id="kategori_id" class="form-control" style="display:inline;width:15%">
                        <option value="all">-- Semua Kategori --</option>
                        @foreach(get_kategori() as $get_kategori)
                            <option value="{{$get_kategori->id}}" @if($kategori==$get_kategori->id) selected @endif>- {{$get_kategori->name}}</option>
                        @endforeach
                </select>
                <div class="input-group-append" ><span class="input-group-text" onclick="cari()" style="cursor: pointer;"><i class="fa fa-search"></i> Cari</span></div>
                
            </div>
            <dl class="row" style="margin-bottom: 0px;background: #f1fbd8;">
                <dt class="text-inverse text-right col-4 text-truncate">Margin</dt>
                <dd class="col-8 text-truncate">Rp.{{uang(margin_transaksi($tahun))}}</dd>
                <dt class="text-inverse text-right col-4 text-truncate">Transaksi Masuk</dt>
                <dd class="col-8 text-truncate">Rp.{{uang(masuk_transaksi($tahun))}}</dd>
                <dt class="text-inverse text-right col-4 text-truncate">Transaksi Keluar</dt>
                <dd class="col-8 text-truncate">Rp.{{uang(keluar_transaksi($tahun))}}</dd>
                <dt class="text-inverse text-right col-4 text-truncate">Total</dt>
                <dd class="col-8 text-truncate">Rp.{{uang(masuk_transaksi($tahun)-keluar_transaksi($tahun))}}</dd>
            </dl>
            <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Transaksi</th>
                        <th width="10%">Nominal</th>
                        <th width="10%">Margin</th>
                        <th width="12%">Tanggal</th>
                        <th width="18%">Kategori</th>
                        <th width="8%">Status</th>
                    </tr>
                </thead>
                
            </table>

        </div>
        
    </div>

    <div class="row">
        <div class="modal" id="modal-tambah" aria-hidden="true" style="display: none;background: #1717198a;">
			<div class="modal-dialog modal-lg" style="margin-top:0px">
				<div class="modal-content">
                    <div class="modal-header">
						<h4 class="modal-title">Tambah Transaksi</h4>
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
                        <form id="mytransaksi" action="{{url('Transaksi/simpan')}}" method="post" enctype="multipart/form-data">
                              
                            <div class="col-xl-10 offset-xl-2">
                                <div class="form-group row m-b-10">
                                    <label class="col-lg-3 text-lg-right col-form-label">Nama Transaksi</label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" name="name" placeholder="Ketik disini...." class="form-control">
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
                                    <label class="col-lg-3 text-lg-right col-form-label">Kategori Transaksi</label>
                                    <div class="col-lg-9 col-xl-6">
                                        
                                        <select class="form-control" name="kategori_id">
                                            <option value="">-- Pilih --</option>
                                            @foreach(get_kategori_transaksi() as $get_kategori_transaksi)
                                                <option value="{{$get_kategori_transaksi->id}}">- {{$get_kategori_transaksi->name}}</option>
                                            @endforeach
                                        </select>
                                            
                                    </div>
                                </div>
                                <div class="form-group row m-b-10">
                                    <label class="col-lg-3 text-lg-right col-form-label">Tanggal</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input type="text" name="tanggal" id="datepicker" placeholder="Ketik disini...." class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row m-b-10">
                                    <label class="col-lg-3 text-lg-right col-form-label">Periode Bulan & Tahun</label>
                                    <div class="col-lg-9 col-xl-4">
                                        
                                        <select class="form-control" name="bulan">
                                            <option value="">-- Pilih --</option>
                                            @for($bul=1;$bul<13;$bul++)
                                                <option value="{{ubah_bulan($bul)}}">- {{bulan(ubah_bulan($bul))}}</option>
                                            @endfor
                                        </select>
                                            
                                    </div>
                                    <div class="col-lg-9 col-xl-4">
                                        
                                        <select class="form-control" name="tahun">
                                            <option value="">-- Pilih --</option>
                                            @for($thn=2020;$thn<=date('Y');$thn++)
                                                <option value="{{$thn}}">- {{$thn}}</option>
                                            @endfor
                                        </select>
                                            
                                    </div>
                                </div>

                                <div class="form-group row m-b-10">
                                    <label class="col-lg-3 text-lg-right col-form-label">Status Transaksi</label>
                                    <div class="col-lg-9 col-xl-6">
                                        
                                        <select class="form-control" name="sts">
                                            <option value="">-- Pilih --</option>
                                            <option value="1">- Keuangan Masuk</option>
                                            <option value="2">- Keuangan Keluar</option>
                                        </select>
                                            
                                    </div>
                                </div>
                                
                                
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

        function hanyaAngka(evt) {
		  var charCode = (evt.which) ? evt.which : event.keyCode
		   if (charCode > 31 && (charCode < 48 || charCode > 57))
 
		    return false;
		  return true;
		}

        function tambah(){
            $('#modal-tambah').modal('show');
        }
        function cari(){
            var tahun=$('#tahun').val();
            var kategori=$('#kategori_id').val();
            location.assign("{{url('Transaksi')}}?tahun="+tahun+"&kategori="+kategori);
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

        function view_tagihan(nomorpinjaman){
            
			$.ajax({
				type: 'GET',
				url: "{{url('TransaksiPinjaman/view_tagihan')}}",
				data: "nomorpinjaman="+nomorpinjaman,
				success: function(msg){
					$('#modal-view_tagihan').modal('show');
					$('#view_tagihan').html(msg);
				}
			});
			
		}

        function simpan(){
            
            var form=document.getElementById('mytransaksi');
            var token= "{{csrf_token()}}";
                $.ajax({
                    type: 'POST',
                    url: "{{url('/Transaksi/simpan')}}?_token="+token,
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