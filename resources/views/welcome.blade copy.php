@extends('layouts.web')

@section('isinya')
   
	<!-- <h1 class="page-header">Page with Top Menu</h1> -->
	<div class="row text-center">
				
				@for($x=1;$x<10;$x++)
				<div class="col-lg-2 col-sm-4 col-6">
					<h3 class="text-ellipsis"><i class="icon-music-tone-alt"></i><br><small>{{$x}}-icon-music-tone-alt</small></h3>
				</div>
				@endfor
				<!-- end col-2 -->
				
				
			</div>
	<!-- begin panel -->
	<div class="panel panel-inverse">
		<div class="panel-heading">
			<h4 class="panel-title">Panel Title here</h4>
			<div class="panel-heading-btn">
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
			</div>
		</div>
		<div class="panel-body">
			<div class="col-4" id="list_aplikasi">
				<h3 class="text-ellipsis"><i class="icon-user"></i><br><small>icon-user</small></h3>
			</div>
			<div class="col-4" id="list_aplikasi">
				<h3 class="text-ellipsis"><i class="icon-user"></i><br><small>icon-user</small></h3>
			</div>
			<div class="col-4" id="list_aplikasi">
				<h3 class="text-ellipsis"><i class="icon-user"></i><br><small>icon-user</small></h3>
			</div>
			<div class="col-4" id="list_aplikasi">
				<h3 class="text-ellipsis"><i class="icon-user"></i><br><small>icon-user</small></h3>
			</div>
			<div class="col-4" id="list_aplikasi">
				<h3 class="text-ellipsis"><i class="icon-user"></i><br><small>icon-user</small></h3>
			</div>
			<div class="col-4" id="list_aplikasi">
				<h3 class="text-ellipsis"><i class="icon-user"></i><br><small>icon-user</small></h3>
			</div>
		</div>
	</div>
	<!-- end panel -->
@endsection
