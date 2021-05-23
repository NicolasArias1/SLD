<form id="mysql" name="mysql" method="post" action="../utilities/updateconfiguration.mod.php " enctype="multipart/form-data">
	<table width="100%" cellpadding="0" cellspacing="0" class="form">
		<tr>
			<td width="30%"><img src="../img/aarrow.gif" alt="Obligatorio" /> Nombre / Direcci&oacute;n IP:</td>
			<td><input id="server" name="server" type="text" class="input_field" size="25" value="<?php echo $mysql['server']; ?>" /></td>
		</tr>
		<tr>
			<td width="30%"><img src="../img/aarrow.gif" alt="Obligatorio" /> Usuario:</td>
			<td><input id="user_name" name="user_name" type="text" class="input_field" size="25" value="<?php echo $mysql['user']; ?>" /></td>
		</tr>
		<tr>
			<td width="30%"><img src="../img/aarrow.gif" alt="Obligatorio" /> Password:</td>
			<td><input id="user_password" name="user_password" type="password" class="input_field" size="25" value="<?php echo $mysql['passwd']; ?>" /></td>
		</tr>
		<tr>
			<td width="30%"><img src="../img/aarrow.gif" alt="Obligatorio" /> Nombre Base de Datos:</td>
			<td><input id="db_name" name="db_name" type="text" class="input_field" size="25" value="<?php echo $mysql['db']; ?>" /></td>
		</tr>
		<tr>
			
			<td><input id="action" name="action" type="hidden" value="mysql" /></td>
			<td><input id="save" name="save" type="button" class="input_button" value="Guardar" onclick="validMySQLServer()" /></td>
		</tr>
  </table>
</form>
<?php
	if($ldapalert) {
		?>
		<p class="alert"><?php echo $atxt; ?></p>
		<?
	}//end if
?>
<p class="header">Servidor LDAP</p>
<form id="ldap" name="ldap" method="post" action="../utilities/updateconfiguration.mod.php" enctype="multipart/form-data">
	<table width="100%" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td width="30%"><img src="../img/aarrow.gif" alt="Obligatorio" /> Nombre / Direcci&oacute;n IP:</td>
		<td><input id="server" name="server" type="text" class="input_field" size="25" value="<?php echo $ldap['server']; ?>" /></td>
	</tr>
	<tr>
		<td width="30%"><img src="../img/aarrow.gif" alt="Obligatorio" /> Puerto:</td>
		<td><input id="port" name="port" type="text" class="input_field" size="13" value="<?php echo $ldap['port']; ?>" /></td>
	</tr>
	<tr>
		<td width="30%"><img src="../img/aarrow.gif" alt="Obligatorio" /> Base DN:</td>
		<td><input id="dn" name="dn" type="text" class="input_field" size="25" value="<?php echo $ldap['dn']; ?>" /></td>
	</tr>
	<tr>
		
		<td><input id="action" name="action" type="hidden" value="ldap" /></td>
		<td><input id="save" name="save" type="button" class="input_button" value="Guardar" onclick="validLDAPServer()" /><td>
	</tr>
</table>
</form>
