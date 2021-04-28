<?php
	if($id) {
		//Creando consulta
		$query = "SELECT * FROM sld_practices_data WHERE id=$id";
		
		//Ejecutando consulta y creando objeto Record
		$results = new RecordSet($sql->SQLQuery($query));
		
		$pdata['id'] = $id;
		$pdata['sid'] = $results->Celd(0,'sid');
		$pdata['pname'] = $results->Celd(0,'pname');
		$pdata['pcname'] = $results->Celd(0,'pcname');
		$pdata['path'] = $results->Celd(0,'path');
		$pdata['stpath'] = $results->Celd(0,'stpath');		
		$pdata['type'] = $results->Celd(0,'type');
		$pdata['visibilidad'] = $results->Celd(0,'visibilidad');
		$pdata['action'] = "edit";
		$pdata['rpage'] = $rpage;
		
		$select[$pdata['type']] = $pdata['type'];
	}//end if
	else {
		$pdata['action'] = "new";
		$pdata['rpage'] = $rpage;
	}//end else
?>
