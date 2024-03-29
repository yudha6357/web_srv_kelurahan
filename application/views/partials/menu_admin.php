<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
		<div class="sidebar-brand-icon">
			<img src="<?= base_url('assets/'); ?>img/logo/logo2.png">
		</div>
		<div class="sidebar-brand-text mx-3">RuangAdmin</div>
	</a>
	<hr class="sidebar-divider my-0">
	<li class="nav-item active">
		<a class="nav-link" href="<?= base_url('admin'); ?>">
			<i class="fas fa-fw fa-tachometer-alt"></i>
			<span>Dashboard</span></a>
	</li>
	<hr class="sidebar-divider">
	<div class="sidebar-heading">
		Features
	</div>
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap" aria-expanded="true" aria-controls="collapseBootstrap">
			<i class="far fa-fw fa-window-maximize"></i>
			<span>Data Keuangan</span>
		</a>
		<div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<h6 class="collapse-header">Data Keuangan</h6>
				<a class="collapse-item" href="<?= base_url('anggaran'); ?>">Anggaran</a>
				<a class="collapse-item" href="<?= base_url('transaksi'); ?>">Transaksi</a>
			</div>
		</div>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="<?= base_url('rekap'); ?>">
			<i class="fas fa-fw fa-chart-area"></i>
			<span>Rekap Data</span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap2" aria-expanded="true" aria-controls="collapseBootstrap">
			<i class="far fa-fw fa-window-maximize"></i>
			<span>Setting</span>
		</a>
		<div id="collapseBootstrap2" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<h6 class="collapse-header">Setting</h6>
				<a class="collapse-item" href="<?= base_url('tahun/index'); ?>">Tahun</a>
			</div>
		</div>
	</li>
	<hr class="sidebar-divider">
</ul>
