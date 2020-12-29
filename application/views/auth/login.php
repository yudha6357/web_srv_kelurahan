<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<link href="<?= base_url('assets/'); ?>img/logo/logo.png" rel="icon">
	<title>RuangAdmin - Login</title>
	<link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url('assets/'); ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url('assets/'); ?>css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">
	<!-- Login Content -->
	<div class="container-login">
		<div class="row justify-content-center">
			<div class="col-xl-10 col-lg-12 col-md-9">
				<div class="card shadow-sm my-5">
					<div class="card-body p-0">
						<div class="row">
							<div class="col-lg-12">
								<div class="login-form">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4">Login</h1>
									</div>
									<?= $this->session->flashdata('message') ?>
									<form class="user" method="post" action="<?= base_url('auth'); ?> ">
										<div class="form-group">
											<input type="email" class="form-control" value="<?= set_value('email'); ?>" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter Email Address">
											<?= form_error('email', '<small class="text-danger">', '</small') ?>
										</div>
										<div class="form-group">
											<input type="password" class="form-control" name="password" id="password" placeholder="Password">
											<?= form_error('password', '<small class="text-danger">', '</small') ?>
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-primary btn-block">Login</button>
										</div>

									</form>
									<hr>
									<div class="text-center">
										<a class="font-weight-bold small" href="register.html">Create an Account!</a>
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
	<!-- Login Content -->
	<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
	<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>
	<script src="<?= base_url('assets/'); ?>js/ruang-admin.min.js"></script>
</body>

</html>
