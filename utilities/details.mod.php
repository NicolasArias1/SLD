<?php
	$sql = new SQL();

	if(isset($call)) {
		
//		//Creando objeto Configuration
//  	$config = new ManageConfiguration();
//	
//	  //Cargando par�metros MySQL
//	  $config->getMySQLParameters();
//	  
//	  //Cargando par�metros de contribuci�n
//	  $config->getContribution();
	  

	  
	  //Conectando con el servidor
		$sql->SQLConnection();
		
		if(!$level && $sql->errno)
			header('Location: authenticate.php');
		else if($level && $sql->errno)
			header('Location: ../general/logout.php');
			
		//Creando consulta
		$query = "SELECT * FROM sld_practices WHERE id=$rid";
		
		//Ejecutando consulta y creando objeto Record
		$results = new RecordSet($sql->SQLQuery($query));
		
		
		$votes = $results->Celd(0,'votes');
		$rank = $results->Celd(0,'rank');
		
		$vote = explode(";",$votes);
		
		if($rank)
			$nvotes = count($vote);
		else
			$nvotes = 0;
		
		
		if($login && $domain) {
			
			//Creando consulta
			$query = "SELECT rvalued FROM sld_users WHERE (login='$login' AND domain='$domain')";
			
			//Ejecutando consulta
			$results = new RecordSet($sql->SQLQuery($query));
			
			$arvotes = explode(";",$results->Celd(0,'rvalued'));
			
			if(isset($id) && in_array($id,$arvotes))
				$vote = FALSE;
			else
				$vote = TRUE;
				
		}//end if
	}//end if
	
	if($advuser) {
		//Creando consulta
		$query = "SELECT * FROM comments WHERE rid=$rid ORDER BY sdate DESC";
	}//end if
	else {
		$sql = new SQL();
		//Creando consulta
		$query = "SELECT COUNT(*) FROM comments WHERE (rid=$rid AND ulogin='$login' AND new=0)";
		
		//Ejecutando consulta
		$results = new RecordSet($sql->SQLQuery($query));
		$nmycomments = $results->Celd(0,'COUNT(*)');
		
		//Creando consulta
		$query = "SELECT * FROM comments WHERE (rid=$rid AND new=0) ORDER BY sdate DESC";
	}//end else
	
	//Ejecutando consulta
	$comments = new RecordSet($sql->SQLQuery($query));
	$ncomments = $sql->count;
	

	
	if(isset($call)) {	
		if($uid && $login && $domain) {
			include('setonline.mod.php');
			//include('writelog.mod.php');
		}//end if
		
		//Cerrando conexi�n
		$sql->SQLClose();
	
		//Procesamiento del ranking del recurso	
		$stars = '';
		$image = '';
		$prom = '';
		for($i=0; $i < 5; $i++) {
			if($rank && $i < $rank)
				$stars .= "<img src=\"".$image."../img/star.gif\" alt=\"Valorado: ".$prom."\" class=\"detail_star\" />";
			else
				$stars .= "<img src=\"".$image."../img/unstar.gif\" alt=\"Valorado: ".$prom."\" class=\"detail_star\" />";
		}//end for
		$stars .= " ".substr($rank,0,4)." de 5 con ".$nvotes." voto(s).";
		
		//Procesamiento de los detalles del recurso
		ob_start();
		while($element = each($recurso)) {
		  if($element['value']) { 
			  if($element['key'] != 'URL') {
			  	?>
				  <div class="detail_celd">
				  	<div class="detail_field"><?php echo $element['key']; ?>:</div><div class="detail_text"><?php echo $element['value']; ?></div>
				  	<div style="height: 1px; clear: right;"></div>
				  </div>
		    	<?php
		    }//end if
		    else {
		    	?>
				  <div class="detail_celd">
				  	<div class="detail_field"><?php echo $element['key']; ?>:</div><div class="detail_text"><a href="<?php echo $element['value']; ?>" target="_blank" class="linkb" onclick="resVisitCount(<?php echo $id; ?>, <?php echo $level; ?>)"><?php echo $element['value']; ?></a></div>
				  	<div style="height: 1px; clear: right;"></div>
				  </div>
		    	<?php
		    }//end else
		  }//end if
	  }//end while
	  $detHTML = ob_get_contents();
		ob_end_clean();
		
		//Procesamiento de los detalles adicionales del recurso
		ob_start();
		while($element = each($adetails)) {
			if($element['value']) { 
				?>
		    <div class="detail_celd">
			  	<div class="detail_field"><?php echo $element['key']; ?>:</div><div class="detail_text"><?php echo $element['value']; ?></div>
			  </div>
			  <?php
			}//end if
	  }//end while
	  
	  $adetHTML = ob_get_contents();
		ob_end_clean();
	}//end if
	
	//Procesamiento de los comentarios del recurso
	if($ncomments) {
		ob_start();
		if($advuser || $nmycomments) {
			?>
			<h1 class="content_r_hst2">Comentarios de los usuarios</h1>
			<table width="100%" cellpadding="0" cellspacing="0" class="results">
				<tr>
					<td colspan="5" class="menu">
						<ul id="menu_list_box">
							<li id="list_select" onmouseover="showOptions(this.id, 'list_select_option')" onmouseout="hideOptions(this.id, 'list_select_option')">&nbsp;<strong>Seleccionar<br /></strong>
								<ul id="list_select_option">
									<li id="select_element1" class="list_element" onmouseover="colorOverElement(this.id)" onmouseout="colorOutElement(this.id)" onclick="checkMine(true, <?php echo $ncomments; ?>, 'list_select', 'list_select_option')">Mios</li>
									<?php
										if($advuser) {
											?>
											<li id="select_element2" class="list_element" onmouseover="colorOverElement(this.id)" onmouseout="colorOutElement(this.id)" onclick="checkNews(true, <?php echo $ncomments; ?>, 'list_select', 'list_select_option')">Nuevos</li>
											<li id="select_element3" class="list_element" onmouseover="colorOverElement(this.id)" onmouseout="colorOutElement(this.id)" onclick="checkAll(true, <?php echo $ncomments; ?>, 'list_select', 'list_select_option')">Todos</li>
											<?php
										}//end if
									?>
									<li id="select_element4" class="list_element" onmouseover="colorOverElement(this.id)" onmouseout="colorOutElement(this.id)" onclick="checkAll(false, <?php echo $ncomments; ?>, 'list_select', 'list_select_option')">Ninguno</li>
								</ul>
							</li>
							<li id="list_operation" onmouseover="showOptions(this.id, 'list_operation_option')" onmouseout="hideOptions(this.id, 'list_operation_option')">&nbsp;<strong>Operaciones<br /></strong>
								<ul id="list_operation_option">
									<?php
									if($advuser) {
										?>
										<li id="operation_element1" class="list_element" onmouseover="colorOverElement(this.id)" onmouseout="colorOutElement(this.id)" onclick="acceptComments('*', <?php echo $rid; ?>, <?php echo $ncomments; ?>)">Publicar<br /></li>
										<?php
									}//end if
									?>
									<li id="operation_element2" class="list_element" onmouseover="colorOverElement(this.id)" onmouseout="colorOutElement(this.id)" onclick="deleteComments('*', <?php echo $rid; ?>, '<?php echo $advuser; ?>', <?php echo $ncomments; ?>)">Eliminar</li>
								</ul>
							</li>
						</ul>
					</td>
				</tr>
				<?php
			}//end if
			for($i=0; $i < $ncomments; $i++) {
				$arr = split(" ",$comments->Celd($i,'sdate'));
				$date = split("-",$arr[0]);
				if($comments->Celd($i,'ulogin') == $login || $advuser) {
					?>
					<tr class="resource_box" id="resource_<?php echo ($i+1); ?>" onmouseover="colorOver(<?php echo ($i+1); ?>)" onmouseout="colorOut(<?php echo ($i+1); ?>)" onclick="selectResource(<?php echo ($i+1); ?>)">
						<td width="20px" class="check"><input type="checkbox" id="<?php echo ($i+1); ?>" name="<?php echo ($i+1); ?>" value="<?php echo $comments->Celd($i,'id'); ?>" class="input_checkbox" onclick="selectResource(<?php echo ($i+1); ?>)" /></td>
						<?php
						if($comments->Celd($i,'ulogin') == $login) {
							?>
							<td width="495px" class="text" id="mine_<?php echo ($i+1); ?>">
								<?php echo $comments->Celd($i,'comment'); ?>
								<p class="adinfo"><strong>Coment&oacute;: </strong><?php echo $comments->Celd($i,'ulogin'); ?> (<?php echo $date[2]."/".$date[1]."/".$date[0]; ?>)</p>
							</td>
							<?php
						}//end if
						else {
							?>
							<td width="495px" class="text">
								<?php echo $comments->Celd($i,'comment'); ?>
								<p class="adinfo"><strong>Coment&oacute;: </strong><?php echo $comments->Celd($i,'ulogin'); ?> (<?php echo $date[2]."/".$date[1]."/".$date[0]; ?>)</p>
							</td>
							<?php
						}//end else
						if($advuser && $comments->Celd($i,'new') == '1') {
							?>
								<td width="20px" class="image" id="new_<?php echo ($i+1); ?>"><a href="javascript:acceptComments(<?php echo $comments->Celd($i,'id'); ?>, <?php echo $rid; ?>, 1)" onclick="selectResource(<?php echo ($i+1); ?>)"><img src="../img/accept.gif" alt="Detalles" vspace="2" border="0" /></a></td>
							<?php
						}//end if
						else if($advuser) {
							?>
								<td width="20px" class="image">&nbsp;</td>
							<?php
						}//end else
						?>
						<td width="20px" class="image">
							<?php 
							if(COM_CONT) {
								?>
								<a href="#comment_form_box" onClick="openComment(<?php echo $comments->Celd($i,'id'); ?>, <?php echo ($i+1); ?>)"><img src="../img/edit.gif" alt="Editar" vspace="2" border="0" /></a>
								<?php
							}//end if
							else
								echo "&nbsp;";
							?>
						</td>
						<td width="20px" class="image"><a href="javascript:deleteComments(<?php echo $comments->Celd($i,'id'); ?>, <?php echo $rid; ?>, '<?php echo $advuser; ?>', 1)" onclick="selectResource(<?php echo ($i+1); ?>)"><img src="../img/del.gif" alt="Eliminar" vspace="2" border="0" /></a></td>
					</tr>
					<?php
				}//end if
				else {
				?>			
					<tr class="comment" id="resource_<?php echo ($i+1); ?>" onmouseover="colorOver(<?php echo ($i+1); ?>)" onmouseout="colorOut(<?php echo ($i+1); ?>)">
						<td class="comment_text"><?php echo $comments->Celd($i,'comment'); ?></td>
						<td class="comment_data"><strong>Coment&oacute;: </strong><?php echo $comments->Celd($i,'ulogin'); ?> (<?php echo $date[2]."/".$date[1]."/".$date[0]; ?>)</td>
					</tr>
				<?php
				}//end else
			}//end for
			?>
		</table>
		<?php
		$comHTML = ob_get_contents();
		ob_end_clean();
	}//end if
	
	if(isset($call))
		echo $comHTML;
?>