@extends('layouts.web')
@push('style')
	<link href="{{url('assets/assets/plugins/nvd3/build/nv.d3.css')}}" rel="stylesheet" />
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
<script src="{{url('assets/assets/plugins/chart.js/dist/Chart.min.js')}}"></script>
<script>
    $("#ClickMe").attr("disabled", "disabled"); 

	/*
	Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
	Version: 4.6.0
	Author: Sean Ngu
	Website: http://www.seantheme.com/color-admin/admin/
	*/

	Chart.defaults.global.defaultFontColor = COLOR_DARK;
	Chart.defaults.global.defaultFontFamily = FONT_FAMILY;
	Chart.defaults.global.defaultFontStyle = FONT_WEIGHT;

	var randomScalingFactor = function() { 
		return Math.round(Math.random()*100)
	};

	
	var barChartData = {
		labels: [
			@for($x=1;$x<13;$x++)
				'{{bulan(ubah_bulan($x))}}',
			@endfor
		],
		datasets: [{
			label: 'Masuk',
			borderWidth: 2,
			borderColor: COLOR_INDIGO,
			backgroundColor:"blue",
			data: [
				@for($x=1;$x<13;$x++)
					{{sum_transaksi($tahun,ubah_bulan($x),1)}},
				@endfor
			]
		}, {
			label: 'Keluar',
			borderWidth: 2,
			borderColor: COLOR_DARK,
			backgroundColor: "red",
			data: [
				@for($x=1;$x<13;$x++)
					{{sum_transaksi($tahun,ubah_bulan($x),2)}},
				@endfor
			]
		}]
	};

	

	var handleChartJs = function() {
		var ctx2 = document.getElementById('bar-chart').getContext('2d');
		var barChart = new Chart(ctx2, {
			type: 'bar',
			data: barChartData
		});

		
	};

	var ChartJs = function () {
		"use strict";
		return {
			//main function
			init: function () {
				handleChartJs();
			}
		};
	}();

	$(document).ready(function() {
		ChartJs.init();
	});
</script>
@endpush
