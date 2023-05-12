<input type="hidden" name="id" value="{{$id}}">
<div class="form-group row">
	<label class="col-lg-12 head-form">
		<span class="fa-stack fa-1x text-primary">
			<i class="far fa-square fa-stack-2x"></i>
			<i class="fas fa-pencil-alt fa-stack-1x"></i>
		</span> 
		Form Pembayaran
	</label>
	
</div>

<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">No Order</label>
	<div class="col-lg-5">
		<div class="input-group input-group-sm">
			<input type="text" disabled class="form-control" name="no_order" value="{{$data->no_order}}" placeholder="Ketik disini....">
		</div>
	</div>
</div>
<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Konsumen</label>
	<div class="col-lg-9">
		<div class="input-group input-group-sm">
			<input type="text" disabled class="form-control" name="konsumen" value="{{$data->konsumen}}" placeholder="Ketik disini....">
		</div>
	</div>
</div>
<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Total</label>
	<div class="col-lg-5">
		<div class="input-group input-group-sm">
			<input type="text" disabled class="form-control" name="total_harga" id="total_harga" value="{{$data->total_harga}}" placeholder="Ketik disini....">
		</div>
	</div>
</div>
<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Metode Bayar </label>
	<div class="col-lg-5">
		<div class="input-group input-group-sm">
			<select class="form-control form-control-sm" id="default-select2" name="akses_bayar_id">
				<option value="">Pilih---</option>
				@foreach(get_akses_bayar($data->kategori) as $no=>$sat)
					<option value="{{$sat->id}}" >{{$no+1}}. {{$sat->akses_bayar}}</option>
				@endforeach
			</select>
		</div>
	</div>
</div>

<script>

	$("#notif_cek").hide();
	$('#tgl_order').datepicker({
		autoclose: true,
		format:'yyyy-mm-dd'
	});
	$("#total_harga").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
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
