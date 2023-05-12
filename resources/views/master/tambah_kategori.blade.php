<input type="hidden" name="id" value="{{$id}}">
<div class="form-group row">
	<label class="col-lg-12 head-form">
		<span class="fa-stack fa-1x text-primary">
			<i class="far fa-square fa-stack-2x"></i>
			<i class="fas fa-pencil-alt fa-stack-1x"></i>
		</span> 
		Form Kategori Barang
	</label>
	
</div>
<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Kategori Barang</label>
	<div class="col-lg-9">
		<div class="input-group input-group-sm">
			<input type="text" class="form-control" name="kategori_barang" value="{{$data->kategori_barang}}" placeholder="Ketik disini....">
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
