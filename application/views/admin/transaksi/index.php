<?php $this->load->view("css/css.php") ?>
<link href="
vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<?php $this->load->view("layout/admin.php") ?>
<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">DataTables</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<aanggaran copy href="./">Home</aanggaran>
			</li>
			<li class="breadcrumb-item">Tables</li>
			<li class="breadcrumb-item active" aria-current="page">DataTables</li>
		</ol>
	</div>

	<!-- Row -->
	<div class="row">
		<!-- Datatables -->
		<div class="col-lg-12">
			<div class="card mb-4">
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-primary">DataTables</h6>
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
									<td><?= $item->pengeluaran ?></td>
									<td><?= date("d-m-Y", strtotime($item->created_at)) ?></td>
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
							<label for="bulan">Kode</label>
							<select class="form-control" name="kode" id="kode" onchange="autofill()">
								<option hidden><?= 'Silahkan Pilih' ?></option>
								<?php foreach ($anggaran as $item) { ?>
									<option><?= $item->kode ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label for="kegiatan">Kegiatan</label>
							<input type="text" name="kegiatan" class="form-control" id="kegiatan">
						</div>
						<div class="form-group">
							<label for="anggaran">Pengeluaran</label>
							<input type="text" name="pengeluaran" class="form-control" id="pengeluaran">
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
								<select class="form-control" name="kode" id="kodeEdit<?= $item->id ?>" onchange="autofillEdit(<?=$item->id?>)">
									<option hidden><?= 'Silahkan Pilih' ?></option>
									<?php foreach ($anggaran as $agg) { ?>
										<option value="<?= $agg->kode ?>" <?= $agg->kode == $item->kode ? 'selected' : "" ?>><?= $agg->kode ?> </option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label for="kegiatan">Kegiatan</label>
								<input type="text" readonly value="<?= $item->kegiatan ?>" name="kegiatan" class="form-control" id="kegiatanEdit<?= $item->id ?>">
							</div>
							<div class="form-group">
								<label for="pengeluaran">Pengeluaran</label>
								<input type="text" value="<?= $item->pengeluaran ?>" name="pengeluaran" class="form-control" id="pengeluaran">
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
	function autofill() {
		var kode = $("#kode").val();
		$.ajax({
			url: '<?= base_url('Transaksi/ajax') ?>',
			data: {
				kode: kode
			},
			type: "POST",
			dataType: 'json',
			success: (function(response) {
				console.log(response);
				response.forEach(function(item) {
					$('#kegiatan').val(item.kegiatan);
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
