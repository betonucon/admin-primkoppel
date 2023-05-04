@extends('layouts.auth')

@section('app')	
			<div class="right-content">
				<!-- begin register-header -->
				<h1 class="register-header">
					Sign Up
					<small>Create your Color Admin Account. It’s free and always will be.</small>
				</h1>
				<!-- end register-header -->
				<!-- begin register-content -->
				<div class="register-content">
					<form action="{{url('proseslogin')}}" method="post" class="margin-bottom-0">
						@csrf
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
						
						
						<div class="checkbox checkbox-css m-b-30">
							<div class="checkbox checkbox-css m-b-30">
								<input type="checkbox" id="agreement_checkbox" value="">
								<label for="agreement_checkbox">
								By clicking Sign Up, you agree to our <a href="javascript:;">Terms</a> and that you have read our <a href="javascript:;">Data Policy</a>, including our <a href="javascript:;">Cookie Use</a>.
								</label>
							</div>
						</div>
						<div class="register-buttons">
							<button type="submit" class="btn btn-primary btn-block btn-lg">Sign Up</button>
						</div>
						<div class="m-t-30 m-b-30 p-b-30">
							Already a member? Click <a href="login_v3.html">here</a> to login.
						</div>
						<hr />
						<p class="text-center mb-0">
							&copy; Color Admin All Right Reserved 2020
						</p>
					</form>
				</div>
				<!-- end register-content -->
			</div>
@endsection