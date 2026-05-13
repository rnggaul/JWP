<div class="content-wrapper">
	<div class="row">
		<div class="col-md-12 grid-margin">
			<div class="row">
				<div class="col-12 col-xl-8 mb-4 mb-xl-0">
					<h3 class="font-weight-bold">Laporan Pesanan</h3>
					<h6 class="font-weight-normal mb-0">JeWePe Wedding Organizer</h6>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-lg-6">
							<h4 class="card-title">Filter Laporan</h4>
						</div>
					</div>

					<form method="post" action="">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="start_date">Tanggal Mulai</label>
									<input type="date" class="form-control" id="start_date" name="start_date" value="<?= $this->input->post('start_date') ?>" required>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="end_date">Tanggal Akhir</label>
									<input type="date" class="form-control" id="end_date" name="end_date" value="<?= $this->input->post('end_date') ?>" required>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>&nbsp;</label>
									<button type="submit" class="btn btn-primary btn-block">Filter</button>
								</div>
							</div>
						</div>
					</form>

					<div class="table-responsive pt-3">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th class="text-center">No</th>
									<th class="text-center">Gambar</th>
									<th class="text-center">Nama Paket</th>
									<th class="text-center">Nama Pemesan</th>
									<th class="text-center">Email Pemesan</th>
									<th class="text-center">Tanggal Pernikahan</th>
									<th class="text-center">Status</th>
									<th class="text-center">Tanggal Pesan</th>
								</tr>
							</thead>
							<tbody>
								<?php if (empty($getAllOrders)): ?>
									<tr>
										<td colspan="8" class="text-center">Tidak ada data pesanan</td>
									</tr>
								<?php else: ?>
									<?php $no = 1; foreach ($getAllOrders as $order): ?>
										<tr>
											<td class="text-center"><?= $no++; ?></td>
											<td class="text-center">
												<?php if (!empty($order->image)): ?>
													<a href="<?= base_url('assets/files/katalog/' . $order->image); ?>" target="_blank">
														<img src="<?= base_url('assets/files/katalog/' . $order->image); ?>" class="img-fluid" style="border-radius:10%;width:60px;height:60px" alt="<?= $order->package_name; ?>">
													</a>
												<?php else: ?>
													<img src="<?= base_url('assets/landing/img/no-image.jpg'); ?>" class="img-fluid" style="border-radius:10%;width:60px;height:60px" alt="No Image">
												<?php endif; ?>
											</td>
											<td><?= $order->package_name; ?></td>
											<td class="text-center"><?= $order->name; ?></td>
											<td class="text-center"><?= $order->email; ?></td>
											<td class="text-center"><?= date('d-m-Y', strtotime($order->wedding_date)); ?></td>
											<td class="text-center">
												<?php if (in_array($order->status, ['requested', 'menunggu', 'pending'])): ?>
													<span class="badge badge-primary">Menunggu Konfirmasi</span>
												<?php elseif (in_array($order->status, ['accepted', 'diterima'])): ?>
													<span class="badge badge-success">Diterima</span>
												<?php elseif (in_array($order->status, ['cancelled', 'dibatalkan'])): ?>
													<span class="badge badge-danger">Dibatalkan</span>
												<?php else: ?>
													<span class="badge badge-secondary"><?= ucfirst($order->status); ?></span>
												<?php endif; ?>
											</td>
											<td class="text-center"><?= date('d-m-Y H:i', strtotime($order->created_at)); ?></td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
							</tbody>
						</table>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
