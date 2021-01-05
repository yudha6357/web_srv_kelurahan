<?php $this->load->view("css/css.php") ?>
<link href="
vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<?php $this->load->view("layout/admin.php") ?>
<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Rekap Pengeluaran</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<aanggaran copy href="./">Home</aanggaran>
			</li>
			<li class="breadcrumb-item">Tables</li>
			<li class="breadcrumb-item active" aria-current="page">Rekap Pengeluaran</li>
		</ol>
	</div>

	<!-- Row -->
	<div class="row">
		<!-- Datatables -->
		<div class="col-lg-12">
			<div class="card mb-4">
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-primary">Rekap Pengeluaran</h6>
				</div>
				<div style="padding-left: 2%;">
							<div class="form-group">
								<label for="exampleInputEmail1">Tahun</label>
									<select class="form-control" style="width: 30%;" name="year" id="year">
										<?php foreach ($tahun as $item) { ?>
											<option><?= $item['tahun'] ?></option>
										<?php }?>
									</select>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Bulan</label>
								<select class="form-control" style="width: 30%;" name="month" id="month">
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
              <button type="submit" class="btn btn-primary" id="search" onclick="search()" ><i class="fas fa-search text-grey" aria-hidden="true"></i> Search</button>

						<!-- </div> -->
						<!-- <div class="input-group-append"> -->
							<!-- <span class="input-group-text lime lighten-2" id="search" onclick="search()"><i class="fas fa-search text-grey" aria-hidden="true"></i></span> -->
						<!-- </div> -->
					<!-- </div> -->
				</div>

				<div class="table-responsive p-3">
				<div id="search-btn"></div><br>
					<table class="table align-items-center table-flush" id="dataTable">
						<thead class="thead-light">
							<tr>
								<th>No</th>
								<th>Kode</th>
								<th>Kegiatan</th>
								<th>Transaksi</th>
								<th>Tidak Terealisasi</th>
							</tr>
						</thead>

						<tbody id="data">
						</tbody>
					</table>
					<div class="row mb-3">
						<div class="col-lg-4" id="pieChart"></div>
						<div class="col-lg-8" id="barChart"></div>
					</div>
				</div>
			</div>
		</div>
		<!-- DataTable with Hover -->
	</div>
	<!-- Button trigger modal -->
	<!-- Modal -->
</div>
<?php $this->load->view("footer/footer.php") ?>
<?php $this->load->view("js/js.php") ?>
<script src="<?= base_url('assets/'); ?>js/ruang-admin.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/chart.js/Chart.min.js"></script>
<script>
	function search() {
		var month = $("#month").val();
		var year = $("#year").val();
		$('#data').empty();
    $('#search-btn').empty();
		$.ajax({
			url: '<?= base_url('Rekap/ajax') ?>',
			data: {
				month: month,
				year:year
			},
			type: "POST",
			dataType: 'json',
			success: (function(response) {
				var i = 1;
					$('#search-btn').append('<a class="btn btn-warning" href="<?=site_url()?>rekap/pdf/?id='+response.month+'"><i class="fa fa-file-excel-o" aria-hidden="true"></i>PDF</a>');

				response.rekap.forEach(function(element) {
					$('#data').append('<tr><td>'+i+'.</td><td>'+element.kegiatan+'</td><td>Rp. '+element.anggaran+',-</td><td>Rp. '+element.pengeluaran+',-</td><td>Rp. '+element.sisa+',-</td></tr>');
          i++;
					});

				$('#pieChart').append('<div class="mb-4"><div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Realisasi Dana</h6></div><div class="card-body"><div class="chart-pie pt-4"><canvas id="myPieChart"></canvas></div></div></div>');

				$('#barChart').append('<div class="mb-4"><div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Realisasi Dana</h6></div><div class="card-body"><div class="chart-bar"><canvas id="myBarChart"></canvas></div></div></div>');

				//lib
				var ctx = document.getElementById("myPieChart");
				var myPieChart = new Chart(ctx, {
					type: 'doughnut',
					data: {
						labels: ["Terealisasi", "Tidak Terealisasi"],
						datasets: [{
							data: [ response.pengeluaran_bulan , response.sisa_anggaran],
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
							data:  response.anggaran_tahunan,
						}, {
							label: "Test",
							backgroundColor: "#DC143C",
							hoverBackgroundColor: "#FF000",
							borderColor: "#FF0000",
							data:  response.sisa_tahunan,
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
			})
		});
	}
</script>
<script>
	// Set new default font family and font color to mimic Bootstrap's default styling
	// Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
	// Chart.defaults.global.defaultFontColor = '#858796';

	// Pie Chart Example
	

	// Set new default font family and font color to mimic Bootstrap's default styling
	// Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
	// Chart.defaults.global.defaultFontColor = '#858796';

	
</script>
</body>

</html>
