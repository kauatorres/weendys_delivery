<?php
include('inc/navbar.php');
?>

<section>
	<div class="container py-5">
		<div class="row">
			<div class="col-lg-4">
				<div class="card mb-4">
					<div class="card-body text-center">
						<img src="http://i.imgur.com/T8ILvBp.png" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
						<h5 class="my-3"><?= $consultaCliente['nome'] . " " . $consultaCliente['sobrenome']; ?></h5>
						<?php
						switch ($consultaCliente['acesso']) {
							case 1:
								echo '<p class="text-white mb-1 badge bg-danger">Fundador</p>';
								break;
							case 2:
								echo '<p class="text-white mb-1 badge bg-dark">Co-Fundador</p>';
								break;
							case 3:
								echo '<p class="text-white mb-1 badge bg-success">Programador</p>';
								break;
							case 4:
								echo '<p class="text-white mb-1 badge bg-successProgramador">Suporte</p>';
								break;
							case 5:
								echo '<p class="text-white mb-1 badge bg-warning">Cliente VIP</p>';
								break;
							case 6:
								echo '<p class="text-white mb-1 badge bg-secondary">Cliente</p>';
								break;
							default:
								echo '<p class="text-white mb-1 badge bg-secondary">Cliente</p>';
								break;
						}
						?>
						<p class="text-muted mb-2">
							<?php
							$getEnd = explode("—", $consultaCliente['endereco']);
							echo $getEnd[1];
							?>
						</p>
						<div class="d-flex justify-content-center mb-2">
							<button href="#" data-bs-toggle="modal" data-bs-target="#editarPerfil" type="button" class="btn btn-primary" disabled>Editar dados (Indisponível)</button>
						</div>
					</div>
				</div>

				<div class="col-lg-12">
					<div class="">
						<div class="card-header">
							TOP 5 USUÁRIOS
						</div>
						<div class="">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th scope="col">#</th>
										<th scope="col">Nome</th>
										<th scope="col">Compras</th>
									</tr>
								</thead>
								<tbody>
									<tr class="text-center">
										<td>1</td>
										<td>Gabi Lima</td>
										<td>12 compras</td>
									</tr>

								</tbody>
							</table>
						</div>
					</div>
				</div>


			</div>
			<div class="col-lg-8">
				<div class="card mb-4">
					<div class="card-body">
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">Nome completo</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0"><?= $consultaCliente['nome'] . " " . $consultaCliente['sobrenome']; ?></p>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">Email</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0"><?= $consultaCliente['email']; ?></p>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">CPF</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0"><?= $consultaCliente['cpf']; ?></p>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">Celular</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0"><?= $consultaCliente['whatsapp']; ?></p>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-3">
								<p class="mb-0">Endereço</p>
							</div>
							<div class="col-sm-9">
								<p class="text-muted mb-0"><?= $consultaCliente['endereco']; ?> (<?= $consultaCliente['cep']; ?>)</p>
							</div>
						</div>
					</div>
				</div>
				<div class="row">

					<div class="col-lg-12">
						<h2 class="text-center">Pedidos</h2>
						<hr>
						<span class="listar-pedidos"></span>
					</div>


				</div>
			</div>
		</div>
	</div>
</section>


<?php if ($consultaCliente['acesso'] == 1) { ?>
	<!-- MODAL EDITAR PERFIL -->
	<div class="modal fade" id="editarPerfil" tabindex="-1" aria-labelledby="editarPerfil" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editarPerfil"><?= $consultaCliente['nome'] . " " . $consultaCliente['sobrenome']; ?></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form class="row g-3 needs-validation" novalidate>
						<div class="col-md-4">
							<label for="validationCustom01" class="form-label">Nome</label>
							<input type="text" class="form-control" id="validationCustom01" value="<?= $consultaCliente['nome']; ?>" required>
							<div class="invalid-feedback">
								Preencha este campo!
							</div>
						</div>
						<div class="col-md-4">
							<label for="validationCustom02" class="form-label">Sobrenome</label>
							<input type="text" class="form-control" id="validationCustom02" value="<?= $consultaCliente['sobrenome']; ?>" required>
							<div class="invalid-feedback">
								Preencha este campo!
							</div>
						</div>
						<div class="col-md-4">
							<label for="validationCustomUsername" class="form-label">Contato</label>
							<div class="input-group has-validation">
								<span class="input-group-text" id="inputGroupPrepend">+55</span>
								<input type="tel" class="form-control" id="validationCustomUsername" placeholder=" ..." value="<?= $consultaCliente['whatsapp']; ?>" required>
								<div class="invalid-feedback">
									Preencha este campo!
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<label for="validationCustom03" class="form-label">City</label>
							<input type="text" class="form-control" id="validationCustom03" required>
							<div class="invalid-feedback">
								Please provide a valid city.
							</div>
						</div>
						<div class="col-md-3">
							<label for="validationCustom04" class="form-label">State</label>
							<select class="form-select" id="validationCustom04" required>
								<option selected disabled value="">Choose...</option>
								<option>...</option>
							</select>
							<div class="invalid-feedback">
								Please select a valid state.
							</div>
						</div>
						<div class="col-md-3">
							<label for="validationCustom05" class="form-label">Zip</label>
							<input type="text" class="form-control" id="validationCustom05" required>
							<div class="invalid-feedback">
								Please provide a valid zip.
							</div>
						</div>
						<div class="col-12">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
								<label class="form-check-label" for="invalidCheck">
									Agree to terms and conditions
								</label>
								<div class="invalid-feedback">
									You must agree before submitting.
								</div>
							</div>
						</div>

					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>
<?php } ?>