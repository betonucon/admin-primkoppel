<input type="hidden" name="id" value="{{$id}}">
<div class="table-responsive" style="overflow-y:scroll;height: 400px;margin-top:1%">
	<table class="table table-bordered m-b-0">
		<thead>
			<tr>
				<th>No</th>
				<th width="5%"></th>
				<th>NO REGISTER</th>
				<th>NAMA</th>
				<th>PERUSAHAAN</th>
				<th>NILAI</th>
			</tr>
		</thead>
		<tbody>
			@foreach($data as $no=>$o)
				<?php
					if(data_simpanan_wajib($o->no_register,$bulan,$tahun)>0){
						$color="yellow";
					}else{
						$color="#fff";
					}
				?>
				<tr >
					@if(data_simpanan_wajib($o->no_register,$bulan,$tahun)>0)
						<td style="background:{{$color}}"><span class="btn btn-danger btn-xs" onclick="hapus_wajib({{data_simpanan_wajib($o->no_register,$bulan,$tahun)}},`{{$bulan}}`,{{$tahun}})">Hapus</span></td>
						<td style="background:{{$color}}"></td>
					@else
						<td style="background:{{$color}}"><span class="btn btn-primary btn-xs" onclick="proses_wajib(`{{$o->no_register}}`,`{{$bulan}}`,{{$tahun}},`{{$perusahaan}}`)">Proses</span></td>
						<td style="background:{{$color}}"><input type="checkbox" name="no_register[]" value="{{$o->no_register}}"></td>
					@endif
					
					<td style="background:{{$color}}">{{$o->no_register}}</td>
					<td style="background:{{$color}}">{{$o->name}}</td>
					<td style="background:{{$color}}">{{$o->perusahaan}}</td>
					<td style="background:{{$color}}">{{uang(nilai_wajib())}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
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
