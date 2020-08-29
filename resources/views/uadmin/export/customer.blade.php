<!DOCTYPE html>
<html lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Laporan Data Pelanggan</title>
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
		<h5>Laporan Data Pelanggan</h5>
	</div>

	<div class="col-12">
		<table class='table table-sm table-bordered table-striped'>
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Nama Pelanggan</th>
					<th>Telepon</th>
					<th>Pekerjaan</th>
					<th>Metode Pembayaran</th>
					<th>Tipe Kredit</th>
					<th>Unit</th>
					<th>Status Berkas</th>
					<th>Sales</th>
				</tr>
			</thead>
			<tbody>
				@foreach($customers as $customer)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ date('d F Y', strtotime($customer->date)) }}</td>
					<td>{{ $customer->name }}</td>
					<td>{{ $customer->phone }}</td>
					<td>{{ $customer->job }}</td>
					<td>{{ $customer->method_payment }}</td>
					<td>{{ $customer->type }}</td>
					<td>{{ $customer->block_cluster }}</td>
					<td>{{ $customer->state_name }}</td>
					<td>{{ $customer->sales_name }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
 
</body>
</html>