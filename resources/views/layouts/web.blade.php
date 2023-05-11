<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>{{name_app()}}</title>
	<link rel="icon" href="{{url('public/img/kopkar.png')}}">
	<link rel="icon" href="https://www.krakatausteel.com/public/images/fav.png">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="{{url('public/assets/assets/css/default/app.min.css')}}" rel="stylesheet" />
	<!-- <link href="{{url('public/assets/assets/css/transparent/app.min.css')}}" rel="stylesheet"> -->
	<!-- ================== END BASE CSS STYLE ================== -->
    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
	<link href="{{url('public/assets/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
	<link href="{{url('public/assets/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" />
	<link href="{{url('public/assets/assets/plugins/ion-rangeslider/css/ion.rangeSlider.min.css')}}" rel="stylesheet" />
	<link href="{{url('public/assets/assets/plugins/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}" rel="stylesheet" />
	<link href="{{url('public/assets/assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" />
	<link href="{{url('public/assets/assets/plugins/@danielfarrell/bootstrap-combobox/css/bootstrap-combobox.css')}}" rel="stylesheet" />
	<link href="{{url('public/assets/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
	<link href="{{url('public/assets/assets/plugins/tag-it/css/jquery.tagit.css')}}" rel="stylesheet" />
	<link href="{{url('public/assets/assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
	<link href="{{url('public/assets/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
	<link href="{{url('public/assets/assets/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" />
	<link href="{{url('public/assets/assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css')}}" rel="stylesheet" />
	<link href="{{url('public/assets/assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.css')}}" rel="stylesheet" />
	<link href="{{url('public/assets/assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-fontawesome.css')}}" rel="stylesheet" />
	<link href="{{url('public/assets/assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-glyphicons.css')}}" rel="stylesheet" />
	<!-- ================== END PAGE LEVEL STYLE ================== -->
	<link href="{{url('public/assets/assets/plugins/jstree/dist/themes/default/style.min.css')}}" rel="stylesheet" />
	<link href="{{url('public/assets/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
	<link href="{{url('public/assets/assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
	<link href="{{url('public/assets/assets/plugins/datatables.net-fixedheader-bs4/css/fixedheader.bootstrap4.min.css')}}" rel="stylesheet" />
	<link href="{{url('public/assets/assets/plugins/smartwizard/dist/css/smart_wizard.css')}}" rel="stylesheet" />
	<link href="{{url('public/assets/assets/plugins/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.min.css')}}" rel="stylesheet" />
	@stack('style')
	<style>
		.modal .modal-header {
			background: #6b56e1;
			color: #fff;
		}
		.table td{
			padding: 2px 3px !important;
			vertical-align: top;
			border-top: 1px solid #e4e7ea;
		}
		.panel.panel-inverse>.panel-heading {
			background: #7e878f;
			color: #fff;
		}
		.viewqr{
			width:100%;
			background:#e7e7fb;
			padding:1%;
		}
		.form-group {
			margin-bottom: 0.5rem;
		}
		.dropup .dropdown-menu {
			left: 30px !important;
		}
		#modal-notifikasi{
			background:#252528a6;
		}
		.head-form{
			text-align: left;
			text-transform: uppercase;
			font-size: 15px;
			border-bottom: dotted 3px #eaeaf3;
			color: #1a1a7e;
		}
		.form-horizontal.form-bordered .form-group>div {
			padding: 6px;
		}
        .swal-text {
            width: 100%;
            color: #000;
        }
		.form-horizontal.form-bordered .form-group .col-form-label {
    		padding: 1px 15px;
			vertical-align:top;
		}
		th{
			background:#ededef;
			padding: 7px 3px !important;
			color:#000;
		}
		.loadnya {
			height: 100%;
			width: 0;
			position: fixed;
			z-index: 1070;
			top: 0;
			left: 0;
			background-color: rgb(0,0,0);
			background-color: rgb(0 0 0 / 55%);
			overflow-x: hidden;
			transition: transform .9s;
		}

		.loadnya-content {
			position: relative;
			top: 25%;
			width: 100%;
			text-align: center;
			margin-top: 30px;
			color:#fff;
			font-size:20px;
		}
		#notifikasi{
			width: 0%;
			background: #f3cbcb;
			color: #fff;
		}
		#notifikasiubah{
			width: 0%;
			background: #f3cbcb;
			color: #fff;
		}
		@media (min-width: 610px){
			.header .navbar-header {
				width: 22% !important;
			}
		}
		@media only screen and (min-width: 600px) {
			#modal-sedeng{
				max-width:75%;
				margin-top:0px
			}
			
			.header .navbar-header {
				width: 22%;
				
			}
			.formnya{
				display:flex;
			}
			label {
				display: inline-block;
				margin-bottom: .5rem;
				font-weight:bold;
			}
		}
		.header .navbar-brand .navbar-logo {
			margin-right: 10px;
			background: none;
			border: 10px solid #ffffff00;
			position: relative;
			overflow: hidden;
			-webkit-border-radius: 4px;
			border-radius: 4px;
		}
		@media (min-width: 610px){
			
			
			#web-app{
				align-items: center;
    			justify-content: center;
			}
			.col-lg-1 {
				flex: 0 0 8.33333%;
				max-width: 9.33333%;
			}
			.header .navbar-header {
				width: 370px;
				
			}
			.footer-mobile {
				display:none;
			}
			
		}
		
		
	
	</style>
