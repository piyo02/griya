<!DOCTYPE html>
<html lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Laporan Keuangan</title>
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
		<h5>Laporan Keuangan</h5>		
	</div>

	<div class="col-6">
		<table class='table table-sm table-bordered table-striped'>
			<tbody>
				@foreach($accounts as $key => $account)
				<tr>
					<td>{{ $account->name }}</td>
					<td class="text-right">{{ $account->saldo }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
 
	<div class="col-12">
		<table class='table table-sm table-bordered table-striped'>
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Rekening Sumber</th>
					<th>Rekening Tujuan</th>
					<th>Tipe</th>
					<th>Jumlah</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				@foreach($cashFlows as $key => $customer)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ date('d F Y H:i:s', strtotime($customer[1])) }}</td>
					<td>{{ $customer[2] }}</td>
					<td>{{ $customer[3] }}</td>
					<td>{{ $customer[4] }}</td>
					<td class="text-right">{{ $customer[5] }}</td>
					<td>{{ $customer[6] }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
 
</body>
</html>