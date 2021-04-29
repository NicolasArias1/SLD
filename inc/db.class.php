<?php
    
	/*******************************************************************
	********* Escrito por: Yidier Rodr�guez Perez de Alejo, 2005 *******
	*******************************************************************/

	class SQL {
		
		//Indicador de conexi�n con el servidor
		var $connect = null;
		//Indicador de conexi�n con la base de datos
		var $db = 0;
		//Contador de filas afectadas
		var $count = 0;
		//ID de la ultima operaci�n efectuada
		var $id = 0;
		//Error que da el servidor
		var $error = "";
		//Numero del error que da el servidor
		var $errno = 0;
		//Error que da el servidor; procesado
		var $errstr = "";
		//Variables de conexi�n
		var $DBserver = DB_SERVER;
		var $DBname = DB_NAME;
	    var $DBuser = DB_USER;
	    var $DBpasswd = DB_PASSWD;
	  
	  //Funci�n constructor
		function SQL() {
		}//end function
		
		//Funci�n para introducir variables de conexi�n
		function SQLParameters($DBserver, $DBname, $DBuser, $DBpasswd) {
			$this->DBserver = $DBserver;
			$this->DBname = $DBname;
			$this->DBuser = $DBuser;
			$this->DBpasswd	= $DBpasswd;
			$this->error = "";
			$this->errno = 0;
			$this->errstr = "";
			$this->connect = mysqli_connect($this->DBserver, $this->DBuser, $this->DBpasswd, $this->DBname);
		}//end function
		
		//Funci�n de conexi�n
		function SQLConnection() {
			//conexion con el MySQL Server
			@$this->connect = mysqli_connect($this->DBserver, $this->DBuser, $this->DBpasswd, $this->DBname);
			$this->SQLError();
			
			if(!$this->errno) {
				//conectandose a la base de datos
				@$this->db = mysqli_select_db($this->connect, $this->DBname);
				$this->SQLError();
			}//end if
		}//end function	

		function mysqli_field_name($result, $field_offset) {
   			$properties = mysqli_fetch_field_direct($result, $field_offset);
    		return is_object($properties) ? $properties->name : null;
		}
		
		//Funci�n de consultas
		function SQLQuery($query) {
			if($this->connect && $this->db && $this->errno == 0) {
				
				$Dbresult = mysqli_query($this->connect, $query);
				$this->SQLError();
				
				@$this->count = mysqli_num_rows($Dbresult);

				if($Dbresult) {

					if($this->count != 0) {		  
				  	$i = 0;
				  	while($row = mysqli_fetch_row($Dbresult)) { 
				    	for($j=0; $j < count($row); $j++) {
				     		$field = $this->mysqli_field_name($Dbresult, $j); // mysql_field_name($Dbresult, $j);
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
		
		//Funci�n para obtener el ID
		function SQLInsertID() {
			$this->id = mysqli_insert_id($this->connect);
			return $this->id;
		}//end function
		
		//Funci�n para obtener las tablas
		function SQLTables() {
			$result = mysql_list_tables($this->DBname);
			
			@$this->count = mysql_num_rows($result);
			for($i=0; $i < $this->count; $i++) {
		    $tables[$i] = mysql_tablename($result, $i);
			}//for
			
			return $tables;
		}//end function
		
		//Funci�n para procesar los errores
		function SQLError() {
			$this->error = mysqli_connect_error($this->error);
			$this->errno = mysqli_connect_errno($this->errno);
			$this->errstr = mysqli_connect_errno($this->errno).": ".mysqli_connect_error($this->error);
		}//end function
		
		//Funci�n para cerrar la conexi�n
		function SQLClose(){
			//Cerrando la conexion con la base de datos
			@mysqli_close($this->connect);
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