</head>
<body style="font-family: unset;">
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade show">
		<span class="spinner"></span>
	</div>
	<!-- end #page-loader -->
	<div id="loadnya" class="loadnya">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <div class="loadnya-content">
			<img src="{{url_plug()}}/img/loadingok.gif" width="30%">
        </div>
	</div> 
	<!-- begin #page-container -->
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<!-- begin #header -->
		<div id="header" class="header navbar-default">
			<!-- begin navbar-header -->
			<div class="navbar-header">
				<a href="{{url('public//')}}" class="navbar-brand"><span class="navbar-logo"><b>PRIMKOPPEL STORE</b></a>
				<button type="button" class="navbar-toggle" data-click="top-menu-toggled">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<!-- end navbar-header --><!-- begin header-nav -->
			<ul class="navbar-nav navbar-right">
				
				<!-- <li class="dropdown">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle f-s-14">
						<i class="fa fa-bell"></i>
						<span class="label">5</span>
					</a>
					<div class="dropdown-menu media-list dropdown-menu-right">
						<div class="dropdown-header">NOTIFICATIONS (5)</div>
						<a href="javascript:;" class="dropdown-item media">
							<div class="media-left">
								<i class="fa fa-bug media-object bg-silver-darker"></i>
							</div>
							<div class="media-body">
								<h6 class="media-heading">Server Error Reports <i class="fa fa-exclamation-circle text-danger"></i></h6>
								<div class="text-muted f-s-10">3 minutes ago</div>
							</div>
						</a>
						<a href="javascript:;" class="dropdown-item media">
							<div class="media-left">
								<img src="assets/assets/img/user/user-1.jpg" class="media-object" alt="" />
								<i class="fab fa-facebook-messenger text-blue media-object-icon"></i>
							</div>
							<div class="media-body">
								<h6 class="media-heading">John Smith</h6>
								<p>Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>
								<div class="text-muted f-s-10">25 minutes ago</div>
							</div>
						</a>
						<a href="javascript:;" class="dropdown-item media">
							<div class="media-left">
								<img src="assets/assets/img/user/user-2.jpg" class="media-object" alt="" />
								<i class="fab fa-facebook-messenger text-blue media-object-icon"></i>
							</div>
							<div class="media-body">
								<h6 class="media-heading">Olivia</h6>
								<p>Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>
								<div class="text-muted f-s-10">35 minutes ago</div>
							</div>
						</a>
						<a href="javascript:;" class="dropdown-item media">
							<div class="media-left">
								<i class="fa fa-plus media-object bg-silver-darker"></i>
							</div>
							<div class="media-body">
								<h6 class="media-heading"> New User Registered</h6>
								<div class="text-muted f-s-10">1 hour ago</div>
							</div>
						</a>
						<a href="javascript:;" class="dropdown-item media">
							<div class="media-left">
								<i class="fa fa-envelope media-object bg-silver-darker"></i>
								<i class="fab fa-google text-warning media-object-icon f-s-14"></i>
							</div>
							<div class="media-body">
								<h6 class="media-heading"> New Email From John</h6>
								<div class="text-muted f-s-10">2 hour ago</div>
							</div>
						</a>
						<div class="dropdown-footer text-center">
							<a href="javascript:;">View more</a>
						</div>
					</div>
				</li> -->
				<li class="dropdown navbar-user">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img src="{{url('public/img/kopkar.png')}}" width="100%">
						<span class="d-none d-md-inline">{{Auth::user()->name}}</span> <b class="caret"></b>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<!-- <a href="javascript:;" class="dropdown-item">Edit Profile</a> -->
						<div class="dropdown-divider"></div>
						<a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Log Out</a>
						
						<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
							@csrf
						</form>
					</div>
				</li>
			</ul>
			<!-- end header-nav -->
		</div>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<div id="sidebar" class="sidebar">
			<!-- begin sidebar scrollbar -->
			<div data-scrollbar="true" data-height="100%">
				<!-- begin sidebar user -->
				<ul class="nav">
					<li class="nav-profile">
						<a href="javascript:;">
							<div class="cover with-shadow"></div>
							<div class="image">
								<img src="{{url('public/img/user.png')}}" alt="" /> 
							</div>
							<div class="info" style="font-size:11px">
								{{Auth::user()->name}}
								<small>{{Auth::user()->role['name']}}</small>
							</div>
						</a>
					</li>
					<li>
						<ul class="nav nav-profile">
							<li><a href="javascript:;"><i class="fa fa-cog"></i> Settings</a></li>
							<li><a href="javascript:;"><i class="fa fa-pencil-alt"></i> Send Feedback</a></li>
							<li><a href="javascript:;"><i class="fa fa-question-circle"></i> Helps</a></li>
						</ul>
					</li>
				</ul>
				<!-- end sidebar user -->
				<!-- begin sidebar nav -->
				@include('layouts.side')
				<!-- end sidebar nav -->
			</div>
			<!-- end sidebar scrollbar -->
		</div>
		<div class="sidebar-bg"></div>
		<!-- end #sidebar -->
		
		
			@yield('contex')
			
		
		
		
		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->
	
	<script src="{{url('public/assets/assets/js/app.min.js')}}"></script>
	<!-- <script src="{{url('public/assets/assets/js/theme/default.min.js')}}"></script> -->
	<script src="{{url('public/assets/assets/js/theme/transparent.min.js')}}"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="{{url('public/assets/assets/plugins/jquery-migrate/dist/jquery-migrate.min.js')}}"></script>
	<script src="{{url('public/assets/assets/plugins/moment/min/moment.min.js')}}"></script>
	<script src="{{url('public/assets/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
	<script src="{{url('public/assets/assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
	<script src="{{url('public/assets/assets/plugins/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
	<script src="{{url('public/assets/assets/plugins/jquery.maskedinput/src/jquery.maskedinput.js')}}"></script>
	<script src="{{url('public/assets/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
	<script src="{{url('public/assets/assets/plugins/pwstrength-bootstrap/dist/pwstrength-bootstrap.min.js')}}"></script>
	<script src="{{url('public/assets/assets/plugins/@danielfarrell/bootstrap-combobox/js/bootstrap-combobox.js')}}"></script>
	<script src="{{url('public/assets/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
	<script src="{{url('public/assets/assets/plugins/tag-it/js/tag-it.min.js')}}"></script>
	<script src="{{url('public/assets/assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
	<script src="{{url('public/assets/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
	<script src="{{url('public/assets/assets/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
	<script src="{{url('public/assets/assets/plugins/bootstrap-show-password/dist/bootstrap-show-password.js')}}"></script>
	<script src="{{url('public/assets/assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js')}}"></script>
	<script src="{{url('public/assets/assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.js')}}"></script>
	<script src="{{url('public/assets/assets/plugins/clipboard/dist/clipboard.min.js')}}"></script>
	<script src="{{url('public/assets/assets/js/demo/form-plugins.demo.js')}}"></script>
	<script src="{{url('public/assets/assets/plugins/datatables.net/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{url('public/assets/assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
	<script src="{{url('public/assets/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
	<script src="{{url('public/assets/assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
	<script src="{{url('public/assets/assets/js/demo/table-manage-responsive.demo.js')}}"></script>
	<script src="{{url('public/assets/assets/plugins/chart.js/dist/Chart.min.js')}}"></script>
	<script src="{{url('public/assets/assets/plugins/jstree/dist/jstree.min.js')}}"></script>
	<script src="{{url('public/assets/assets/js/demo/ui-tree.demo.js')}}"></script>
	<script src="{{url('public/assets/assets/plugins/sweetalert/dist/sweetalert.min.js')}}"></script>
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="{{url('public/assets/assets/plugins/datatables.net-fixedheader/js/dataTables.fixedheader.min.js')}}"></script>
	<script src="{{url('public/assets/assets/plugins/datatables.net-fixedheader-bs4/js/fixedheader.bootstrap4.min.js')}}"></script>
	@stack('ajax')
	<script type='text/javascript' src="{{url_plug()}}/js/jquery.inputmask.bundle.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	<script>
		
		

		$('#modal-notifikasi').hide();
		function tutup(){
			$('#modal-notifikasi').hide();
		}
		function hanyaAngka(evt) {
		  var charCode = (evt.which) ? evt.which : event.keyCode
		   if (charCode > 31 && (charCode < 48 || charCode > 57))
 
		    return false;
		  return true;
		}
	</script>
</body>
</html>