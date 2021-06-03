<link rel="stylesheet" href="../../prints/css/admin_practices.css">



<?php
	if($this->nresults && $this->results[0]['id']) {
		?>



<div class="row d-flex justify-content-between" style="margin-bottom:10px;">
	<div class="col-md-6">
		<a style="text-decoration: none;margin:0;color: whitesmoke; font-size: 13px;"
			href="/modules/admin/configp.php?body=new">
			<div class="btnAdduser">
				<i class="fas fa-plus"></i>
				<p style="margin:0;">Agregar práctica</p>
			</div>
		</a>
	</div>

	<div id="mostrarB" class="col-md-6 dropdown">
			<button  style="font-size:13px !important;" class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Mostrar
			</button>
			<div class="dropdown-menu"  style="font-size:13px !important;" aria-labelledby="dropdownMenuButton">
					<?php
								for($i=1; $i <= $this->nshow; $i++) {
									?>
						<li id="show_element<?php echo $i; ?>" class="list_element"
							onmouseover="colorOverElement(this.id)" onmouseout="colorOutElement(this.id)"
							onclick="schPreferences('configp.php', '<?php echo $this->url; ?>', '<?php echo $this->order[0]; ?>', <?php echo $i*10; ?>, '<?php echo $this->idfocus; ?>')">
							<?php echo $i*10; ?> Pr&aacute;cticas</li>
						<?php
								}//end for
								?>
			</div>
	</div>

</div>

<div class="col-md-6 results_info ">
			<?php echo $this->message; ?>

		</div>

<table class="table table-bordered table-hover tsize">

	<tr class="bg-dark">
		<th class="col-sm-1" scope="col">N°</th>
		<th class="col-sm-8" scope="col">Práctica</th>
		<th class="col-sm-1" scope="col">Acción</th>
	</tr>


	<tbody>


		<?php
				for($i=0; $i < $this->limits[1]; $i++) {
					if($this->results[$i]['id']) {
						?>	
		<tr id="resource_<?php echo ($i+1); ?>" onmouseover="colorOver(<?php echo ($i+1); ?>)"
			onmouseout="colorOut(<?php echo ($i+1); ?>)" onclick="selectResource(<?php echo ($i+1); ?>)">

			<!--<td width="20px" class="check"><input type="checkbox" id="<?php echo ($i+1); ?>"
					name="<?php echo ($i+1); ?>" value="<?php echo $this->results[$i]['pcname']; ?>"
					class="input_checkbox" onclick="selectResource(<?php echo ($i+1); ?>)" /></td>-->

					<td> <?php echo $i+1;  ?></td>


					<td title="Practica: <?php echo $this->results[$i]['pname']."\nTipo: ".$this->results[$i]['type']; ?>">
								<a  style="text-decoration:none;" href="configp.php?body=edit&rbody=<?php echo $this->body; ?>&order=<?php echo $this->order[0]; ?>&show=<?php echo $this->show; ?>&page=<?php echo $this->page; ?>&id=<?php echo $this->results[$i]['id']; ?>" class="ast4"><?php echo tildes($this->results[$i]['pcname']); ?></a>
								<?php
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
								<p class="adinfo"><a><?php echo $this->results[$i]['type']; ?></a></p>
						</td>


						<?php
							 	if($this->results[$i]['sid'] == '1' || $this->results[$i]['id'] == $this->pid) {
									?>
									<td style="text-align:center;">

									<a style="text-decoration:none;"
										href="configp.php?body=edit&rbody=<?php echo $this->body; ?>&order=<?php echo $this->order[0]; ?>&show=<?php echo $this->show; ?>&page=<?php echo $this->page; ?>&id=<?php echo $this->results[$i]['id']; ?>" onclick="selectResource(<?php echo ($i+1); ?>)">
										<i class="fas fa-edit uedit"></i>
									</a>
									<a style="text-decoration:none;"
										href="javascript:deleteUsers(<?php echo $this->results[$i]['pcname']; ?>, 1, '<?php echo $this->body; ?>', '<?php echo $this->order[0]; ?>', <?php echo $this->show; ?>, <?php echo $this->page; ?>)" onclick="selectResource(<?php echo ($i+1); ?>)">
										<i class="fas fa-trash udel"></i>
									</a>

									</td>

								<?php
								}//end if
								else {
									?>
									

							
									<?php
								}//end else
							?>
						


		</tr>


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

	</tbody>


</table>


<?php
		}//end if
		else if($this->num && !$this->results[0]['id']) {
			if($this->page != 1)
				header('Location: '.$_SERVER[PHP_SELF].'?body='.$this->body.'&page='.($this->page-1));
			else
				header('Location: '.$_SERVER[PHP_SELF].'?body='.$this->body);
		}//end else if
?>