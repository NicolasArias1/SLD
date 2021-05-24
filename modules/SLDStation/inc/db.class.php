<?php
	/*******************************************************************
	********* Escrito por: Yidier Rodríguez Perez de Alejo, 2005 *******
	*******************************************************************/

	class SQL {
		
		//Indicador de conexión con el servidor
		var $connect = 0;
		//Indicador de conexión con la base de datos
		var $db = 0;
		//Contador de filas afectadas
		var $count = 0;
		//ID de la ultima operación efectuada
		var $id = 0;
		//Error que da el servidor
		var $error = "";
		//Numero del error que da el servidor
		var $errno = 0;
		//Error que da el servidor; procesado
		var $errstr = "";
		//Variables de conexión
		var $DBserver = "10.12.26.27";
		var $DBname = "web36db2";
	  var $DBuser = "root";
	  var $DBpasswd = "SeM!N@R!01";
	  
	  //Función constructor
		function SQL() {
		}//end function
		
		//Función para introducir variables de conexión
		function SQLParameters($DBserver, $DBname, $DBuser, $DBpasswd) {
			$this->DBserver = $DBserver;
			$this->DBname = $DBname;
			$this->DBuser = $DBuser;
			$this->DBpasswd	= $DBpasswd;
			$this->error = "";
			$this->errno = 0;
			$this->errstr = "";
		}//end function
		
		//Función de conexión
		function SQLConnection() {
			//conexion con el MySQL Server
			echo $this->DBserver." - ".$this->DBuser." - ".$this->DBpasswd."\n";
			
			@$this->connect = mysql_connect($this->DBserver, $this->DBuser, $this->DBpasswd);
			$this->SQLError();
			
			if(!$this->errno) {
				//conectandose a la base de datos
				@$this->db = mysql_select_db($this->DBname);
				$this->SQLError();
			}//end if
		}//end function	
		
		//Función de consultas
		function SQLQuery($query) {
			if($this->connect && $this->db && !$this->errno) {
				$Dbresult = mysql_query($query);
				$this->SQLError();
				
				@$this->count = mysql_num_rows($Dbresult);
				if($Dbresult) {
					if($this->count != 0) {		  
				  	$i = 0;
				  	while($row = mysql_fetch_row($Dbresult)) { 
				    	for($j=0; $j < count($row); $j++) {
				     		$field = mysql_field_name($Dbresult, $j);
				     		$result[$i][$field] = $row[$j];
				    	}//end for
				    	$i++;
				   	}//end while
				   			    
				 	return $result;	 
				 	}//end if
				 	else {
				 		return true;
				 	}//end else
				}//end if
				else {
					return false;
				}//end else
			}//end if
			else {
				return false;
			}//end else
		}//end function
		
		//Función para obtener el ID
		function SQLInsertID() {
			$this->id = mysql_insert_id();
			return $this->id;
		}//end function
		
		//Función para obtener las tablas
		function SQLTables() {
			$result = mysql_list_tables($this->DBname);
			
			@$this->count = mysql_num_rows($result);
			for($i=0; $i < $this->count; $i++) {
		    $tables[$i] = mysql_tablename($result, $i);
			}//for
			
			return $tables;
		}//end function
		
		//Función para procesar los errores
		function SQLError() {
			$this->error = mysql_error();
			$this->errno = mysql_errno();
			$this->errstr = mysql_errno().": ".mysql_error();
		}//end function
		
		//Función para cerrar la conexión
		function SQLClose(){
			//Cerrando la conexion con la base de datos
			@mysql_close($this->connect);
		}//end function
	}//class
	
	class RecordSet {
		var $table;
		
		function RecordSet($record) {
			$this->table = $record;	
		}//end function	
		
		function Celd($row,$column) {
			return $this->table[$row][$column];	
		}//end function
		
		function Rows() {
			return count($this->table);	
		}//end function
		
		function Columns() {
			return count($this->table[0]);	
		}//end function 
	}//end class
?>