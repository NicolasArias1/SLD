<div class="results_info">
	<?php echo $this->message; ?>
</div>
<?php 
	if($this->nresults && $this->results[0]['id']) {
		?>
		<table width="100%" cellpadding="0" cellspacing="0" class="results">
			<tr>
				<td colspan="5" class="menu">
					<ul id="menu_list_box">
						<li id="list_select" onmouseover="showOptions(this.id, 'list_select_option')" onmouseout="hideOptions(this.id, 'list_select_option')">&nbsp;<strong>Seleccionar<br /></strong>
							<ul id="list_select_option">
								<li id="select_element1" class="list_element" onmouseover="colorOverElement(this.id)" onmouseout="colorOutElement(this.id)" onclick="checkAll(true, <?php echo $this->limits[1]; ?>, 'list_select', 'list_select_option')">Todos</li>
								<li id="select_element2" class="list_element" onmouseover="colorOverElement(this.id)" onmouseout="colorOutElement(this.id)" onclick="checkAll(false, <?php echo $this->limits[1]; ?>, 'list_select', 'list_select_option')">Ninguno</li>
							</ul>
						</li>
						<li id="list_operation" onmouseover="showOptions(this.id, 'list_operation_option')" onmouseout="hideOptions(this.id, 'list_operation_option')">&nbsp;<strong>Operaciones<br /></strong>
							<ul id="list_operation_option">
								<li id="operation_element1" class="list_element" onmouseover="colorOverElement(this.id)" onmouseout="colorOutElement(this.id)" onclick="deleteArea('*', <?php echo $this->limits[1]; ?>, '<?php echo $this->order[0]; ?>', <?php echo $this->show; ?>, <?php echo $this->page; ?>)">Eliminar</li>
							</ul>
						</li>
						<li id="list_order" onmouseover="showOptions(this.id, 'list_order_option')" onmouseout="hideOptions(this.id, 'list_order_option')">&nbsp;<strong>Ordenar<br /></strong>
							<ul id="list_order_option">
								<li id="order_element1" class="list_element" onmouseover="colorOverElement(this.id)" onmouseout="colorOutElement(this.id)" onclick="schPreferences('configuration.php', '<?php echo $this->url; ?>', 'id', '<?php echo $this->show; ?>', '')">por ID</li>
								<li id="order_element2" class="list_element" onmouseover="colorOverElement(this.id)" onmouseout="colorOutElement(this.id)" onclick="schPreferences('configuration.php', '<?php echo $this->url; ?>', 'name', '<?php echo $this->show; ?>', '')">por Nombre</li>
							</ul>
						</li>
						<li id="list_show" onmouseover="showOptions(this.id, 'list_show_option')" onmouseout="hideOptions(this.id, 'list_show_option')">&nbsp;<strong>Mostrar<br /></strong>
							<ul id="list_show_option">
								<?php
								for($i=1; $i <= $this->nshow; $i++) {
									?>
									<li id="show_element<?php echo $i; ?>" class="list_element" onmouseover="colorOverElement(this.id)" onmouseout="colorOutElement(this.id)" onclick="schPreferences('configuration.php', '<?php echo $this->url; ?>', '<?php echo $this->order[0]; ?>', <?php echo $i*20; ?>, '')"><?php echo $i*10; ?> Grupos</li>
									<?php
								}//end for
								?>
							</ul>
						</li>
					</ul>
				</td>
			</tr>
		<?php
		for($i=0; $i<$this->limits[1]; $i++) {
			if($this->results[$i]['name']) {
				?>
					<tr class="resource_box" id="resource_<?php echo ($i+1); ?>" onmouseover="colorOver(<?php echo ($i+1); ?>)" onmouseout="colorOut(<?php echo ($i+1); ?>)" onclick="selectResource(<?php echo ($i+1); ?>)">
						<td width="20px" class="check"><input type="checkbox" id="<?php echo ($i+1); ?>" name="<?php echo ($i+1); ?>" value="<?php echo $this->results[$i]['id']; ?>" class="input_checkbox" onclick="selectResource(<?php echo ($i+1); ?>)" /></td>
						<td width="535px" class="text">
							<a href="#area_categories" class="ast4" onclick="editArea(<?php echo $this->results[$i]['id']; ?>, <?php echo ($i+1); ?>, '<?php echo $this->results[$i]['name']; ?>', '<?php echo $this->results[$i]['description']; ?>')"><?php echo $this->results[$i]['name']; ?></a> <?php if($this->results[$i]['description']) { ?><span class="text">(<?php echo $this->results[$i]['description']; ?>)</span><?php }//end if ?>
							<p class="adinfo"><strong>Usuarios: </strong><?php echo $this->results[$i]['items']; ?></p>
						</td>
						<td width="20px" class="image"><a href="#area_categories" onclick="editArea(<?php echo $this->results[$i]['id']; ?>, <?php echo ($i+1); ?>, '<?php echo $this->results[$i]['name']; ?>', '<?php echo $this->results[$i]['description']; ?>')"><img src="../img/edit.gif" alt="Editar" vspace="2" border="0" /></a></td>
						<td width="20px" class="image"><a href="javascript:deleteArea(<?php echo $this->results[$i]['id']; ?>, 1, '<?php echo $this->order[0]; ?>', <?php echo $this->show; ?>, <?php echo $this->page; ?>)" onclick="selectResource(<?php echo ($i+1); ?>)"><img src="../img/del.gif" alt="Eliminar" vspace="2" border="0" /></a></td>
					</tr>
				<?php	
			}//end if				
		}//end for
		if($this->paginate) {			
			?>
			<tr>
				<td colspan="4">
					<p class="paginator"><?php echo $this->paginate; ?></p>
				</td>
			</tr>
			<?php
		}//end if
		?>
		</table>
		<?php
	}//end if
	else if($this->nresults && !$this->results[0]['id']) {
		if($this->page != 1)
			header('Location: '.$_SERVER[PHP_SELF].'?body='.$this->body.'&page='.($this->page-1));
		else
			header('Location: '.$_SERVER[PHP_SELF].'?body='.$this->body);
	}//end else if
	?>