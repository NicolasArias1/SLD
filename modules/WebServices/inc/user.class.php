<?php

class UserSession {
	var $uid = 0;
	var $login = '';
	var $name = '';
	var $domain = '';
	var $email = '';
	var $priority = 3;
	
	function UserSession() {
	}//end function
 	 
	function setUID($value) {
		$this->uid = $value;
	}//end function
  
 	function setPriority($value) {
   $this->priority = $value;
 	}//end function

	function setLogin($value) {
		$this->login = $value;
	}//end function
	
 	function setName($value) {
 		$this->name = $value;
 	}//end function
 
 	function setEmail($value) {
 		$this->email = $value;
 	}//end function
 
 	function setDomain($value) {
 		$this->domain = $value;
 	}//end function
	
	function getLogin() {
		return $this->login;
	}//end function
	
 	function getName() {
   	return $this->name;
 	}//end function
 
 	function getEmail() {
    return $this->email;
 	}//end function 

 	function getPriority() {
    return $this->priority;
 	}//end function

 	function getUID() {
    return $this->uid;
  }//end function
 
  function getDomain() {
 	  return $this->domain;
  }//end function
}//end class
?>