<!DOCTYPE html>
<html lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Laporan Kas Keluar</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<div class="col-12 text-center mb-4">
		<h5>Laporan Kas Keluar</h5>
	</div>
 
	<div class="col-12">
		<table class='table table-sm table-bordered table-striped'>
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Tipe Pengeluaran</th>
					<th>Rekening Pengeluaran</th>
					<th>Jumlah</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				@foreach($cashOuts as $cashOut)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ date('d F Y H:i:s', strtotime($cashOut->datetime)) }}</td>
					<td>{{ $cashOut->type_name }}</td>
					<td>{{ $cashOut->source_acc_name }}</td>
					<td class="text-right">{{ number_format($cashOut->total) }}</td>
					<td>{{ $cashOut->description }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
 
</body>
</html>