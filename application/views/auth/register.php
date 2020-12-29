<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<link href="<?= base_url('assets/'); ?>img/logo/logo.png" rel="icon">
	<title>RuangAdmin - Register</title>
	<link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url('assets/'); ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url('assets/'); ?>css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">
	<!-- Register Content -->
	<div class="container-login">
		<div class="row justify-content-center">
			<div class="col-xl-10 col-lg-12 col-md-9">
				<div class="card shadow-sm my-5">
					<div class="card-body p-0">
						<div class="row">
							<div class="col-lg-12">
								<div class="login-form">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4">Register</h1>
									</div>
									<form method="post" action="<?= base_url('auth/registration'); ?>">
										<div class="form-group">
											<label>Name</label>
											<input type="text" class="form-control" id="name" name="name" value="<?= set_value('name'); ?>" placeholder="Name">
											<?= form_error('name', '<small class="text-danger">', '</small') ?>
										</div>
										<div class="form-group">
											<label>Email</label>
											<input type="email" class="form-control" id="email" value="<?= set_value('name'); ?>" name="email" aria-describedby="emailHelp" placeholder="Enter Email Address">
											<?= form_error('email', '<small class="text-danger">', '</small') ?>
										</div>
										<div class="form-group">
											<label>Password</label>
											<input type="password" class="form-control" id="password" name="password" placeholder="Password">
											<?= form_error('password', '<small class="text-danger">', '</small') ?>
										</div>
										<div class="form-group">
											<label>Repeat Password</label>
											<input type="password" class="form-control" name="password_repeat" id="password_repeat" placeholder="Repeat Password">
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-primary btn-block">Register</button>
										</div>
										<hr>
									</form>
									<hr>
									<div class="text-center">
										<a class="font-weight-bold small" href="login.html">Already have an account?</a>
									</div>
									<div class="text-center">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Register Content -->
	<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
	<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>
	<script src="<?= base_url('assets/'); ?>js/ruang-admin.min.js"></script>
</body>

</html>
