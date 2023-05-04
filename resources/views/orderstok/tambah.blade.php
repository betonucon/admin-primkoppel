<input type="hidden" name="id" value="{{$id}}">
<div class="form-group row">
	<label class="col-lg-12 head-form">
		<span class="fa-stack fa-1x text-primary">
			<i class="far fa-square fa-stack-2x"></i>
			<i class="fas fa-pencil-alt fa-stack-1x"></i>
		</span> 
		Form Pembelian Stok
	</label>
	
</div>

<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Distributor</label>
	<div class="col-lg-9">
		<div class="input-group input-group-sm">
			<input type="text" class="form-control" name="distributor" value="{{$data->distributor}}" placeholder="Ketik disini....">
		</div>
	</div>
</div>
<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Tanggal Order </label>
	<div class="col-lg-5">
		<div class="input-group input-group-sm">
			<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
			<input type="text" class="form-control"  name="tgl_order" id="tgl_order" value="" placeholder="Ketik disini...." style="text-align: right;">
		</div>
	</div>
</div>
<script>

	$("#notif_cek").hide();
	$('#tgl_order').datepicker({
		autoclose: true,
		format:'yyyy-mm-dd'
	});
	$("#harga_modal").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
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
