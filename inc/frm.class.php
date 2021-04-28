<?php
	/*******************************************************************
	*********Escrito por: Yidier Rodríguez Perez de Alejo, 2005*********
	*******************************************************************/
	
	class FormField {
		
		//Propiedades del formulario
		var $formProperties = array('name'=>'NULL');
		//Propiedades del campo del formulario 
		var $fieldProperties = array('name'=>'NULL');
		
		//Función constructor de formulario
		function FormField() {		
		}//end function
		
		//Funcion constructor de area de formulario
		function FormArea($name, $id, $method, $action, $class) {
			$this -> formProperties = array('name'=>$name, 
																			'method'=>$method,
																			'action'=>$action,
																			'enctype'=>'multipart/form-data',
																			'class'=>$class);
			
			$propForm = $this -> formProperties;		
			$form = "<form id=\"".$id."\" name=\"".$propForm['name']."\" method=\"".$propForm['method']."\" action=\"".$propForm['action']."\" enctype=\"".$propForm['enctype']."\">";		
			return $form;
		}//end function
		
		//Funcion constructor de campos de textos
		function TextField($name, $id, $type, $value, $size, $maxLength, $rows, $eneable, $class) {
			$this->fieldProperties = array('id' => $id,
																		 'name' => $name,
																		 'type' => $type,
																		 'value' => $value,
	   		                             'size' => $size,
	                                   'maxLength' => $maxLength,
	                                   'rows' => $rows,
	                                   'eneable' => $eneable,
	                                   'class' => $class);
		}//end function
		
		//Función que imprime el campo de texto
		function getTextField() {
			$prop = $this->fieldProperties;
			
			if($prop['type'] == 'textarea')
				$textField = "<textarea id=\"".$prop['id']."\" name=\"".$prop['name']."\" cols=\"".$prop['size']."\" rows=\"".$prop['rows']."\" class=\"".$prop['class']."\">".$prop['value']."</textarea>";
			else if($prop['type'] == 'hidden')
				$textField = "<input id=\"".$prop['id']."\" name=\"".$prop['name']."\" type=\"hidden\" value=\"".$prop['value']."\" />";
			else
				$textField = "<input id=\"".$prop['id']."\" name=\"".$prop['name']."\" type=\"".$prop['type']."\" value=\"".$prop['value']."\" size=\"".$prop['size']."\" maxLength=\"".$prop['maxLength']."\" class=\"".$prop['class']."\" eneable=\"".$prop['eneable']."\" />";
			
			return $textField;
		}//end function
		
		//Funcion que imprime un checkbox o un radiobutton
		function check($type, $name, $id, $value, $checked) {
			$check = "<input id=\"".$id."\" name=\"".$name."\" type=\"".$type."\" value=\"".$value."\" checked=\"".$checked."\" />";
			
			return $check;
		}//end function
		
		//Función que imprime un radioGroup (no chequeado)
		function radioGroup($name, $id, $value, $class, $colsrows) {
			if($colsrows == 'cols'){
				$radioG = "";
				while($rG = each($value)){
					$radioG = $radioG."<label><input id=\"".$id."\" name=\"".$name."\" type=\"radio\" value=\"".$rG['key']."\">".$rG['value']."</label><br>";
				}//end while
			}//end if
			if($colsrows == 'rows'){
				$radioG = "";
				while($rG = each($value)){
					$radioG = $radioG."<label><input id=\"".$id."\" name=\"".$name."\" type=\"radio\" value=\"".$rG['key']."\">".$rG['value']."</label> ";
				}//end while
			}//end if
			
			return $radioG;
		}//end function
		
		//Función que imprime un menu desplegable
		function select($name, $id, $value, $class) {
			$select = "<select id=\"".$id."\" name=\"".$name."\" class=\"".$class."\">";
			while($sel = each($value)){
				$select .= "<option value=\"".$sel['key']."\">".$sel['value']."</option>";
			}//end while
			$select .= "</select>";
			
	    return $select;
		}//end function
		
		//Función que imprime un botón
		function getButton($type, $id ,$name, $value, $class) {
			$button = "<input type=\"".$type."\" id=\"".$id."\" name=\"".$name."\" value=\"".$value."\" class=\"".$class."\" />";
			
			return $button;
		}//end function
		
		//Función final del formulario
		function EndFormArea() {
			$form = "</form>";
			return $form;
		}//end function
	}//class
?>