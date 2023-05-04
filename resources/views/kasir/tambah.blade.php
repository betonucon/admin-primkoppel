<input type="hidden" name="id" value="{{$id}}">
<style>
	.select2.select2-container {
		display: block;
		width: 100% !important;
	}
</style>
<div class="form-group row">
	<label class="col-lg-12 head-form">
		<span class="fa-stack fa-1x text-primary">
			<i class="far fa-square fa-stack-2x"></i>
			<i class="fas fa-pencil-alt fa-stack-1x"></i>
		</span> 
		Form Kasir
	</label>
	
</div>

<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Kategori</label>
	<div class="col-lg-9">
		<div class="input-group input-group-sm">
			<select class="form-control" name="kategori" onchange="pilih_kategori(this.value)" value="{{$data->kategori}}" placeholder="Ketik disini....">
				<option value="1">Non Anggota</option>
				<option value="2">Anggota</option>
			</select>
		</div>
	</div>
</div>
<div class="form-group row" id="non">
	<label class="col-lg-3 col-form-label text-right">Pembeli</label>
	<div class="col-lg-9">
		<div class="input-group input-group-sm">
			<input type="text" class="form-control" name="konsumen" value="{{$data->konsumen}}" placeholder="Ketik disini....">
		</div>
	</div>
</div>
<div class="form-group row" id="anggota">
	<label class="col-lg-3 col-form-label text-right">Pembeli</label>
	<div class="col-lg-9">
		<div class="input-group input-group-sm">
			<select class="form-control form-control-sm" id="default-select2" name="no_register">
				<option value="">Pilih---</option>
				@foreach(get_anggota() as $no=>$sat)
					<option value="{{$sat->no_register}}" >{{$sat->name}}  ({{$sat->perusahaan}})</option>
				@endforeach
			</select>
		</div>
	</div>
</div>
<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Tanggal</label>
	<div class="col-lg-5">
		<div class="input-group input-group-sm">
			<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
			<input type="text" class="form-control"  name="tgl_order" id="tgl_order" value="{{date('Y-m-d')}}" placeholder="Ketik disini...." style="text-align: right;">
		</div>
	</div>
</div>
<script>

	$("#anggota").hide();
	$('#tgl_order').datepicker({
		autoclose: true,
		format:'yyyy-mm-dd'
	});
	$('#default-select2').select2();
	$("#harga_modal").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
	$("#harga_jual").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
	function pilih_kategori(id){
		if(id==1){
			$("#non").show();
			$("#anggota").hide();
		}else{
			$("#non").hide();
			$("#anggota").show();
		}
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
