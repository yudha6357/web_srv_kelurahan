<?php $this->load->view("css/css.php") ?>
<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- <link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/select2/dist/css/select2.css"> -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<?php $this->load->view("layout/admin.php") ?>
<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Data Anggaran</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item">Tables</li>
			<li class="breadcrumb-item active" aria-current="page">Data Anggaran</li>
		</ol>
	</div>

	<!-- Row -->
	<div class="row">
		<!-- Datatables -->
		<div class="col-lg-12">
			<div class="card mb-4">
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-primary">Data Anggaran</h6>
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
								<th>Kode</th>
								<th>Kegiatan</th>
								<th>Anggaran</th>
								<th>Volume</th>
								<th>Bulan</th>
								<th>Action</th>
							</tr>
						</thead>

						<tbody>
							<?php $no = 1; ?>
							<?php foreach ($anggaran as $item) { ?>
								<tr>
									<td><?= $no++ ?></td>
									<td><?= $item->kode ?></td>
									<td><?= $item->kegiatan ?></td>
									<td><?= $item->anggaran ?></td>
									<td><?= $item->volume ?></td>
									<td> <?php $blnTemp = [] ?>
										<?php foreach (json_decode($item->bulan_realisasi) as $bln) {
											$blnTemp[] = $bln;
										} ?>
										<?= implode(" ", $blnTemp); ?>
									</td>
									<td>
										<div class="btn-group">
											<a href="" class="btn btn-info" data-toggle="modal" data-target="#exampleModalEdit<?= $item->id ?>">Edit</a>
											<a class="btn btn-danger" type="button" href="<?= base_url('anggaran/destroy/' . $item->id) ?> " onclick="return confirm('Hapus data?');">
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
					<form action="<?= base_url('anggaran/store') ?>" method="post">
						<div class="form-group">
							<label for="kode">Kode</label>
							<input type="text" name="kode" class="form-control" id="kode">
						</div>
						<div class="form-group">
							<label for="kegiatan">Kegiatan</label>
							<input type="text" name="kegiatan" class="form-control" id="kegiatan">
						</div>
						<div class="form-group">
							<label for="anggaran">Anggaran</label>
							<input type="text" name="anggaran" class="form-control" id="anggaran">
						</div>
						<div class="form-group">
							<label for="volume">Volume</label>
							<input type="number" min="0" max="12" class="form-control" name="volume" id="volume">
						</div>
						<div class="form-group">
							<label for="bulan">Bulan</label>
							<select class="form-control" name="bulan[]" id="targetId" multiple="multiple">
								<option>Januari</option>
								<option>Februari</option>
								<option>Maret</option>
								<option>April</option>
								<option>Mei</option>
								<option>Juni</option>
								<option>Juli</option>
								<option>Agustus</option>
								<option>September</option>
								<option>Oktober</option>
								<option>November</option>
								<option>Desember</option>
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
	foreach ($anggaran as $item) : $no++; ?>

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
						<form action="<?= base_url('anggaran/update') ?>" method="post">
							<div class="form-group">
								<input type="text" value="<?= $item->id ?>" name="id" hidden>
								<label for="kode">Kode</label>
								<input type="text" value="<?= $item->kode ?>" name="kode" class="form-control" id="kode">
							</div>
							<div class="form-group">
								<label for="kegiatan">Kegiatan</label>
								<input type="text" value="<?= $item->kegiatan ?>" name="kegiatan" class="form-control" id="kegiatan">
							</div>
							<div class="form-group">
								<label for="anggaran">Anggaran</label>
								<input type="text" value="<?= $item->anggaran ?>" name="anggaran" class="form-control" id="anggaran">
							</div>
							<div class="form-group">
								<label for="volume">Volume</label>
								<input type="number" value="<?= $item->volume ?>" min="0" max="12" class="form-control" name="volume" id="volume">
							</div>
							<div class="form-group">
								<label for="bulan">Bulan</label>
								<select class="form-control" name="bulan[]" id="targetIdEdit<?= $item->id ?>" multiple="multiple">
									<option <?= preg_match("/Januari/", $item->bulan_realisasi) ? "selected" : "" ?>>Januari</option>
									<option <?= preg_match("/Februari/", $item->bulan_realisasi) ? "selected" : "" ?>>Februari</option>
									<option <?= preg_match("/Maret/", $item->bulan_realisasi) ? "selected" : "" ?>>Maret</option>
									<option <?= preg_match("/April/", $item->bulan_realisasi) ? "selected" : "" ?>>April</option>
									<option <?= preg_match("/Mei/", $item->bulan_realisasi) ? "selected" : "" ?>>Mei</option>
									<option <?= preg_match("/Juni/", $item->bulan_realisasi) ? "selected" : "" ?>>Juni</option>
									<option <?= preg_match("/Juli/", $item->bulan_realisasi) ? "selected" : "" ?>>Juli</option>
									<option <?= preg_match("/Agustus/", $item->bulan_realisasi) ? "selected" : "" ?>>Agustus</option>
									<option <?= preg_match("/September/", $item->bulan_realisasi) ? "selected" : "" ?>>September</option>
									<option <?= preg_match("/Oktober/", $item->bulan_realisasi) ? "selected" : "" ?>>Oktober</option>
									<option <?= preg_match("/November/", $item->bulan_realisasi) ? "selected" : "" ?>>November</option>
									<option <?= preg_match("/Desember/", $item->bulan_realisasi) ? "selected" : "" ?>>Desember</option>
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
		foreach ($anggaran as $item) : $no++; ?>
			$('#targetIdEdit<?= $item->id ?>').select2({
				width: '100%',
				dropdownParent: $("#exampleModalEdit<?= $item->id ?>")
			})
		<?php endforeach  ?>


		$("#save").click(function(event){
		var volumeTemp = $("#volume").val();
		var volume = parseInt(volumeTemp)
		var bulan = $("#targetId").val();
		 if (volume != bulan.length ) {	 
			event.preventDefault();
			alert("Jumlah bulan dan volume tidak sesuai")
		 }

		});

	});
</script>
</body>

</html>
