<?php
	if($id) {
		//Creando consulta
		$query = "SELECT * FROM sld_users WHERE id=$id";
		
		//Ejecutando consulta y creando objeto Record
		$results = new RecordSet($sql->SQLQuery($query));
		
		$usrdata['id'] = $results->Celd(0,'id');
		$usrdata['name'] = $results->Celd(0,'name');
		$usrdata['login'] = $results->Celd(0,'login');
		$usrdata['mail'] = $results->Celd(0,'mail');
		$usrdata['domain'] = $results->Celd(0,'domain');
		$usrdata['level'] = $results->Celd(0,'level');
		$usrdata['type'] = $results->Celd(0,'type');
		$usrdata['action'] = "edit";
		$usrdata['rpage'] = $rpage;
		
		$select[$usrdata['domain']] = $usrdata['domain'];
				
		if($usrdata['type'] == '3') {
			$usrdata['readonly'] = " readonly=\"readonly\"";
		}//end if
	}//end if
	else {
		$usrdata['level'] = 3;
		$usrdata['type'] = 1;
		$usrdata['action'] = "new";
		$usrdata['rpage'] = $rpage;
	}//end else

	$select['db'] = "db";
  
  //Creando objeto Form
	$form = new FormField();
	
	//Creando campo dominio
	$seldomain = $form->select("domain", "domain", $select, "input_text");
?>