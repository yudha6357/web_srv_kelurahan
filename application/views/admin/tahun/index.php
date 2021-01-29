<?php $this->load->view("css/css.php") ?>
<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- <link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/select2/dist/css/select2.css"> -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<?php $this->load->view("layout/admin.php") ?>
<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Data Tahun</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item">Tables</li>
			<li class="breadcrumb-item active" aria-current="page">Data Tahun</li>
		</ol>
	</div>

	<!-- Row -->
	<div class="row">
		<!-- Datatables -->
		<div class="col-lg-12">
			<div class="card mb-4">
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-primary">Data Tahun</h6>
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
								<th>No.</th>
								<th>Tahun</th>
								<th>status</th>
								<th>Action</th>
							</tr>
						</thead>

						<tbody>
							<?php $no = 1; ?>
							<?php foreach ($tahun as $item) { ?>
								<tr>
									<td><?= $no++ ?></td>
									<td><?= $item->tahun ?></td>
									<td><?= $item->is_active?></td>
									<td>
										<div class="btn-group">
											<a href="" class="btn btn-info" data-toggle="modal" data-target="#exampleModalEdit<?= $item->id ?>">Edit</a>
											<a class="btn btn-danger" type="button" href="<?= base_url('tahun/destroy/' . $item->id) ?> " onclick="return confirm('Hapus data?');">
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
					<form action="<?= base_url('tahun/store') ?>" method="post">
						<div class="form-group">
              <label for="kode">Tahun</label>
              <select class="form-control" name="tahun" id="tahun">
							  <option hidden><?= 'Silahkan Pilih' ?></option>
								<?php foreach ($tahun_option as $item) { ?>
									<option><?= $item ?></option>
                <?php } ?>
              </select>
						</div>
						<div class="form-group">
							<label for="bulan">Status</label>
							<select class="form-control" name="status" id="targetId">
								<option value="1">Aktif</option>
								<option value="0">Non Aktive</option>
							</select>
						</div>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" id="save" class="btn btn-primary">Save changes</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php $no = 0;
	foreach ($tahun as $item) : $no++; ?>

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
						<form action="<?= base_url('tahun/update') ?>" method="post">
							<div class="form-group">
								<input type="text" value="<?= $item->id ?>" name="id" hidden>
								<label for="tahun">tahun</label>
								<select class="form-control" name="tahun" id="tahun">
							  <option hidden><?= 'Silahkan Pilih' ?></option>
								<?php foreach ($tahun_option as $year) { ?>
									<option <?=$item->tahun , $year ? "selected": ""?> ><?= $year ?></option>
                <?php } ?>
              </select>
							</div>
							<div class="form-group">
								<label for="status">Kegiatan</label>
								<select class="form-control" name="status" id="targetId">
								<option value="1" <?=$item->is_active, 1 ? "selected": ""?>>Aktif</option>
								<option value="0" <?=$item->is_active, 0 ? "selected": ""?> >Non Aktive</option>
							</select>
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
<!-- <script scr="<?= base_url('assets/'); ?>vendor/select2/dist/js/select2.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="http://www.google.com/jsapi?key=ABQIAAAA1XbMiDxx_BTCY2_FkPh06RRaGTYH6UMl8mADNa0YKuWNNa8VNxQEerTAUcfkyrr6OwBovxn7TDAH5Q"></script>
<script>

	$(document).ready(function() {
		$('#dataTable').DataTable(); // ID From dataTable 
		$('#dataTableHover').DataTable(); // ID From dataTable with Hover	

		$('#targetId').select2({
			width: '100%',
			dropdownParent: $("#exampleModal")
		})

		<?php $no = 0;
		foreach ($tahun as $item) : $no++; ?>
			$('#targetIdEdit<?= $item->id ?>').select2({
				width: '100%',
				dropdownParent: $("#exampleModalEdit<?= $item->id ?>")
			})
		<?php endforeach  ?>

	});
</script>
</body>

</html>
