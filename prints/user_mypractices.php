<link rel="stylesheet" href="../../prints/css/user_mypractices.css">


<?php if($this->nresults == 0){ ?>

	<div class="col-md-6">
		<a style="text-decoration: none;margin:0;color: whitesmoke; font-size: 13px;" href="practices.php">
			<div class="btnAddPractice">
				<i class="fas fa-arrow-circle-right"></i>
				
				<p style="margin:0;">Realizar práctica</p>
			</div>
		</a>
	</div>


<?php } ?>




<?php if($this->nresults && $this->results[0]['id']) { ?>

<div class="row d-flex justify-content-between" style="margin-bottom:10px;">
	<div class="col-md-6">
		<a style="text-decoration: none;margin:0;color: whitesmoke; font-size: 13px;" href="practices.php">
			<div class="btnAddPractice">
				<i class="fas fa-arrow-circle-right"></i>
				
				<p style="margin:0;">Realizar práctica</p>
			</div>
		</a>
	</div>


	<div id="mostrarB" class="col-md-6 dropdown">
		<button style="font-size:13px !important;" class="btn btn-secondary dropdown-toggle" type="button"
			id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Mostrar
		</button>
		<div class="dropdown-menu" style="font-size:13px !important;" aria-labelledby="dropdownMenuButton">
			<?php
									for($i=1; $i <= $this->nshow; $i++) {
										?>
			<span id="show_element<?php echo $i; print_r("URL:".$this->url);?>" class="dropdown-item"
				onclick="schPreferences('mypractices.php', '<?php echo $this->url; ?>', '<?php echo $this->order[0]; ?>', <?php echo $i*10; ?>, '')">
				<?php echo $i*10; ?> Pr&aacute;cticas</span>
			<?php
									}//end for
									?>
		</div>
	</div>



</div>

<div class="results_info">
	<?php echo $this->message; ?>
</div>


<table class="table table-bordered table-hover tsize">

	<tr class="bg-dark">
		<th class="col-sm-1" scope="col">N°</th>
		<!--<th class="col-sm-8" scope="col">Asignatura</th> -->
		<th class="col-sm-6" scope="col">Práctica</th>
		<th class="col-sm-3" scope="col">Fecha de realización</th>
		<th class="col-sm-0" scope="col">Nota</th>
		<th class="col-sm-1" scope="col">Acción</th>
	</tr>

	<tbody style="font-size:13px;">

		<?php for($i=0; $i < $this->limits[1]; $i++) { ?>


		<tr id="resource_<?php echo ($i+1); ?>" onmouseover="colorOver(<?php echo ($i+1); ?>)"
			onmouseout="colorOut(<?php echo ($i+1); ?>)" onclick="selectResource(<?php echo ($i+1); ?>)"
			class="resource_box">


			<td> <?php echo $i+1;  ?></td>

			<td>

				<a style="text-decoration:none;color:black;" href="details.php?res=<?php echo $this->results[$i]['uid']."/".$this->results[$i]['pname'].$this->results[$i]['date']; ?>&rid=<?php echo $this->results[$i]['id']; ?>" class="ast4" title="<?php echo $this->results[$i]['pname']; ?>"><?php echo $this->results[$i]['pcname']; ?>
				</a>

			</td>


			<td>
				<p><?php echo practiceDate($this->results[$i]['date']); ?></p>
			</td>

			<td style="text-align:center;">
						<a style="color:#FF9900;" href="#">
							<i class="fas fa-sticky-note"></i>
						</a>
			</td>

			<td style="text-align:center;">
						<a href="details.php?res=<?php echo $this->results[$i]['uid']."/".$this->results[$i]['pname'].$this->results[$i]['date']; ?>&rid=<?php echo $this->results[$i]['id']; ?>" onclick="selectResource(<?php echo ($i+1); ?>)"><i class="fas fa-eye"></i></a>

						<a href="javascript:deleteResources(<?php echo $this->results[$i]['id']; ?>, 1, '<?php echo $this->body; ?>', '<?php echo $this->order[0]; ?>', <?php echo $this->show; ?>, <?php echo $this->page; ?>, <?php echo $this->user; ?>, 'index.php', '')" onclick="selectResource(<?php echo ($i+1); ?>)"><i class="fas fa-trash udel"></i></a>
			</td>


		</tr>

		<?php }  ?>

	</tbody>

</table>

<?php if($this->paginate) {	 ?>

<tr >
		
			<p style="text-align:center;" class="paginator"><?php echo $this->paginate; ?>                  </p>
		
</tr>


<?php }//end if ?>

<?php
			}//end if
			else if($this->nresults && !$this->results[0]['id']) {
				//if($this->page != 1)
					//header('Location: '.$_SERVER[PHP_SELF].'?body='.$this->body.'&page='.($this->page-1));
				//else
					//header('Location: '.$_SERVER[PHP_SELF].'?body='.$this->body);
			}//end else if
	?>
