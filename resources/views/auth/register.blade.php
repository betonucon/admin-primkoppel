@extends('layouts.auth')

@section('app')	
			<div class="right-content">
				<!-- begin register-header -->
				<h2 class="register-header" style="text-align:center">
					<img src="{{url('img/kopkar.png')}}" width="12%">&nbsp;KOP MITRA SEJAHTERA
					<small>PT Krakatau Information Technology</small>
				</h2>
				<!-- end register-header -->
				<!-- begin register-content -->
				<div class="register-content">
					
                    <form action="{{url('prosesregister')}}" method="post" class="margin-bottom-0">
						@csrf
						<label class="control-label">Name </label>
						<div class="row row-space-10">
							<div class="col-md-12 m-b-15">
								<input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="First name" required />
								@if ($errors->has('name'))<span class="text-danger">{{ $errors->first('name') }}</span>@endif
							</div>
							
						</div>
						<label class="control-label">Email <span class="text-danger">*</span></label>
						<div class="row m-b-15">
							<div class="col-md-12">
								<input type="text" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email address" required />
								@if ($errors->has('email'))<span class="text-danger">{{ $errors->first('email') }}</span>@endif
							</div>
						</div>
						<label class="control-label">Password <span class="text-danger">*</span></label>
						<div class="row m-b-15">
							<div class="col-md-12">
								<input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required />
								@if ($errors->has('password'))<span class="text-danger">{{ $errors->first('password') }}</span>@endif
							</div>
						</div>
						<label class="control-label">Re-enter Password <span class="text-danger">*</span></label>
						<div class="row m-b-15">
							<div class="col-md-12">
								<input type="password" name="password_confirmation" class="form-control" placeholder="Password" required />
							</div>
						</div>
						
						<div class="checkbox checkbox-css m-b-30">
							<div class="checkbox checkbox-css m-b-30">
								
							</div>
						</div>
						<div class="register-buttons">
							<button type="submit" class="btn btn-primary btn-block btn-lg">Daftar</button>
						</div>
						<div class="m-t-30 m-b-30 p-b-30">
							Sudah punya akun? Klik <a href="{{url('login')}}">disini</a> untuk login.
						</div>
						<hr />
						<p class="text-center mb-0">
                            &copy; Koperasi Mitra Sejahtera 2021
						</p>
					</form>


				</div>
				<!-- end register-content -->
			</div>
@endsection