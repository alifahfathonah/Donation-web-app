<div class="container">
	<button class="btn btn-primary mb-2" id="trigger_modal">Tambahkan Admin</button>
	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Top 10 Donatur</h3>

					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
						</button>
						<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
					</div>
				</div>
				<div class="card-body">
					<div class="chart">
						<canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
					</div>
				</div>
				<!-- /.card-body -->
			</div>
		</div>
		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Donasi menurut tipe</h3>

					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
						</button>
						<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
					</div>
				</div>
				<div class="card-body">
					<div class="chart">
						<canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
					</div>
				</div>
				<!-- /.card-body -->
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Table Admin</h3>

					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
						</button>
						<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-strip">
						<thead>
							<th>#</th>
							<th>Nama</th>
							<th>Jenis Kelamin</th>
							<th>Tanggal Lahir</th>
							<th>Alamat</th>
							<th>Action</th>
						</thead>
						<tbody>
							<?php foreach ($users as $key => $u) : ?>
								<tr>
									<td><?= $key + 1 ?></td>
									<td><?= $u->name ?></td>
									<td><?= $u->gender ?></td>
									<td><?= date_readable($u->birth_date) ?></td>
									<td><?= $u->address ?></td>
									<td><a href="<?= base_url('dashboard/del/' . $u->id) ?>" class="btn btn-xs btn-danger" onclick="return confirm('Anda yakin akan menghapus data ini?')">Delete</a></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="admin_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Tambahkan Admin</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('dashboard/new') ?>" method="POST">
				<div class="modal-body">
					<div class="form-group">
						<label for="name">Nama</label>
						<input id="name" name="name" placeholder="Masukan Nama" type="text" class="form-control" required="required">
					</div>
					<div class="form-group">
						<label for="address">Alamat</label>
						<textarea id="address" placeholder="Masukan Alamat" name="address" cols="40" rows="3" class="form-control" required="required"></textarea>
					</div>
					<div class="form-group">
						<label for="gender">Jenis Kelamin</label>
						<div>
							<select id="gender" name="gender" required="required" class="custom-select">
								<option value="">Pilih Jenis Kelamin</option>
								<option value="Male">Laki-Laki</option>
								<option value="Female">Perempuan</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="birth_date">Tanggal Lahir</label>
						<input id="birth_date" name="birth_date" placeholder="Masukan Tanggal Lahir" type="text" class="form-control" required="required" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask="" im-insert="false">
					</div>
					<div class="form-group">
						<label for="username">Username</label>
						<input id="username" name="username" placeholder="Masukan username" type="text" class="form-control" aria-describedby="usernameHelpBlock" required="required">
						<span id="usernameHelpBlock" class="form-text text-muted">Akan digunakan untuk login</span>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input id="password" name="password" minlength="8" placeholder="Masukan Password" type="password" class="form-control" required="required">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>

		</div>
	</div>
</div>


<script>
	$(document).ready(function() {
		$('#dashboard_menu').addClass('active')

		$('#trigger_modal').click(function() {
			$('#admin_modal').modal('show')
		})

		$('#birth_date').inputmask('yyyy-mm-dd', {
			'placeholder': 'yyyy-mm-dd'
		})

		$.get({
			url: "<?= base_url('dashboard/get_top_10') ?>",
			success: res => {
				let labels = []
				let data = []
				res.forEach(e => {
					labels.push(e.name)
					data.push(e.amount)
				});

				let ctx = $('#barChart').get(0).getContext('2d')
				let barChart = new Chart(ctx, {
					type: 'bar',
					data: {
						labels: labels,
						datasets: [{
							label: 'Donatur Tertinggi',
							data: data,
							backgroundColor: ['#e6194b', '#3cb44b', '#ffe119', '#4363d8', '#f58231', '#911eb4', '#46f0f0', '#f032e6', '#bcf60c', '#fabebe']
						}]
					},
					options: {
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero: true
								}
							}]
						}
					}
				})
			},
		})

		$.get({
			url: '<?= base_url('dashboard/get_by_type') ?>',
			success: res => {
				let labels = []
				let data = []
				res.forEach(e => {
					labels.push(e.type)
					data.push(e.amount)
				});

				let ctx = $('#pieChart').get(0).getContext('2d')
				let barChart = new Chart(ctx, {
					type: 'pie',
					data: {
						labels: labels,
						datasets: [{
							label: 'Tipe tertinggi',
							data: data,
							backgroundColor: ['#e6194b', '#3cb44b', '#ffe119', '#4363d8', '#f58231', '#911eb4', '#46f0f0', '#f032e6', '#bcf60c', '#fabebe']
						}]
					},
					options: {
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero: true
								}
							}]
						}
					}
				})
			}
		})
	})
</script>
