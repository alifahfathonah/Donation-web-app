<div class="container">
	<div class="row">
		<div class="col-md-12">
			<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal">
				Tambahkan Donasi
			</button>
			<div class="card">
				<div class="card-header">
					Data Donasi
				</div>
				<div class="card-body">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<th>No</th>
							<th>Tipe</th>
							<th>Deskripsi</th>
							<th>Tanggal</th>
							<th>Donatur</th>
							<th>Action</th>
						</thead>
						<tbody>
							<?php foreach ($donations as $key => $d) : ?>
								<tr>
									<td><?= $key + 1 ?></td>
									<td><?= $d->type ?></td>
									<td><?= $d->description ?></td>
									<td><?= date_readable($d->date, true) ?></td>
									<td><?= $d->name ?></td>
									<td><button class="btn btn-sm btn-info mx-1 edit" data-id="<?= $d->id ?>">Edit</button><a onclick="return confirm('Anda yakin akan menghapus data ini?')" href="<?= base_url('donation/delete/' . $d->id) ?>" class="btn btn-sm btn-danger">Delete</a></td>
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
				<h5 class="modal-title" id="exampleModalLabel">Data Donasi</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form" action="<?= base_url('donation') ?>" method="POST">
				<div class="modal-body">
					<input type="hidden" id="id" name="id">
					<div class="form-group">
						<label for="type">Tipe</label>
						<input id="type" list="list" name="type" placeholder="Masukan Tipe" required="required" class="form-control">
						<datalist id="list">
							<option value="Uang" />
							<option value="Sembako" />
							<option value="Baju" />
						</datalist>
					</div>
					<div class="form-group">
						<label for="description">Deskripsi</label>
						<textarea id="description" placeholder="Masukan Detail. Contoh: Uang Rp100.000 atau Baju selusin, dll" name="description" cols="40" rows="3" class="form-control" required="required"></textarea>
					</div>
					<div class="form-group">
						<label for="donatur">Donatur</label> <a class="btn btn-primary btn-xs ml-2" href="<?= base_url('donator') ?>">Tambahkan Baru</a>

						<div>
							<select id="donator" name="donator" class="custom-select" required="required">
								<option value="">Pilih Donatur</option>
								<?php foreach ($donators as $d) : ?>
									<option value="<?= $d->id ?>"><?= $d->name ?></option>
								<?php endforeach ?>
							</select>
						</div>
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
		$('#donation_menu').addClass('active')

		$("#table").DataTable({
			"responsive": true,
			"autoWidth": false,
		})

		$('.edit').click(function() {
			let data = $(this).data('id')
			$.get({
				url: `<?= base_url('donation/getOne/') ?>${data}`,
				success: res => {
					$('#id').val(res.id)
					$('#type').val(res.type)
					$('#description').val(res.description)
					$('#donator').val(res.donator)
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
