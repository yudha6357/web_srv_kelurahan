<?php
function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	
	// variabel pecahkan 0 = tahun
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tanggal
 
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
?>
<?php $this->load->view("css/css.php") ?>
<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<?php $this->load->view("layout/admin.php") ?>
<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Data Transaksi</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a copy href="./">Home</a>
			</li>
			<li class="breadcrumb-item">Tables</li>
			<li class="breadcrumb-item active" aria-current="page">Data Transaksi</li>
		</ol>
	</div>

	<!-- Row -->
	<div class="row">
		<!-- Datatables -->
		<div class="col-lg-12">
			<div class="card mb-4">
				<?php foreach ($errors as $key => $value) { ?>
					<div class="alert alert-danger" role="alert"><?= $value ?></div>
				<?php }?>
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-primary">Data Transaksi</h6>
				</div>
				<div style="padding-left: 2%;">
					<button type="button" class="btn btn-primary" style="width:7%;" data-toggle="modal" data-target="#exampleModal">
						Add
					</button>
				</div>

				<div class="table-responsive p-3">
					<table class="table align-items-center table-flush" id="dataTable">
						<thead class="thead-light">
							<tr>
								<th>No</th>
								<th>Kode</th>
								<th>Kegiatan</th>
								<th>Pengeluaran</th>
								<th>Tanggal</th>
								<th>Acton</th>
							</tr>
						</thead>

						<tbody>
							<?php $no = 1; ?>
							<?php foreach ($transaksi as $item) { ?>
								<tr>
									<td><?= $no++ ?></td>
									<td><?= $item->kode ?></td>
									<td><?= $item->kegiatan ?></td>
									<td><?= 'Rp'.number_format($item->pengeluaran) ?></td>
									<td><?= tgl_indo(date("Y-m-d", strtotime($item->tanggal))) ?></td>
									<td>
										<div class="btn-group">
											<a href="" class="btn btn-info" data-toggle="modal" data-target="#exampleModalEdit<?= $item->id ?>">Edit</a>
											<a class="btn btn-danger" type="button" href="<?= base_url('transaksi/destroy/' . $item->id) ?> " onclick="return confirm('Hapus data?');">
												Hapus
											</a>
										</div>
									</td>
								</tr>
							<?php } ?>

						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- DataTable with Hover -->
	</div>
	<!-- Button trigger modal -->
	<!-- Modal -->

	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url('transaksi/store') ?>" method="post">
						<div class="form-group">
							<label for="bulan">Kegiatan</label>
							<select class="form-control" name="kegiatan" id="kegiatan" onchange="autofill()" required>
								<option hidden value="">Silahkan Pilih</option>
								<?php foreach ($anggaran as $item) { ?>
									<option id="<?= $item->id ?>-op-anggaran"><?= $item->kegiatan ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label for="kegiatan">Kode</label>
							<input type="text" name="kode" class="form-control" id="kode" required readonly>
						</div>
						<div class="form-group">
							<label for="anggaran">Pengeluaran</label>
							<input type="number" name="pengeluaran" class="form-control" id="pengeluaran" required>
						</div>
						<div class="form-group">
              <label for="kode">Tahun</label>
              <select class="form-control" name="tahun" id="tahun" required>
							  <option hidden value="">Silahkan Pilih</option>
								<?php foreach ($tahun_option as $item) { ?>
									<option value="<?= $item->id ?>"><?= $item->tahun ?></option>
                <?php } ?>
              </select>
						</div>
						<div class="form-group">
							<label for="tanggal">Tanggal</label>
							<input type="date" name="tanggal" class="form-control" id="tanggal" required>
						</div>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<?php $no = 0;
	foreach ($transaksi as $item) : $no++; ?>
		<div class="modal fade modalEdit" id="exampleModalEdit<?= $item->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="<?= base_url('transaksi/update') ?>" method="post">
							<input type="text" value="<?= $item->id ?>" name="id" hidden>
							<div class="form-group">
								<label for="kodeEdit">Kode</label>
								<input type="text" readonly value="<?= $item->kode ?>" name="kode" class="form-control" id="kodeEdit<?= $item->id ?>" required>
							</div>
							<div class="form-group">
								<label for="kegiatan">Kegiatan</label>
								<input type="text" readonly value="<?= $item->kegiatan ?>" name="kegiatan" class="form-control" id="kegiatanEdit<?= $item->id ?>" required>
							</div>
							<div class="form-group">
								<label for="pengeluaran">Pengeluaran</label>
								<input type="number" value="<?= $item->pengeluaran ?>" name="pengeluaran" class="form-control" id="pengeluaran" required>
							</div>
							<div class="form-group">
								<label for="tanggal">Tanggal</label>
								<input type="date" name="tanggal" class="form-control" id="tanggal" value="<?= $item->tanggal ?>" required>
							</div>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Save changes</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach  ?>
</div>
<?php $this->load->view("footer/footer.php") ?>
<?php $this->load->view("js/js.php") ?>
<script>
	$(document).ready(function() {
		$('#dataTable').DataTable(); // ID From dataTable 
		$('#dataTableHover').DataTable(); // ID From dataTable with Hover
	});

	function autofill() {
		// var kegiatan = $("#kegiatan").val();
		var el_id = $('#kegiatan').children(":selected").attr("id");
		var id = parseInt(el_id.split('-')[0])
		$.ajax({
			url: '<?= base_url('Transaksi/get_by_id') ?>',
			data: {
				id: id
			},
			type: "POST",
			dataType: 'json',
			success: (function(response) {
				console.log(response);
				response.forEach(function(item) {
					$('#kode').val(item.kode);
					$('#kode').val(item.kode);
				});
			})
		});
	}

	function autofillEdit(id) {
		var kode = $("#kodeEdit"+id).val();
		console.log(kode);
		$.ajax({
			url: '<?= base_url('Transaksi/ajax') ?>',
			data: {
				kode: kode
			},
			type: "POST",
			dataType: 'json',
			success: (function(response) {
				response.forEach(function(item) {
					console.log(item.kegiatan);
					$('#kegiatanEdit'+id).val(item.kegiatan);
				});
			})
		});
	}
</script>
</body>

</html>
