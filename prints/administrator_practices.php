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
						
						<li id="list_show" onmouseover="showOptions(this.id, 'list_show_option')" onmouseout="hideOptions(this.id, 'list_show_option')">&nbsp;<strong>Mostrar<br /></strong>
							<ul id="list_show_option">
								<?php
								for($i=1; $i <= $this->nshow; $i++) {
									?>
									<li id="show_element<?php echo $i; ?>" class="list_element" onmouseover="colorOverElement(this.id)" onmouseout="colorOutElement(this.id)" onclick="schPreferences('index.php', '<?php echo $this->url; ?>', '<?php echo $this->order[0]; ?>', <?php echo $i*10; ?>, '')"><?php echo $i*10; ?> Pr&aacute;cticas</li>
									<?php
								}//end for
								?>
							</ul>
						</li>
					</ul>
				</td>
			</tr>
			<?php
				for($i=0; $i < $this->limits[1]; $i++) {
					?>
					<tr id="resource_<?php echo ($i+1); ?>" onmouseover="colorOver(<?php echo ($i+1); ?>)" onmouseout="colorOut(<?php echo ($i+1); ?>)" onclick="selectResource(<?php echo ($i+1); ?>)" class="resource_box">
						<td width="20px" class="check">&nbsp;</td>
						<td width="515px" class="text">
							<a href="details.php?res=<?php echo $this->results[$i]['uid']."/".$this->results[$i]['pname'].$this->results[$i]['date']; ?>&rid=<?php echo $this->results[$i]['id']; ?>" class="ast4" title="<?php echo $this->results[$i]['pname']; ?>"><?php echo $this->results[$i]['pcname']; ?></a><br />
							<p style="font-size:10px;"><strong>Realizada por:</strong> <?php echo $this->results[$i]['ulogin']; ?></p>
							<p style="font-size:10px;"><strong>Fecha de realizaci&oacute;n:</strong> <?php echo practiceDate($this->results[$i]['date']); ?></p>
							<?php 
								if($this->body == 'revisadas') {
									?>
									<p class="adinfo"><strong>Revisada por:</strong> <?php echo $this->results[$i]['tlogin']; ?></p>
									<p class="adinfo"><strong>Fecha de revisi&oacute;n:</strong> <?php echo practiceDate($this->results[$i]['rdate']); ?></p>
									<?php
								}//end if
							?>
						</td>
						<td width="20px" class="image"><a href="details.php?res=<?php echo $this->results[$i]['uid']."/".$this->results[$i]['pname'].$this->results[$i]['date']; ?>&rid=<?php echo $this->results[$i]['id']; ?>" onclick="selectResource(<?php echo ($i+1); ?>)"><img src="../../img/details.gif" alt="Ver" vspace="2" border="0" /></a></td>
						<td width="20px" class="image"><a href="javascript:deleteResources(<?php echo $this->results[$i]['id']; ?>, 1, '<?php echo $this->body; ?>', '<?php echo $this->order[0]; ?>', <?php echo $this->show; ?>, <?php echo $this->page; ?>, <?php echo $this->user; ?>, 'index.php', '')" onclick="selectResource(<?php echo ($i+1); ?>)"><img src="../../img/del.gif" alt="Eliminar" vspace="2" border="0" /></a></td>
					</tr>
					<?php
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
				<?php
			}//end if
			else if($this->nresults && !$this->results[0]['id']) {
				//if($this->page != 1)
					//header('Location: '.$_SERVER[PHP_SELF].'?body='.$this->body.'&page='.($this->page-1));
				//else
					//header('Location: '.$_SERVER[PHP_SELF].'?body='.$this->body);
			}//end else if
	?>
