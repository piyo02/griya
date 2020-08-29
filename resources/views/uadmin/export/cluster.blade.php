<!DOCTYPE html>
<html lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Laporan Blok Kluster</title>
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
		<h5>Laporan Blok Kluster</h5>
	</div>
 
	<div class="col-12">
		<table class='table table-sm table-bordered table-striped'>
			<thead>
				<tr>
					<th>No</th>
					<th>Unit</th>
					<th>Status</th>
					<th>Nama Pelanggan</th>
				</tr>
			</thead>
			<tbody>
				@foreach($clusters as $cluster)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $cluster->cluster }}</td>
					<td>{{ $cluster->state }}</td>
					<td>{{ $cluster->state == 'TERISI' ? $cluster->customer_name : '-' }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
 
</body>
</html>