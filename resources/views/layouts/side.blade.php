            <ul class="nav">
                <li class="has-sub">
					<a href="{{url('/')}}">
						<i class="fa fa-home"></i>
						<span>Dashboard</span>
					</a>
				</li>
				@if(Auth::user()['role_id']==1)
					<li class="has-sub ">
						<a href="{{url('user')}}">
							<i class="fa fa-users"></i>
							<span>User Akses</span>
						</a>
					</li>
					<li class="has-sub" >
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="fa fa-users"></i>
							<span>Anggota</span> 
						</a>
						<ul class="sub-menu" style="display:@if(Request::is('anggota')==1 || Request::is('anggota/*')==1) block @endif">
							<li><a href="{{url('anggota')}}">Daftar </a></li>
							<!-- <li><a href="{{url('anggota')}}">Keluar</a></li> -->
							
						</ul>
					</li>
					<li class="has-sub">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="fa fa-cog"></i>
							<span>Master</span> 
						</a>
						<ul class="sub-menu" style="display:@if(Request::is('master')==1 || Request::is('master/*')==1) block @endif">
							<li><a href="{{url('master/satuan')}}">Satuan </a></li>
							<li><a href="{{url('master/kategori')}}">Kategori Barang</a></li>
							
						</ul>
					</li>
					<li class="has-sub">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="fa fa-briefcase"></i>
							<span>Barang</span> 
						</a>
						<ul class="sub-menu" style="display:@if((Request::is('barang')==1 || Request::is('barang/*')==1) || (Request::is('orderstok')==1 || Request::is('orderstok/*')==1)) block @endif">
							<li><a href="{{url('barang')}}">Daftar Barang </a></li>
							<li><a href="{{url('orderstok')}}">Order Stok</a></li>
							
						</ul>
					</li>
					<li class="has-sub">
						<a href="{{url('kasir')}}">
							<i class="fa fa-money-bill-alt"></i>
							<span>Kasir</span>
						</a>
					</li>
					<li class="has-sub">
						<a href="{{url('keuangan')}}">
							<i class="fa fa-money-bill-alt"></i>
							<span>Keuangan</span>
						</a>
					</li>
					<li class="has-sub">
						<a href="{{url('simpanan')}}">
							<i class="fa fa-money-bill-alt"></i>
							<span>Simpanan Anggota</span>
						</a>
					</li>
					
					<li class="has-sub">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="fa fa-briefcase"></i>
							<span>Daftar Pinjaman</span> 
						</a>
						<ul class="sub-menu">
							<li><a href="{{url('pinjaman')}}">Pinjaman </a></li>
							<li><a href="{{url('pinjaman/riwayat')}}">Riwayat Pinjaman</a></li>
							
						</ul>
					</li>

				@endif
				@if(Auth::user()['role_id']==3)
					
					<li class="has-sub">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="fa fa-cog"></i>
							<span>Master</span> 
						</a>
						<ul class="sub-menu" style="display:@if(Request::is('master')==1 || Request::is('master/*')==1) block @endif">
							<li><a href="{{url('master/satuan')}}">Satuan </a></li>
							<li><a href="{{url('master/kategori')}}">Kategori Barang</a></li>
							
						</ul>
					</li>
					<li class="has-sub">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="fa fa-briefcase"></i>
							<span>Barang</span> 
						</a>
						<ul class="sub-menu" style="display:@if((Request::is('barang')==1 || Request::is('barang/*')==1) || (Request::is('orderstok')==1 || Request::is('orderstok/*')==1)) block @endif">
							<li><a href="{{url('barang')}}">Daftar Barang </a></li>
							<li><a href="{{url('orderstok')}}">Order Stok</a></li>
							
						</ul>
					</li>
					<li class="has-sub">
						<a href="{{url('kasir')}}">
							<i class="fa fa-money-bill-alt"></i>
							<span>Kasir</span>
						</a>
					</li>
					<li class="has-sub">
						<a href="{{url('keuangan')}}">
							<i class="fa fa-money-bill-alt"></i>
							<span>Keuangan</span>
						</a>
					</li>
					

				@endif
				@if(Auth::user()['role_id']==2)
					<li class="has-sub">
						<a href="{{url('Anggota')}}">
							<i class="fa fa-user"></i>
							<span>Daftar Anggota</span>
						</a>
					</li>
					<li class="has-sub">
						<a href="{{url('Pinjaman')}}">
							{!! notifikasi_pengajuan() !!}
							<i class="fa fa-list"></i>
							<span>Pengajuan Pinjaman</span>
						</a>
					</li>
					<li class="has-sub">
						<a href="{{url('PinjamanTransfer')}}">
							{!! notifikasi_pencairan() !!}
							<i class="fa fa-cog"></i>
							<span>Proses Pencairan</span>
						</a>
					</li>
					<li class="has-sub">
						<a href="{{url('TransaksiPinjaman')}}">
							<i class="fa fa-list"></i>
							<span>Daftar Pinjaman</span>
						</a>
					</li>
					<li class="has-sub">
						<a href="{{url('Transaksi')}}">
							<i class="fa fa-list"></i>
							<span>Transaksi Keuangan</span>
						</a>
					</li>
					<li class="has-sub">
						<a href="{{url('Gaji')}}">
							<i class="fa fa-list"></i>
							<span>Gaji KMS</span>
						</a>
					</li>
					<li class="has-sub">
						<a href="{{url('Saldopinjaman')}}">
							<i class="fa fa-briefcase"></i>
							<span>Saldo Pinjaman</span>
						</a>
					</li>
					<li class="has-sub">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="fa fa-briefcase"></i>
							<span>Simpana Anggota</span> 
						</a>
						<ul class="sub-menu">
							<li><a href="{{url('Simpananwajib')}}">Wajib <i class="fa fa-paper-plane text-theme"></i></a></li>
							<li><a href="{{url('Simpanansukarela')}}">Sukarela<i class="fa fa-paper-plane text-theme"></i></a></li>
							
						</ul>
					</li>
				@endif
				
                
				
			</ul>