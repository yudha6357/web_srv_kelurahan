<?php $this->load->view("css/css.php") ?>
<?php $this->load->view("layout/admin.php") ?>
<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
		</ol>
	</div>

	<div class="row mb-3">
		<!-- Earnings (Monthly) Card Example -->
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card h-100">
				<div class="card-body">
					<div class="row align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-uppercase mb-1">Anggaran Bulan Ini</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= number_format($anggaran_bulan) ?>,-</div>
						</div>
						<div class="col-auto">
							<i class="fas fa-calendar fa-2x text-primary"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Earnings (Annual) Card Example -->
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card h-100">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-uppercase mb-1">Transaksi Bulan Ini</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= number_format($pengeluaran_bulan) ?>,-</div>
						</div>
						<div class="col-auto">
							<i class="fas fa-shopping-cart fa-2x text-success"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- New User Card Example -->
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card h-100">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-uppercase mb-1">Sisa Anggaran</div>
							<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">Rp. <?= number_format($sisa_anggaran) ?>,-</div>
						</div>
						<div class="col-auto">
							<i class="fas fa-shopping-cart fa-2x text-danger"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Pending Requests Card Example -->
		<!-- <div class="col-xl-3 col-md-6 mb-4">
			<div class="card h-100">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-uppercase mb-1">Pending Requests</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
							<div class="mt-2 mb-0 text-muted text-xs">
								<span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
								<span>Since yesterday</span>
							</div>
						</div>
						<div class="col-auto">
							<i class="fas fa-comments fa-2x text-warning"></i>
						</div>
					</div>
				</div>
			</div>
		</div> -->
		<div class="col-lg-4">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">Realisasi Dana</h6>
				</div>
				<div class="card-body">
					<div class="chart-pie pt-4">
						<canvas id="myPieChart"></canvas>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-8">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">Realisasi Dana</h6>
				</div>
				<div class="card-body">
					<div class="chart-bar">
						<canvas id="myBarChart"></canvas>
					</div>
				</div>
			</div>
		</div>
		<!-- Area Chart -->
	</div>
	<!--Row-->
</div>
<?php $this->load->view("footer/footer.php") ?>
<?php $this->load->view("js/js.php") ?>
<script src="<?= base_url('assets/'); ?>js/ruang-admin.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/chart.js/Chart.min.js"></script>
<script>
	// Set new default font family and font color to mimic Bootstrap's default styling
	// Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
	// Chart.defaults.global.defaultFontColor = '#858796';

	// Pie Chart Example
	var ctx = document.getElementById("myPieChart");
	console.log(<?= $pengeluaran_bulan ?>);
	var myPieChart = new Chart(ctx, {
		type: 'doughnut',
		data: {
			labels: ["Terealisasi", "Tidak Terealisasi"],
			datasets: [{
				data: [<?= $pengeluaran_bulan ?>, <?= $sisa_anggaran ?>],
				backgroundColor: ['#1cc88a', '#FF0000', '#36b9cc'],
				hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
				hoverBorderColor: "rgba(234, 236, 244, 1)",
			}],
		},
		options: {
			maintainAspectRatio: false,
			tooltips: {
				backgroundColor: "rgb(255,255,255)",
				bodyFontColor: "#858796",
				borderColor: '#dddfeb',
				borderWidth: 1,
				xPadding: 15,
				yPadding: 15,
				displayColors: false,
				caretPadding: 10,
			},
			legend: {
				display: false
			},
			cutoutPercentage: 80,
		},
	});

	// Set new default font family and font color to mimic Bootstrap's default styling
	// Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
	// Chart.defaults.global.defaultFontColor = '#858796';

	function number_format(number, decimals, dec_point, thousands_sep) {
		// *     example: number_format(1234.56, 2, ',', ' ');
		// *     return: '1 234,56'
		number = (number + '').replace(',', '').replace(' ', '');
		var n = !isFinite(+number) ? 0 : +number,
			prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
			sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
			dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
			s = '',
			toFixedFix = function(n, prec) {
				var k = Math.pow(10, prec);
				return '' + Math.round(n * k) / k;
			};
		// Fix for IE parseFloat(0.55).toFixed(0) = 0;
		s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
		if (s[0].length > 3) {
			s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
		}
		if ((s[1] || '').length < prec) {
			s[1] = s[1] || '';
			s[1] += new Array(prec - s[1].length + 1).join('0');
		}
		return s.join(dec);
	}

	// Bar Chart Example
	var ctx = document.getElementById("myBarChart");
	var myBarChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: [
				"January", "February", "March", "April", "May", "June", "Juli", "Agustus", "September", "Oktober", "November", "Desember"
			],
			datasets: [{
				label: "anggaran",
				backgroundColor: "#4e73df",
				hoverBackgroundColor: "#2e59d9",
				borderColor: "#4e73df",
				data: <?= json_encode($anggaran_tahunan) ?>,
			}, {
				label: "Test",
				backgroundColor: "#DC143C",
				hoverBackgroundColor: "#FF000",
				borderColor: "#FF0000",
				data: <?= json_encode($sisa_tahunan) ?>,
			}],
		},
		options: {
			maintainAspectRatio: false,
			layout: {
				padding: {
					left: 10,
					right: 25,
					top: 25,
					bottom: 0
				}
			},
			scales: {
				xAxes: [{
					time: {
						unit: 'month'
					},
					gridLines: {
						display: false,
						drawBorder: false
					},
					ticks: {
						maxTicksLimit: 6
					},
					maxBarThickness: 25,
				}],
				yAxes: [{
					ticks: {
						min: 0,
						max: 10000000,
						maxTicksLimit: 15,
						padding: 10,
						// Include a dollar sign in the ticks
						callback: function(value, index, values) {
							return 'Rp. ' + number_format(value);
						}
					},
					gridLines: {
						color: "rgb(234, 236, 244)",
						zeroLineColor: "rgb(234, 236, 244)",
						drawBorder: false,
						borderDash: [2],
						zeroLineBorderDash: [2]
					}
				}],
			},
			legend: {
				display: false
			},
			tooltips: {
				titleMarginBottom: 10,
				titleFontColor: '#6e707e',
				titleFontSize: 14,
				backgroundColor: "rgb(255,255,255)",
				bodyFontColor: "#858796",
				borderColor: '#dddfeb',
				borderWidth: 1,
				xPadding: 15,
				yPadding: 15,
				displayColors: false,
				caretPadding: 10,
				callbacks: {
					label: function(tooltipItem, chart) {
						var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
						return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
					}
				}
			},
		}
	});
</script>

</body>

</html>
