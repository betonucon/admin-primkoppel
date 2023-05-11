<input type="hidden" name="id" value="{{$id}}">
<div class="form-group row">
	<label class="col-lg-12 head-form">
		<span class="fa-stack fa-1x text-primary">
			<i class="far fa-square fa-stack-2x"></i>
			<i class="fas fa-pencil-alt fa-stack-1x"></i>
		</span> 
		Form User Akses
	</label>
	
</div>

<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Username </label>
	<div class="col-lg-4">
		<div class="input-group input-group-sm">
			<input type="text" class="form-control" {{$disabled}}  name="username" value="{{$data->username}}" placeholder="Ketik disini....">
		</div>
	</div>
</div>
<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Nama </label>
	<div class="col-lg-9">
		<div class="input-group input-group-sm">
			<input type="text" class="form-control"  name="name" value="{{$data->name}}" placeholder="Ketik disini....">
		</div>
	</div>
</div>

<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Email </label>
	<div class="col-lg-8">
		<div class="input-group input-group-sm">
			<input type="text" class="form-control" {{$disabled}} name="email" value="{{$data->email}}" placeholder="Ketik disini....">
		</div>
	</div>
</div>
<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Group </label>
	<div class="col-lg-6">
		<div class="input-group input-group-sm">
			<select class="default-select2 form-control form-control-sm"  name="group">
				<option value="">Pilih---</option>
				@foreach(get_group() as $no=>$o)
					<option value="{{$o->id}}" @if($data->group==$o->id) selected @endif >{{$o->group_name}}</option>
				@endforeach
			</select>
		</div>
	</div>
</div>
<div class="form-group row">
	<label class="col-lg-3 col-form-label text-right">Password </label>
	<div class="col-lg-6">
		<div class="input-group input-group-sm">
			<input type="password" class="form-control"  name="password" value="{{$data->password}}" placeholder="Ketik disini....">
		</div>
	</div>
</div>

<script>

	$("#notif_cek").hide();
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
