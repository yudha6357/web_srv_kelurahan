<?php
function month($month)
{

	$months = [
		1		=> 'Januari',
		2		=> 'Februari',
		3		=> 'Maret',
		4		=> 'April',
		5		=> 'Mei',
		6		=> 'Juni',
		7		=> 'Juli',
		8		=> 'Agustus',
		9		=> 'September',
		10	=> 'Oktober',
		11	=> 'November',
		12	=> 'Desember',
	];

	$month_number = intval($month);
	if ($month_number == 0 || $month_number > 12) {
		return null;
	}

	return $months[$month_number];
}
