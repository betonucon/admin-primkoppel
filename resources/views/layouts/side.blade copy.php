            <ul class="nav">
                <li class="has-sub">
					<a href="{{url('/')}}">
						<i class="fa fa-home"></i>
						<span>Dashboard</span>
					</a>
				</li>
				@if(Auth::user()['role_id']==1)
					
					<li class="has-sub">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="fa fa-users"></i>
							<span>Anggota</span> 
						</a>
						<ul class="sub-menu">
							<li><a href="{{url('anggota')}}">Anggota </a></li>
							<li><a href="{{url('anggota')}}">Stok Barang</a></li>
							
						</ul>
					</li>
					<li class="has-sub">
						<a href="{{url('barang')}}">
							<i class="fa fa-briefcase"></i>
							<span>Daftar Barang</span>
						</a>
					</li>
					<li class="has-sub">
						<a href="{{url('simpanan')}}">
							<i class="fa fa-money-bill-alt"></i>
							<span>Simpanan Anggota</span>
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
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="fa fa-briefcase"></i>
							<span>Simpanan Anggota</span> 
						</a>
						<ul class="sub-menu">
							<li><a href="{{url('Simpananwajib')}}">Wajib <i class="fa fa-paper-plane text-theme"></i></a></li>
							<li><a href="{{url('Simpanansukarela')}}">Sukarela<i class="fa fa-paper-plane text-theme"></i></a></li>
							
						</ul>
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
				@if(Auth::user()['role_id']==3)
					<li class="has-sub">
						<a href="{{url('Pinjaman')}}">
							<i class="fa fa-list"></i>
							<span>Verifikasi Kontrak</span>
						</a>
					</li>

				@endif
                
                
				
			</ul>