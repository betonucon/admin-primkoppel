@extends('layouts.web')
@push('style')
	
@endpush
@section('contex')
   

	<div id="content" class="content">
		<div class="profile">
			<div class="profile-header">
				<div class="profile-header-cover"></div>
				<div class="profile-header-content">
					<div class="profile-header-img">
						<img src="{{url('img/kopkar.png')}}" alt="">
					</div>
					<div class="profile-header-info">
						<h4 class="mt-0 mb-1">{{name_app()}}</h4>
						<p class="mb-2">SALDO WAJIB : Rp.{{uang(saldo_wajib_all())}}</p>
						<p class="mb-2">SALDO SUKARELA : Rp.{{uang(saldo_sukarela_all())}}</p>
						<p class="mb-2">SALDO POKOK : Rp.{{uang(saldo_pokok_all())}}</p>
						
						<!-- <a href="#" class="btn btn-xs btn-yellow">Edit Profile</a> -->
					</div>
				</div>
				
			</div>
		</div>  
	</div>
	<div id="content" class="content">
			
			<div class="row">
				
				
				
			</div>
			

		</div>
	
	
@endsection
@push('ajax')

@endpush
