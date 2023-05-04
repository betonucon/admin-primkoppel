<input type="hidden" name="id" value="{{$data->id}}">
<div class="form-group row">
	<label class="col-lg-12 head-form">
		<span class="fa-stack fa-1x text-primary">
			<i class="far fa-square fa-stack-2x"></i>
			<i class="fas fa-pencil-alt fa-stack-1x"></i>
		</span> 
		Form Pembayaran Pinjaman
	</label>
	
</div>

<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Anggota </label>
	<div class="col-lg-7">
		<div class="input-group input-group-sm">
			<input type="text" disabled class="form-control" style="text-transform:uppercase" name="nama" value="{{$data->nama}}" placeholder="Ketik disini....">
		</div>
	</div>
</div>
<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Perusahaan </label>
	<div class="col-lg-9">
		<div class="input-group input-group-sm">
			<input type="text" disabled class="form-control"  name="perusahaan" value="{{$data->perusahaan}}" placeholder="Ketik disini....">
		</div>
	</div>
</div>



<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Nilai Pengajuan & Cicilan</label>
	<div class="col-lg-3">
		<div class="input-group input-group-sm">
			<div class="input-group-prepend"><span class="input-group-text">Rp.</span></div>
			<input type="text" disabled class="form-control" onkeyup="ketik_nilai(this.value)" name="nominal" id="nominal" value="{{$data->nominal}}" placeholder="Ketik disini...." style="text-align: right;">
		</div>
	</div>
	<div class="col-lg-2">
		<div class="input-group input-group-sm">
			<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
			<input type="text" disabled class="form-control"  name="waktu" id="waktu" value="{{$data->waktu}}" placeholder="Ketik disini...." style="text-align: right;">
		</div>
	</div>
	<div class="col-lg-3">
		<div class="input-group input-group-sm">
			<div class="input-group-prepend"><span class="input-group-text">Rp.</span></div>
			<input type="text" disabled class="form-control" name="angsuran" id="angsuran" value="{{$data->angsuran}}" placeholder="Ketik disini...." style="text-align: right;">
		</div>
	</div>
	
</div>
<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Cicilan Ke</label>
	<div class="col-lg-2">
		<div class="input-group input-group-sm">
			<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
			<input type="number" class="form-control" onkeyup="tentukan_nilai(this.value)"  id="angsuran_masuk" name="angsuran_masuk"  value="{{($data->angsuran_masuk+1)}}" placeholder="Ketik disini...." style="text-align: right;">
		</div>
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<table class="table table-bordered m-b-0">
			<thead>
				<tr>
					<th width="5%">No</th>
					<th>Angsuran Ke</th>
					<th>Bulan</th>
					<th>Tahun</th>
					<th>waktu</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($get as $no=>$o)
				<tr>
					<td>{{$no+1}}</td>
					<td>Ansuran Ke {{$o->angsuran_ke}}</td>
					<td>{{bulan($o->bulan)}}</td>
					<td>{{$o->tahun}}</td>
					<td>{{$o->created_at}}</td>
					@if($o->angsuran_ke==$data->angsuran_masuk)
						<td><span class="btn btn-danger btn-xs" onclick="hapus_cicilan({{$o->id}},{{$data->id}})"><i class="fas fa-window-close"></i></span></td>
					@else
						<td><span class="btn btn-default btn-xs"><i class="fas fa-window-close"></i></span></td>
					@endif
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	
</div>

<script>

	$("#notif_cek").hide();
	$("#nominal") .inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
	$("#angsuran") .inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
	$("#waktu") .inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
	$("#harga_jual").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
	$(".default-select2").select2();
	$('#tgl_pengajuan').datepicker({
		autoclose: true,
		format:'yyyy-mm-dd'
	});
	function tentukan_nilai(waktu){
		var tenor="{{$data->angsuran_masuk}}";
		var max="{{$data->waktu}}";
		var angsuran_masuk=parseInt(tenor)+1;
		if(tenor>=waktu || waktu>max){
			alert('Error penginputan tenor')
			$('#angsuran_masuk').val(angsuran_masuk)
		}
	}
	function ketik_nilai(nilai){
		$('#waktu').val(0);
		$('#angsuran').val(0);
		
	}
	function show_qr(text){
		$.ajax({
			type: 'GET',
			url: "{{url('barang/cari_qr')}}",
			data: "kode_qr="+text,
			success: function(msg){
				var bat=msg.split('@');
                if(bat[1]>0){
					$('#kode_qr').val("");
					$("#notif_cek").show();
				}else{

				}
				
			}
		});
		
	}
	function showPreview(event){
		if(event.target.files.length > 0){
			var src = URL.createObjectURL(event.target.files[0]);
			var preview = document.getElementById("file-ip-1-preview");
			preview.src = src;
			preview.style.display = "block";
		}
	}

	
</script>
