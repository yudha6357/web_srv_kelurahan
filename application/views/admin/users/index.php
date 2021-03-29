<?php $this->load->view("css/css.php") ?>
<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- <link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/select2/dist/css/select2.css"> -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<?php $this->load->view("layout/admin.php") ?>
<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Data Users</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item">Tables</li>
			<li class="breadcrumb-item active" aria-current="page">Data Users</li>
		</ol>
	</div>

	<!-- Row -->
	<div class="row">
		<!-- Datatables -->
		<div class="col-lg-12">
			<div class="card mb-4">
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-primary">Data Users</h6>
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
								<th>Nama</th>
								<th>Email</th>
								<th>Role</th>
								<th>Action</th>
							</tr>
						</thead>

						<tbody>
							<?php $no = 1; ?>
							<?php foreach ($users as $item) { ?>
								<tr>
									<td><?= $no++ ?></td>
									<td><?= $item->name ?></td>
									<td><?= $item->email ?></td>
									<td><?= $item->role_name ?></td>
									<td>
										<div class="btn-group">
											<a href="" class="btn btn-info" data-toggle="modal" data-target="#exampleModalEdit<?= $item->id ?>">Edit</a>
											<a class="btn btn-danger" type="button" href="<?= base_url('users/destroy/' . $item->id) ?> " onclick="return confirm('Hapus data?');">
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
					<form action="<?= base_url('users/store') ?>" method="post">
						<div class="form-group">
							<label for="name">Nama</label>
							<input type="text" name="name" class="form-control" id="name" required>
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" name="email" class="form-control" id="email" required>
						</div>
						<div class="form-group">
							<label for="password">Pasword</label>
							<input type="password" name="password" class="form-control" id="password" required>
						</div>
						<div class="form-group">
							<label for="bulan">Role</label>
							<select class="form-control" name="role_id" id="role_id" required>
								<option value="">Pilih Role</option>
								<option value="1">Admin</option>
								<option value="2">Operator</option>
							</select>
						</div>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" id="save" class="btn btn-primary">Save</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php $no = 0;
	foreach ($users as $item) : $no++; ?>

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
						<form action="<?= base_url('users/update') ?>" method="post">
							<input type="text" value="<?= $item->id ?>" name="id" hidden>
							<div class="form-group">
								<label for="name">Nama</label>
								<input type="text" name="name" value="<?= $item->name ?>" class="form-control" id="name" required>
							</div>
							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" name="email" value="<?= $item->email ?>" class="form-control" id="email" required>
							</div>
							<div class="form-group">
							<label for="password">Pasword</label>
							<input type="password" name="password" class="form-control" id="password" required>
						</div>
							<div class="form-group">
								<label for="bulan">Role</label>
								<select class="form-control" name="role_id" id="role_id" required>
									<option value="">Pilih Role</option>
									<option <?=$item->role_id == 1 ? "selected": ""?> value="1">Admin</option>
									<option <?=$item->role_id == 2 ? "selected": ""?> value="2">Operator</option>
								</select>
							</div>
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

	});
</script>
</body>

</html>
