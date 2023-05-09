<input type="hidden" name="id" value="{{$id}}">
<div class="form-group row">
	<label class="col-lg-12 head-form">
		<span class="fa-stack fa-1x text-primary">
			<i class="far fa-square fa-stack-2x"></i>
			<i class="fas fa-pencil-alt fa-stack-1x"></i>
		</span> 
		Form Barang
	</label>
	
</div>
<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">QR Code</label>
	<div class="col-lg-4">
		<div class="input-group input-group-sm">
			<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-qrcode"></i></span></div>
			<input type="text" value="{{$data->kode_qr}}" class="form-control" name="kode_qr" id="kode_qr"  onkeyup="show_qr(this.value)" placeholder="Ketik disini....">
			
		</div>
		<small class="f-s-12 text-red" id="notif_cek">QR Sudah Terdaftar</small>
	</div>
</div>
<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Nama Barang</label>
	<div class="col-lg-9">
		<div class="input-group input-group-sm">
			<input type="text" class="form-control" name="nama_barang" value="{{$data->nama_barang}}" placeholder="Ketik disini....">
		</div>
	</div>
</div>
<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Deskripsi Barang</label>
	<div class="col-lg-9">
		<div class="input-group input-group-sm">
			<textarea class="form-control" name="deskripsi" value="" placeholder="Ketik disini...." rows="4">{{$data->deskripsi}}</textarea>
		</div>
	</div>
</div>
<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Harga Modal & Jual</label>
	<div class="col-lg-3">
		<div class="input-group input-group-sm">
			<div class="input-group-prepend"><span class="input-group-text">Rp.</span></div>
			<input type="text" class="form-control" name="harga_modal" id="harga_modal" value="{{$data->harga_modal}}" placeholder="Ketik disini....">
		</div>
	</div>
	<div class="col-lg-3">
		<div class="input-group input-group-sm">
			<div class="input-group-prepend"><span class="input-group-text">Rp.</span></div>
			<input type="text" class="form-control" name="harga_jual" id="harga_jual" value="{{$data->harga_jual}}" placeholder="Ketik disini....">
		</div>
	</div>
</div>
<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Diskon Anggota & Member</label>
	<div class="col-lg-3">
		<div class="input-group input-group-sm">
			<div class="input-group-prepend"><span class="input-group-text">%</span></div>
			<input type="text" class="form-control" name="diskon_anggota" id="diskon_anggota" value="{{$data->diskon_anggota}}" placeholder="Ketik disini....">
		</div>
	</div>
	<div class="col-lg-3">
		<div class="input-group input-group-sm">
			<div class="input-group-prepend"><span class="input-group-text">%</span></div>
			<input type="text" class="form-control" name="diskon" id="diskon" value="{{$data->diskon}}" placeholder="Ketik disini....">
		</div>
	</div>
</div>
<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Satuan & Kategori</label>
	<div class="col-lg-3">
		<div class="input-group input-group-sm">
			<select class="form-control form-control-sm"  name="satuan">
				<option value="">Pilih Satuan---</option>
				@foreach(get_satuan() as $no=>$sat)
					<option value="{{$sat->satuan}}" @if($sat->satuan==$data->satuan) selected @endif >{{$no+1}}.{{$sat->satuan}}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="input-group input-group-sm">
			<select class="form-control form-control-sm"  name="kategori_barang_id">
				<option value="">Pilih Kategori---</option>
				@foreach(get_kategori_barang() as $no=>$sat)
					<option value="{{$sat->id}}" @if($sat->id==$data->kategori_barang_id) selected @endif >{{$no+1}}.{{$sat->kategori_barang}}</option>
				@endforeach
			</select>
		</div>
	</div>
</div>

<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Icon Gambar</label>
	<div class="col-lg-4">
		<div class="input-group input-group-sm">
			<input type="file" class="form-control" name="file" value="{{$data->file}}" id="file-ip-1" accept="image/*" onchange="showPreview(event);" placeholder="Ketik disini....">
		
		</div>
	</div>
	
</div>
<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">&nbsp;</label>
	<div class="col-lg-2" style="background: #bebed5; margin-left: 1.5%; margin-top: 0px; min-height: 80px;">
		<div class="preview" >
			@if($id>0)
			<img id="file-ip-1-preview" src="{{url('public/_icon/')}}/{{$data->file}}"style="width:100%">
			@else
			<img id="file-ip-1-preview" style="width:100%">
			@endif
			
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
