<form id="frmuser" name="frmuser" method="post" action="../../utilities/updateconfigp.mod.php " enctype="multipart/form-data">
	<table width="100%" cellpadding="0" cellspacing="0" class="form">
		<tr>
			<td width="240"><img src="../../img/aarrow.gif" alt="Obligatorio" /> Estaci&oacute;n:</td>
			<td><input id="sid" name="sid" type="text" class="input_field" size="40" value="<?php echo $pdata['sid']; ?>" autocomplete="off" /></td>
		</tr>
		<tr>
		  <td><img src="../../img/aarrow.gif" alt="Obligatorio" /> Nombre corto:</td>
		  <td><input id="pname" name="pname" type="text" class="input_field" size="13" value="<?php echo $pdata['pname']; ?>"<?php echo isset($pdata['readonly']); ?> autocomplete="off" /></td>
		</tr>
		<tr>
		  <td><img src="../../img/aarrow.gif" alt="Obligatorio" /> Nombre de la pr&aacute;ctica:</td>
		  <td><input id="pcname" name="pcname" type="text" class="input_field" size="25" value="<?php echo $pdata['pcname']; ?>"<?php echo isset($pdata['readonly']); ?> autocomplete="off" /></td>
		</tr>
		<tr>
		  <td><img src="../../img/aarrow.gif" alt="Obligatorio" /> Ubicaci&oacute;n en la estaci&oacute;n:</td>
		  <td><input id="path" name="path" type="text" class="input_field" size="25" value="<?php echo $pdata['path']; ?>"<?php echo isset($pdata['readonly']); ?> autocomplete="off" /></td>
		</tr>
		<tr>
		  <td><img src="../../img/aarrow.gif" alt="Obligatorio" /> URL de la respuesta en la estaci&oacute;n:</td>
		  <td><input id="stpath" name="stpath" type="text" class="input_field" size="25" value="<?php echo $pdata['stpath']; ?>"<?php echo isset($pdata['readonly']); ?> autocomplete="off" /></td>
		</tr>
		<tr>
		  <td><img src="../../img/aarrow.gif" alt="Obligatorio" /> Tipo de Pr&aacute;ctica:</td>
			<td>
				<select id="type" name="type" class="input_field">
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
			</td>
		</tr>
		<tr>
		  <td><img src="../../img/aarrow.gif" alt="Obligatorio" /> Visibilidad de la pr&aacute;ctica:</td>
			<td>
				<select id="visibilidad" name="visibilidad" class="input_field">
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
			</td>
		</tr>
		<tr>
		  <td>
				<input id="id" name="id" type="hidden" value="<?php echo $pdata['id']; ?>" />
				<input id="action" name="action" type="hidden" value="<?php echo $pdata['action']; ?>" />
				<input name="rpage" id="rpage" type="hidden" value="<?php echo $pdata['rpage']; ?>" />
			</td>
			<td><input id="save" name="save" type="submit" class="input_button" value="Guardar" /></td>
		</tr>
	</table>
</form>