<link rel="stylesheet" href="../../prints/css/admin_users_edit.css">

<?php  if($body == 'new'){ ?>

	<form id="frmuser" name="frmuser" method="post" action="../../utilities/updateusers.mod.php "
	enctype="multipart/form-data">

	<div class="form-group row">
		<label class="col-sm-4 col-form-label">Nombre:</label>
		<div class="col-sm-8 std">
			<input id="name" name="name" type="text" class="form-control" placeholder="Nombre"
				value="" autocomplete="off">
		</div>
	</div>
   
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">Username:</label>
		<div class="col-sm-8 std">
			<input id="login" name="login" type="text" class="form-control" placeholder="Username"
				value="" autocomplete="off">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-4 col-form-label">Email:</label>
		<div class="col-sm-8 std">
			<input id="mail" name="mail" type="email" class="form-control" placeholder="Email"
				value=""  autocomplete="off">
		</div>
	</div>

	<div class="form-group row" style="display:none;">
		<label class="col-sm-4 col-form-label">Dominio:</label>
		<div class="col-sm-8 std">
			<select id="domain" name="domain" class="form-select">
				<?php 
					if($usrdata['domain'] && $usrdata['domain'] != 'db') {
						echo "<option value=\"".$usrdata['domain']."\">".$usrdata['domain']."</option>";
					}//end if
					if(($usrdata['domain'] && $usrdata['domain'] == 'db') || DB_AUTH) {
						echo "<option value=\"db\">db</option>";
					}//end else if
				?>
			</select>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-4 col-form-label">Contraseña:</label>
		<div class="col-sm-8 std">
			<input id="password" name="password" type="password" class="form-control" size="13" maxlength="12"
				autocomplete="off" placeholder="Password">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-4 col-form-label">Confirmar contraseña:</label>
		<div class="col-sm-8 std">
			<input id="confirm" name="confirm" type="password" class="form-control" size="13" maxlength="12"
				autocomplete="off" placeholder="Confirmar">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-4 col-form-label">Rol:</label>
		<div class="col-sm-8 std">
			<label class="form-check-label"><input id="usuario" name="level" type="radio" value="3"
					class="form-check-input" onClick="usersLevel(3)" />Estudiante&nbsp;&nbsp;&nbsp;</label>
			<label class="form-check-label"><input id="administrador" name="level" type="radio" value="1"
					class="form-check-input" onClick="usersLevel(1)" />Administrador</label>
			<label class="form-check-label"><input id="operador" name="level" type="radio" value="2"
					class="form-check-input" onClick="usersLevel(2)" />Profesor</label>
		</div>
	</div>

	<div class="form-group row secbtnGuardar">

		<input id="id" name="id" type="hidden" value="<?php echo $usrdata['id']; ?>" />
		<input id="action" name="action" type="hidden" value="<?php echo $usrdata['action']; ?>" />
		<input id="type" name="type" type="hidden" value="<?php echo $usrdata['type']; ?>" />
		<input name="rpage" id="rpage" type="hidden" value="<?php echo $usrdata['rpage']; ?>" />
		<input id="save" name="save" type="button" class="btnGuardar" value="Guardar"
			onClick="saveUser('<?php echo $body; ?>')" />
	</div>

</form>




<?php }else{ ?>

	<form id="frmuser" name="frmuser" method="post" action="../../utilities/updateusers.mod.php "
	enctype="multipart/form-data">

	<div class="form-group row">
		<label class="col-sm-4 col-form-label">Nombre:</label>
		<div class="col-sm-8 std">
			<input id="name" name="name" type="text" class="form-control" placeholder="Nombre"
				value="<?php echo $usrdata['name']; ?>" autocomplete="off">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-4 col-form-label">Username:</label>
		<div class="col-sm-8 std">
			<input id="login" name="login" type="text" class="form-control" placeholder="Username"
				value="<?php echo $usrdata['login']; ?>" <?php echo isset($usrdata['readonly']); ?> autocomplete="off">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-4 col-form-label">Email:</label>
		<div class="col-sm-8 std">
			<input id="mail" name="mail" type="email" class="form-control" placeholder="Email"
				value="<?php echo $usrdata['mail']; ?>" <?php echo isset($usrdata['readonly']); ?> autocomplete="off">
		</div>
	</div>

	<div class="form-group row" style="display:none;">
		<label class="col-sm-4 col-form-label">Dominio:</label>
		<div class="col-sm-8 std">
			<select id="domain" name="domain" class="form-select">
				<?php 
					if($usrdata['domain'] && $usrdata['domain'] != 'db') {
						echo "<option value=\"".$usrdata['domain']."\">".$usrdata['domain']."</option>";
					}//end if
					if(($usrdata['domain'] && $usrdata['domain'] == 'db') || DB_AUTH) {
						echo "<option value=\"db\">db</option>";
					}//end else if
				?>
			</select>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-4 col-form-label">Contraseña:</label>
		<div class="col-sm-8 std">
			<input id="password" name="password" type="password" class="form-control" size="13" maxlength="12"
				autocomplete="off" placeholder="Password">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-4 col-form-label">Confirmar contraseña:</label>
		<div class="col-sm-8 std">
			<input id="confirm" name="confirm" type="password" class="form-control" size="13" maxlength="12"
				autocomplete="off" placeholder="Confirmar">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-4 col-form-label">Rol:</label>
		<div class="col-sm-8 std">
			<label class="form-check-label"><input id="usuario" name="level" type="radio" value="3"
					class="form-check-input" onClick="usersLevel(3)" />Estudiante&nbsp;&nbsp;&nbsp;</label>
			<label class="form-check-label"><input id="administrador" name="level" type="radio" value="1"
					class="form-check-input" onClick="usersLevel(1)" />Administrador</label>
			<label class="form-check-label"><input id="operador" name="level" type="radio" value="2"
					class="form-check-input" onClick="usersLevel(2)" />Profesor</label>
		</div>
	</div>

	<div class="form-group row secbtnGuardar">

		<input id="id" name="id" type="hidden" value="<?php echo $usrdata['id']; ?>" />
		<input id="action" name="action" type="hidden" value="<?php echo $usrdata['action']; ?>" />
		<input id="type" name="type" type="hidden" value="<?php echo $usrdata['type']; ?>" />
		<input name="rpage" id="rpage" type="hidden" value="<?php echo $usrdata['rpage']; ?>" />
		<input id="save" name="save" type="button" class="btnGuardar" value="Guardar"
			onClick="saveUser('<?php echo $body; ?>')" />
	</div>

</form>

<?php } ?>




