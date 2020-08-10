<div class="container">
	<div class="row">
		<div class="col-md-12">
			<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal">
				Tambahkan Donatur
			</button>
			<div class="card">
				<div class="card-header">
					Donatur Data
				</div>
				<div class="card-body">

					<table id="table" class="table table-bordered table-striped">
						<thead>
							<th>No</th>
							<th>Nama</th>
							<th>Jenis Kelamin</th>
							<th>Alamat</th>
							<th>Jumlah Donasi</th>
							<th>Action</th>
						</thead>
						<tbody>
							<?php foreach ($data as $key => $d) : ?>
								<tr>
									<td><?= $key + 1 ?></td>
									<td><?= $d->name ?></td>
									<td><?= $d->gender ?></td>
									<td><?= $d->address ?></td>
									<td><?= $d->amount_of_donation ?></td>
									<td><button class="btn btn-sm btn-info mx-1 edit" data-id="<?= $d->id ?>">Edit</button><a onclick="return confirm('Anda yakin akan menghapus data ini?')" href="<?= base_url('donator/delete/' . $d->id) ?>" class="btn btn-sm btn-danger">Delete</a></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Data Donatur</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form" action="<?= base_url('donator') ?>" method="POST">
				<div class="modal-body">
					<input type="hidden" id="id" name="id">
					<div class="form-group">
						<label for="name">Name</label>
						<input id="name" name="name" placeholder="Masukan Nama" type="text" required="required" class="form-control">
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
						<label for="address">Alamat</label>
						<textarea id="address" placeholder="Alamat" name="address" cols="40" rows="3" class="form-control" required="required"></textarea>
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
		$('#donatur_menu').addClass('active')

		$("#table").DataTable({
			"responsive": true,
			"autoWidth": false,
		})

		$('.edit').click(function() {
			let data = $(this).data('id')
			$.get({
				url: `<?= base_url('donator/getOne/') ?>${data}`,
				success: res => {
					$('#id').val(res.id)
					$('#name').val(res.name)
					$('#gender').val(res.gender)
					$('#address').val(res.address)
					$('#modal').modal('show')
				},
				error: err => {
					console.log(err)
				}
			})
		})

		$('#modal').on('hidden.bs.modal', function(e) {
			$('#id').val('')
			$('#form').trigger('reset')
		})
	})
</script>
