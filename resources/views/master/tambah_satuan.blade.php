<input type="hidden" name="id" value="{{$id}}">
<div class="form-group row">
	<label class="col-lg-12 head-form">
		<span class="fa-stack fa-1x text-primary">
			<i class="far fa-square fa-stack-2x"></i>
			<i class="fas fa-pencil-alt fa-stack-1x"></i>
		</span> 
		Form Satuan
	</label>
	
</div>
<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Satuan</label>
	<div class="col-lg-9">
		<div class="input-group input-group-sm">
			<input type="text" class="form-control" name="satuan" value="{{$data->satuan}}" placeholder="Ketik disini....">
		</div>
	</div>
</div>

<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Satuan Tertinggi</label>
	<div class="col-lg-3">
		<div class="input-group input-group-sm">
			<select class="form-control form-control-sm"  name="satuan_pecah">
				<option value="1" @if($data->satuan_pecah==1) selected @endif >Tidak</option>
				<option value="2" @if($data->satuan_pecah==2) selected @endif >Ya</option>
				
			</select>
		</div>
	</div>
	
</div>


<script>

	$("#notif_cek").hide();
	$("#harga_modal").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
	$("#diskon").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
	$("#diskon_anggota").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
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
