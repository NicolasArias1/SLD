<link rel="stylesheet" href="../../prints/css/admin_practices_edit.css">

<?php  if($body == 'new'){ ?>


	<form id="frmuser" name="frmuser" method="post" action="../../utilities/updateconfigp.mod.php " enctype="multipart/form-data">

	<div class="form-group row">
		<label class="col-sm-4 col-form-label">Estación:</label>
		<div class="col-sm-8 std">
			<input  id="sid" name="sid" type="text" class="form-control" placeholder="Estación"
				value="" autocomplete="off">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-4 col-form-label">Nombre corto:</label>
		<div class="col-sm-8 std">
			<input  id="pname" name="pname" type="text" class="form-control" placeholder="Nombre corto"
			value="" autocomplete="off">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-4 col-form-label">Nombre de la práctica:</label>
		<div class="col-sm-8 std">
			<input  id="pcname" name="pcname" type="text" class="form-control" placeholder="Nombre de la práctica"
			value=""autocomplete="off">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-4 col-form-label">Ubicación de la estación:</label>
		<div class="col-sm-8 std">
			<input  id="path" name="path" type="text" class="form-control" placeholder="Ubicación de la estación"
			value="" autocomplete="off">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-4 col-form-label">URL de la respuesta en la estación</label>
		<div class="col-sm-8 std">
			<input  id="stpath" name="stpath" type="text" class="form-control" placeholder="Ubicación de la estación"
			value="" autocomplete="off">
		</div>
	</div>

	<div class="form-group row" >
		<label class="col-sm-4 col-form-label">Tipo de práctica:</label>
		<div class="col-sm-8 std">
			<select id="type" name="type" class="form-select">
			<?php
					if(!$pdata['type'] || $pdata['type'] == 'Simulada') {
						?>
						<option value="Simulada">Simulada</option>
						<option value="Real">Real</option>
						<?php
					}//end if
					else {
						?>
						<option value="Real">Real</option>
						<option value="Simulada">Simulada</option>
						<?php
					}//end else if
				?>
			</select>
		</div>
	</div>

	<div class="form-group row" >
		<label class="col-sm-4 col-form-label">Carácter:</label>
		<div class="col-sm-8 std">
			<select id="visibilidad" name="visibilidad" class="form-select">
				<?php
					if(!$pdata['visibilidad'] || $pdata['visibilidad'] == 'Oculta') {
						?>
						<option value="oculta">Oculta</option>
						<option value="visible">Visible</option>
						<?php
					}//end if
					else {
						?>
						<option value="visible">Visible</option>
						<option value="oculta">Oculta</option>
						<?php
					}//end else if
				?>
			</select>
		</div>
	</div>

	<!-- Opción que hay que dejar funcional para próxima versión 
		

	-->


	<div class="form-group row secbtnGuardar">
				<input id="id" name="id" type="hidden" value="<?php echo $pdata['id']; ?>" />
				<input id="action" name="action" type="hidden" value="<?php echo $pdata['action']; ?>" />
				<input name="rpage" id="rpage" type="hidden" value="<?php echo $pdata['rpage']; ?>" />
				<input id="save"  name="save" type="submit" class="btnGuardar" value="Guardar"  disabled/>
	</div>

</form>

	
<?php }else{ ?>


	<form id="frmuser" name="frmuser" method="post" action="../../utilities/updateconfigp.mod.php " enctype="multipart/form-data">

	<div class="form-group row">
		<label class="col-sm-4 col-form-label">Estación:</label>
		<div class="col-sm-8 std">
			<input  id="sid" name="sid" type="text" class="form-control" placeholder="Estación"
				value="<?php echo $pdata['sid']; ?>" autocomplete="off">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-4 col-form-label">Nombre corto:</label>
		<div class="col-sm-8 std">
			<input  id="pname" name="pname" type="text" class="form-control" placeholder="Nombre corto"
			value="<?php echo $pdata['pname']; ?>"<?php echo isset($pdata['readonly']); ?>  autocomplete="off">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-4 col-form-label">Nombre de la práctica:</label>
		<div class="col-sm-8 std">
			<input  id="pcname" name="pcname" type="text" class="form-control" placeholder="Nombre de la práctica"
			value="<?php echo $pdata['pcname']; ?>"<?php echo isset($pdata['readonly']); ?>autocomplete="off">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-4 col-form-label">Ubicación de la estación:</label>
		<div class="col-sm-8 std">
			<input  id="path" name="path" type="text" class="form-control" placeholder="Ubicación de la estación"
			value="<?php echo $pdata['path']; ?>"<?php echo isset($pdata['readonly']); ?> autocomplete="off">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-4 col-form-label">URL de la respuesta en la estación</label>
		<div class="col-sm-8 std">
			<input  id="stpath" name="stpath" type="text" class="form-control" placeholder="Ubicación de la estación"
			value="<?php echo $pdata['stpath']; ?>"<?php echo isset($pdata['readonly']); ?> autocomplete="off">
		</div>
	</div>

	<div class="form-group row" >
		<label class="col-sm-4 col-form-label">Tipo de práctica:</label>
		<div class="col-sm-8 std">
			<select id="type" name="type" class="form-select">
			<?php
					if(!$pdata['type'] || $pdata['type'] == 'Simulada') {
						?>
						<option value="Simulada">Simulada</option>
						<option value="Real">Real</option>
						<?php
					}//end if
					else {
						?>
						<option value="Real">Real</option>
						<option value="Simulada">Simulada</option>
						<?php
					}//end else if
				?>
			</select>
		</div>
	</div>

	<div class="form-group row" >
		<label class="col-sm-4 col-form-label">Carácter:</label>
		<div class="col-sm-8 std">
			<select id="visibilidad" name="visibilidad" class="form-select">
				<?php
					if(!$pdata['visibilidad'] || $pdata['visibilidad'] == 'Oculta') {
						?>
						<option value="oculta">Oculta</option>
						<option value="visible">Visible</option>
						<?php
					}//end if
					else {
						?>
						<option value="visible">Visible</option>
						<option value="oculta">Oculta</option>
						<?php
					}//end else if
				?>
			</select>
		</div>
	</div>

	<!-- Opción que hay que dejar funcional para próxima versión 
		

	-->


	<div class="form-group row secbtnGuardar">
				<input id="id" name="id" type="hidden" value="<?php echo $pdata['id']; ?>" />
				<input id="action" name="action" type="hidden" value="<?php echo $pdata['action']; ?>" />
				<input name="rpage" id="rpage" type="hidden" value="<?php echo $pdata['rpage']; ?>" />
				<input id="save" name="save" type="submit" class="btnGuardar" value="Guardar" />
	</div>

</form>

	
<?php } ?>
