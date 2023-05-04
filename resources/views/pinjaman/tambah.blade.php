<input type="hidden" name="id" value="{{$id}}">
<div class="form-group row">
	<label class="col-lg-12 head-form">
		<span class="fa-stack fa-1x text-primary">
			<i class="far fa-square fa-stack-2x"></i>
			<i class="fas fa-pencil-alt fa-stack-1x"></i>
		</span> 
		Form Pengajuan Pinjaman
	</label>
	
</div>
@if($id==0)
	<div class="form-group row">
		<label class="col-lg-3 col-form-label text-right">Pilih Anggota </label>
		<div class="col-lg-7">
			<div class="input-group input-group-sm">
				<select class="default-select2 form-control form-control-sm"  name="no_register">
					<option value="">Pilih---</option>
					@foreach($get as $no=>$o)
						<option value="{{$o->no_register}}" >{{$o->name}} ({{$o->perusahaan}})</option>
					@endforeach
				</select>
			</div>
		</div>
	</div>

@else
	<div class="form-group row">
		<label class="col-lg-3 col-form-label text-right">Pilih Anggota </label>
		<div class="col-lg-7">
			<div class="input-group input-group-sm">
				<input type="text" class="form-control" style="text-transform:uppercase" name="nama" value="{{$data->nama}}" placeholder="Ketik disini....">
			</div>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label text-right">Perusahaan </label>
		<div class="col-lg-9">
			<div class="input-group input-group-sm">
				<input type="text" class="form-control"  name="perusahaan" value="{{$data->perusahaan}}" placeholder="Ketik disini....">
			</div>
		</div>
	</div>
@endif


<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Nilai Pengajuan</label>
	<div class="col-lg-4">
		<div class="input-group input-group-sm">
			<div class="input-group-prepend"><span class="input-group-text">Rp.</span></div>
			<input type="text" class="form-control" onkeyup="ketik_nilai(this.value)" name="nominal" id="nominal" value="" placeholder="Ketik disini...." style="text-align: right;">
		</div>
	</div>
	
</div>
<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Tenor & Cicilan</label>
	<div class="col-lg-2">
		<div class="input-group input-group-sm">
			<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
			<input type="text" class="form-control" onkeyup="tentukan_nilai(this.value)" name="waktu" id="waktu" value="" placeholder="Ketik disini...." style="text-align: right;">
		</div>
	</div>
	<div class="col-lg-4">
		<div class="input-group input-group-sm">
			<div class="input-group-prepend"><span class="input-group-text">Rp.</span></div>
			<input type="text" readonly class="form-control" name="angsuran" id="angsuran" value="" placeholder="Ketik disini...." style="text-align: right;">
		</div>
	</div>
	
</div>
<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Tanggal Pengajuan </label>
	<div class="col-lg-3">
		<div class="input-group input-group-sm">
			<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
			<input type="text" class="form-control"  name="tgl_pengajuan" id="tgl_pengajuan" value="" placeholder="Ketik disini...." style="text-align: right;">
		</div>
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
		var nominal=$('#nominal').val();
		var nil = nominal.replace(/,/g, "");
		if(nil=="" || nil==0){
			alert('Masukan nilai pengajuan');
			$('#angsuran').val(0);
		}else{
			var hasil=(nil/waktu)+((nil*2)/100);
			$('#angsuran').val(hasil);
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
