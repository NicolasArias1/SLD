	<link rel="stylesheet" href="../../prints/css/admin_users.css">



	<?php

	$tipoU = '';
	if($this->nresults && $this->results[0]['id']) {
		?>



	<div class="row" style="margin-bottom:10px;">
		<div class="col-md-6">
			<a style="text-decoration: none;margin:0;color: whitesmoke; font-size: 13px;" href="/modules/admin/users.php?body=new">
				<div class="btnAdduser">
					<i class="fas fa-user-plus"></i><p style="margin:0;">Agregar usuario</p> 
				</div>
			</a>
		</div>
		
		<!--
		<div class="col-md-6">                
		<li id="list_order" onmouseover="showOptions(this.id, 'list_order_option')" onmouseout="hideOptions(this.id, 'list_order_option')">&nbsp;<strong>Ordenar<br /></strong>
							<ul id="list_order_option">
								<li id="order_element1" class="list_element" onmouseover="colorOverElement(this.id)" onmouseout="colorOutElement(this.id)" onclick="schPreferences('users.php', '<?php echo $this->url; ?>', 'id', '<?php echo $this->show; ?>', '<?php echo $this->idfocus; ?>')">por ID</li>
								<li id="order_element2" class="list_element" onmouseover="colorOverElement(this.id)" onmouseout="colorOutElement(this.id)" onclick="schPreferences('users.php', '<?php echo $this->url; ?>', 'name', '<?php echo $this->show; ?>', '<?php echo $this->idfocus; ?>')">por Nombre</li>
								<li id="order_element3" class="list_element" onmouseover="colorOverElement(this.id)" onmouseout="colorOutElement(this.id)" onclick="schPreferences('users.php', '<?php echo $this->url; ?>', 'login', '<?php echo $this->show; ?>', '<?php echo $this->idfocus; ?>')">por Login</li>
								<li id="order_element4" class="list_element" onmouseover="colorOverElement(this.id)" onmouseout="colorOutElement(this.id)" onclick="schPreferences('users.php', '<?php echo $this->url; ?>', 'level', '<?php echo $this->show; ?>', '<?php echo $this->idfocus; ?>')">por Privilegio</li>
							</ul>
						</li>
		</div>
	-->
		<!-- 
		<div class="col-md-6">
					<ul id="menu_list_box">
	

						<li id="list_order" onmouseover="showOptions(this.id, 'list_order_option')" onmouseout="hideOptions(this.id, 'list_order_option')">&nbsp;<strong>Ordenar<br /></strong>
							<ul id="list_order_option">
								<li id="order_element1" class="list_element" onmouseover="colorOverElement(this.id)" onmouseout="colorOutElement(this.id)" onclick="schPreferences('users.php', '<?php echo $this->url; ?>', 'id', '<?php echo $this->show; ?>', '<?php echo $this->idfocus; ?>')">por ID</li>
								<li id="order_element2" class="list_element" onmouseover="colorOverElement(this.id)" onmouseout="colorOutElement(this.id)" onclick="schPreferences('users.php', '<?php echo $this->url; ?>', 'name', '<?php echo $this->show; ?>', '<?php echo $this->idfocus; ?>')">por Nombre</li>
								<li id="order_element3" class="list_element" onmouseover="colorOverElement(this.id)" onmouseout="colorOutElement(this.id)" onclick="schPreferences('users.php', '<?php echo $this->url; ?>', 'login', '<?php echo $this->show; ?>', '<?php echo $this->idfocus; ?>')">por Login</li>
								<li id="order_element4" class="list_element" onmouseover="colorOverElement(this.id)" onmouseout="colorOutElement(this.id)" onclick="schPreferences('users.php', '<?php echo $this->url; ?>', 'level', '<?php echo $this->show; ?>', '<?php echo $this->idfocus; ?>')">por Privilegio</li>
							</ul>
						</li>
						<li id="list_show" onmouseover="showOptions(this.id, 'list_show_option')" onmouseout="hideOptions(this.id, 'list_show_option')">&nbsp;<strong>Mostrar<br /></strong>
							<ul id="list_show_option">
								<?php
								for($i=1; $i <= $this->nshow; $i++) {
									?>
									<li id="show_element<?php echo $i; ?>" class="list_element" onmouseover="colorOverElement(this.id)" onmouseout="colorOutElement(this.id)" onclick="schPreferences('users.php', '<?php echo $this->url; ?>', '<?php echo $this->order[0]; ?>', <?php echo $i*20; ?>, '<?php echo $this->idfocus; ?>')"><?php echo $i*20; ?> Usuarios</li>
									<?php
								}//end for
								?>
							</ul>
						</li>
					</ul>
		</div>
-->
	</div>


	<table class="table table-bordered table-hover tsize">

		<thead>
			<tr class="bg-dark">
				<th class="col-sm-1" scope="col">N°</th>
				<th class="col-sm-4" scope="col">Usuario</th>
				<th class="col-sm-3" scope="col">Rol</th>
				<th class="col-sm-1" scope="col">Acción</th>
			</tr>
		</thead>
		<?php

					for($i=0; $i < $this->limits[1]; $i++) {
						if($this->results[$i]['id']) {
							if($this->results[$i]['level'] == 1){
								$tipoU = "Administrador";
								$level = "Administrador";
							}	
							else if($this->results[$i]['level'] == 2){
								$tipoU = "Profesor";
								$level = "Operador";
							}
							
							else{
								$tipoU = "Estudiante";
								$level = "Usuario";
							}
								
							?>



		<tbody>


			<tr id="resource_<?php  echo ($i+1); ?>" onmouseover="colorOver(<?php echo ($i+1); ?>)"
				onmouseout="colorOut(<?php echo ($i+1); ?>)" onclick="selectResource(<?php echo ($i+1); ?>)">

				<td> <?php echo $i+1;  ?></td>


				<td
					title="Login: <?php echo $this->results[$i]['login']."\nDominio: ".$this->results[$i]['domain']."\nEMail: ".$this->results[$i]['mail']."\nPrivilegio: ".$level; ?>">
					<?php if($this->results[$i]['status'] == 'outline' || $this->results[$i]['id'] == $this->uid) { ?>
					<a href="users.php?body=edit&rbody=<?php echo $this->body; ?>&order=<?php echo $this->order[0]; ?>&show=<?php echo $this->show; ?>&page=<?php echo $this->page; ?>&id=<?php echo $this->results[$i]['id']; ?>"
						class="ast4 atable"><?php echo tildes($this->results[$i]['name']); ?></a>
					<?php
									}//end if
									else {
										echo "<strong>".tildes($this->results[$i]['name'])."</strong>";
									}//end else
									
									if($this->order[0] == 'login') {
					?>
					<br />
					<p class="adinfo"><strong>Login:</strong> <?php echo $this->results[$i]['login']; ?></p>
					<?php
									}//end if
									if($this->order[0] == 'level') {
										?>
					<br />
					<p class="adinfo"><strong>Privilegio:</strong> <?php echo $level; ?></p>
					<?php
									}//end if
									?>
					<p class="adinfo"><a href="mailto:<?php echo $this->results[$i]['mail']; ?>" class="ast5"
							onclick="selectResource(<?php echo ($i+1); ?>)"><?php echo $this->results[$i]['mail']; ?></a>
					</p>
				</td>

				<td><?php echo $tipoU ?></td>

				<td>

					<a style="text-decoration:none;"
						href="users.php?body=edit&rbody=<?php echo $this->body; ?>&order=<?php echo $this->order[0]; ?>&show=<?php echo $this->show; ?>&page=<?php echo $this->page; ?>&id=<?php echo $this->results[$i]['id']; ?>"
						onclick="selectResource(<?php echo ($i+1); ?>)">
						<i class="fas fa-user-edit uedit"></i>
					</a>
					<a style="text-decoration:none;"
						href="javascript:deleteUsers(<?php echo $this->results[$i]['id']; ?>, 1, '<?php echo $this->body; ?>', '<?php echo $this->order[0]; ?>', <?php echo $this->show; ?>, <?php echo $this->page; ?>)"
						onclick="selectResource(<?php echo ($i+1); ?>)"><i class="fas fa-trash udel"></i>
					</a>

				</td>

			</tr>

		</tbody>

		<?php
				}//end if
			}//end for
			if($this->paginate) {			
				?>
		<tr>
			<td colspan="5">
				<p class="paginator"><?php echo $this->paginate; ?></p>
			</td>
		</tr>
		<?php
			}//end if
			?>


	</table>



	<div class="row">
		<div class="results_info">
			<?php echo $this->message; ?>

		</div>
	</div>



	<?php
		}//end if
		else if($this->num && !$this->results[0]['id']) {
			if($this->page != 1)
				header('Location: '.$_SERVER[PHP_SELF].'?body='.$this->body.'&page='.($this->page-1));
			else
				header('Location: '.$_SERVER[PHP_SELF].'?body='.$this->body);
		}//end else if
?>