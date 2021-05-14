<form id="frmuser" name="frmuser" method="post" action="../modules/updateusers.mod.php" enctype="multipart/form-data">
	<table width="100%" cellpadding="0" cellspacing="0" class="form">
	  <tr>
			<td width="85"><img src="../img/aarrow.gif" alt="Obligatorio" /> Nombre:</td>
		  <td><input id="name" name="name" type="text" class="input_field" size="40" value="<?php echo $usrdata['name']; ?>" autocomplete="off" /></td>
		</tr>
		<tr>
		  <td><img src="../img/aarrow.gif" alt="Obligatorio" /> Login:</td>
	    <td><input id="login" name="login" type="text" class="input_field" size="13" value="<?php echo $usrdata['login']; ?>"<?php echo isset($usrdata['readonly']); ?> autocomplete="off" /></td>
	  </tr>
	  <tr>
		  <td><img src="../img/aarrow.gif" alt="Obligatorio" /> EMail:</td>
	    <td><input id="mail" name="mail" type="text" class="input_field" size="25" value="<?php echo $usrdata['mail']; ?>"<?php echo isset($usrdata['readonly']); ?> autocomplete="off" /></td>
	  </tr>
	  <tr style="display:none;">
		  <td><img src="../img/aarrow.gif" alt="Obligatorio" /> Dominio:</td>
	    <td>
	    	<select id="domain" name="domain" class="input_field">
				<?php 
					if($usrdata['domain'] && $usrdata['domain'] != 'db') {
						echo "<option value=\"".$usrdata['domain']."\">".$usrdata['domain']."</option>";
					}//end if
					if(($usrdata['domain'] && $usrdata['domain'] == 'db') || DB_AUTH) {
						echo "<option value=\"db\">db</option>";
					}//end else if
				?>
				</select>
	    </td>
	  </tr>
	  <?php
		if($body == 'new' || ($body == 'edit' && $usrdata['domain'] == 'db' && $uid == $usrdata['id'])) {
			?>
		  <tr>
			  <td><img src="../img/aarrow.gif" alt="Obligatorio" /> Password:</td>
		    <td><input id="password" name="password" type="password" class="input_field" size="13" maxlength="12" autocomplete="off" /></td>
		  </tr>
		  <tr>
			  <td><img src="../img/aarrow.gif" alt="Obligatorio" /> Confirmar:</td>
		    <td><input id="confirm" name="confirm" type="password" class="input_field" size="13" maxlength="12" autocomplete="off" /></td>
		  </tr>
		  <?php
		}//end if
		?>
		<tr>
		  <td><img src="../img/aarrow.gif" alt="Obligatorio" /> Privilegio:</td>
	    <td>
	    	<label><input id="usuario" name="level" type="radio" value="3" class="form_radio" onClick="usersLevel(3)" />Estudiante&nbsp;&nbsp;&nbsp;</label>
			<label><input id="administrador" name="level" type="radio" value="1" class="form_radio" onClick="usersLevel(1)" />Administrador</label>
	    </td>
	  </tr>
	  <tr>
		  <td>
		  	<input id="id" name="id" type="hidden" value="<?php echo $usrdata['id']; ?>" />
				<input id="action" name="action" type="hidden" value="<?php echo $usrdata['action']; ?>" />
				<input id="type" name="type" type="hidden" value="<?php echo $usrdata['type']; ?>" />
				<input name="rpage" id="rpage" type="hidden" value="<?php echo $usrdata['rpage']; ?>" />
		  </td>
	    <td><input id="save" name="save" type="button" class="input_button" value="Guardar" onClick="saveUser('<?php echo $body; ?>')" /></td>
	  </tr>
	</table>
</form>