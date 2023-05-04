<input type="hidden" name="id" value="{{$id}}">
<div class="form-group row">
	<label class="col-lg-12 head-form">
		<span class="fa-stack fa-1x text-primary">
			<i class="far fa-square fa-stack-2x"></i>
			<i class="fas fa-pencil-alt fa-stack-1x"></i>
		</span> 
		Form Simpanan Sukarela
	</label>
	
</div>

<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Nama </label>
	<div class="col-lg-7">
		<div class="input-group input-group-sm">
			<select class="form-control form-control-sm" id="default-select2" name="no_register">
				<option value="">Pilih---</option>
				@foreach($data as $no=>$sat)
					<option value="{{$sat->no_register}}" >{{$sat->name}}  ({{$sat->perusahaan}})</option>
				@endforeach
			</select>
		</div>
	</div>
</div>
<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Nominal</label>
	<div class="col-lg-5">
		<div class="input-group input-group-sm">
			<div class="input-group-prepend"><span class="input-group-text">Rp.</span></div>
			<input type="text" class="form-control" name="nominal" id="nominal" placeholder="Ketik disini....">
		</div>
	</div>
	
</div>

<script>

	$("#notif_cek").hide();
	$('#default-select2').select2();
	$("#nominal").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
	$("#harga_jual").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
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
