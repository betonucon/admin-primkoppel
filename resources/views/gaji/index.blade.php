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
            <h4 class="panel-title">GAJI</h4>
            <div class="panel-heading-btn">
                <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a> -->
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <div class="alert alert-yellow fade show m-b-10">
                <span class="close" data-dismiss="alert">×</span>
                <strong>Notifikasi!</strong> Verifikasi Masa Kontrak Kerja Karyawan dengan akhir pinjaman.
            </div>
            <div class="input-group m-b-10" style="width: 40%;">
                <span class="btn btn-blue btn-sm" onclick="upload()"><i class="fa fa-upload"></i> Upload Slip</span>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <select id="tahun" class="form-control" onchange="cari_tahun(this.value)" style="display:inline;width:8%">
                    @foreach(get_slid() as $get_tahun_transaksi)
                        <option value="{{$get_tahun_transaksi->tahun}}" @if($get_tahun_transaksi->tahun==$tahun) selected @endif>{{$get_tahun_transaksi->tahun}}</option>
                    @endforeach
                </select>&nbsp;&nbsp;
                <select id="tahun" class="form-control" onchange="cari_bulan(this.value)" style="display:inline;width:8%">
                    @for($bl=1;$bl<13;$bl++)
                        <option value="{{ubah_bulan($bl)}}" @if($bulan==$bl) selected @endif>{{bulan(ubah_bulan($bl))}}</option>
                    @endfor
                </select>

            </div>
            <table id="datafixedheader" class="table table-striped table-bordered table-td-valign-middle">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="7%">NIK</th>
                        <th class="text-wrap">Name</th>
                        <th width="12%" class="text-nowrap">Pendapatan</th>
                        <th width="12" class="text-nowrap">Potongan</th>
                        <th width="12%" class="text-nowrap">Kontribusi</th>
                        <th width="10%" class="text-nowrap">Terima</th>
                        <th class="text-nowrap" width="9%">Act</th>
                    </tr>
                </thead>
                <tbody>
                  
                    @foreach(get_slip_gaji($tahun,$bulan) as $no=>$data)
                        <tr class="odd gradeX">
                            <td>{{$no+1}}</td>
                            <td>{{$data->nik}}</td>
                            <td>{{$data->usernya['name']}}</td>
                            <td>{{uang($data->total_upah)}}</td>
                            <td>{{uang($data->total_potongan)}}</td>
                            <td>{{uang($data->comp)}}</td>
                            <td>{{uang($data->total_upah-$data->total_potongan)}}</td>
                            <td>
                            <span onclick="view({{$data->nik}},`{{$data->bulan}}`,`{{$data->tahun}}`)" class="btn btn-purple active btn-xs"><i class="fas fa-search fa-sm"></i> SLIP</span> 
                            </td>
                        </tr>
                    @endforeach
                    
                    
                </tbody>
            </table>

        </div>
        
    </div>

    <div class="row">
        <div class="modal" id="modal-lihat-file" aria-hidden="true" style="display: none;background: #1717198a;">
			<div class="modal-dialog" style="margin-top:0px;max-width:70%">
				<div class="modal-content">
                    <div class="modal-header">
						<h4 class="modal-title">SLIP GAJI</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
                        <div id="lihat-file"></div>
					</div>
					
				</div>
			</div>
		</div>
        <div class="modal" id="modalimport" aria-hidden="true" style="display: none;background: #1717198a;">
			<div class="modal-dialog" style="margin-top:0px;">
				<div class="modal-content">
                    <div class="modal-header">
						<h4 class="modal-title">UPLOAD SLIP GAJI</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
                        <div id="notifimport"></div>
                        <form id="myimport" method="post" enctype="multipart/form-data">
							@csrf
					        <div clasas="form-grup">
                                <label>Upload FIle Excel</label>
                                <input type="file" name="file" class="form-control">

                            </div>
                        </form><br><br>
                        <span class="btn btn-blue" onclick="import_data()">Import</span>
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
        });

        function cari_tahun(tahun){
			var bulan = $('#bulan').val();
			location.assign("{{url('Gaji')}}?bulan="+bulan+"&tahun="+tahun);
		}
        function upload(){
            $('#modalimport').modal('show');
        }
        function cari_bulan(bulan){
			var tahun = $('#tahun').val();
			location.assign("{{url('Gaji')}}?bulan="+bulan+"&tahun="+tahun);
		}

        function view(nik,bulan,tahun){
            var file="<iframe src='{{url('Gaji/cetak')}}?nik="+nik+"&bulan="+bulan+"&tahun="+tahun+"' height='550' width='100%'></iframe>";
			$('#modal-lihat-file').modal('show');
			$('#lihat-file').html(file);
        } 

        function import_data(){
            
            var form=document.getElementById('myimport');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/Gaji/import_data')}}",
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
                            $('#notifimport').html(msg);
                        }
                        
                        
                    }
                });

        } 
    </script>

@endpush