<div class="page-wrapper">
	<div class="content container-fluid">

		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col">
					<h3 class="page-title">Roles & Permissions</h3>
				</div>
				<div class="col-auto text-right">
					<a href="<?php echo base_url(); ?>roles" class="btn btn-primary add-button"><i class="fas fa-sync"></i></a>

					<a href="<?php echo base_url(); ?>add-roles" class="btn btn-primary add-button"><i class="fas fa-plus"></i></a>

				</div>
			</div>
		</div>
		<!-- /Page Header -->

		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-hover table-center mb-0 categories_table" id="categories_table">
								<thead>
									<tr>
										<th>#</th>
										<th>Role Name</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$i = 1;
									if (!empty($roles)) {
										foreach ($roles as $rows => $value) {


									?>
											<tr>
												<td><?php echo $i++; ?></td>
												<td><?php echo $value['sq_role_name']; ?></td>
												<td>
													<a href="<?php echo base_url(); ?>admin/edit-roles-permissions/<?php echo $value['sq_roles_id']; ?>" class="btn btn-sm bg-success-light mr-2">
														<i class="far fa-edit mr-1"></i>
													</a>
													<a href="javascript:;" class="on-default remove-row btn btn-sm bg-danger-light mr-2 delete_roles" id="Onremove_'.$value['sq_roles_id'].'" data-id="<?php echo $value['sq_roles_id']; ?>"><i class="far fa-trash-alt mr-1"></i>
													</a>
												</td>
											</tr>
									<?php }
									} ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>