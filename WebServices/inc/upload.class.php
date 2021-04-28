<?php
/************************************************
Purpose: Upload file class
*************************************************/
class FileUpload {
	var $tmpfilename;
	var $filename;
	var $orgfilename;
	var $filelocation;
	var $allow = array();
	var $deny = array();
	var $approve = false;
	var $disapprove = true;
	var $extension;
	var $error = false;
	var $maxfilesize = "";
	var $filesize = 0;
	var $overwrite = "N";

	function FileUpload($orgfilename, $tmpfilename, $size) {
		$this->tmpfilename = $tmpfilename;
		$this->orgfilename = $orgfilename;
		$this->extension = strtolower(substr($this->orgfilename, -4));
		$this->filesize = $size;
	}//end function

	function setAllowedType($ext) {
		$this->allow[] = $ext;
	}//end function

	function setDeniedType($ext) {
		$this->deny[] = $ext;
	}//end function

	function setMaxFileSize($maxsize) {
		$this->maxfilesize = $maxsize;
		
		if($this->maxfilesize != '') {
			if($this->filesize > $this->maxfilesize)
				$this->error = true;
		}//end if
	}//end function
	
	function setOverwrite($ow) {
		$this->overwrite = $ow;
	}//end function
	
	function uploadFile($uploaddir, $newfilename) {
		set_time_limit(300);		
		
		if($newfilename != '') {
			$this->filename = $newfilename.$this->extension;
			$this->filelocation = $uploaddir.$this->filename;
		}//end if
		else {
			$this->filelocation = $uploaddir.$this->orgfilename;
		}//end else
		
		if(file_exists($this->filelocation) && $this->overwrite == 'N'){
			$this->error = true;
		}//end if
		
		if(!$this->error) {
    	if(is_uploaded_file($this->tmpfilename)) {
				if(!copy($this->tmpfilename, $this->filelocation)) {
					$this->error = true;
				}//end if
				else {
					$this->filesize = filesize($this->filelocation);
					
					if($this->maxfilesize != '') {
						if($this->filesize > $this->maxfilesize) {
							$this->error = true;
							unlink($this->filelocation);
						}//end if
					}//end if
				}//end else
    	}//end if
		}//end if
		
		unlink($this->tmpfilename);
	}//end function

	function getExtension() {
		return $this->extension;
	}//end function

	function getFilename() {
		return $this->filename;
	}//end function
	
	function getApprove() {
		if(count($this->allow) > 0) {
			$this->approve = in_array($this->extension, $this->allow);
		}//end if
		
		return $this->approve;
	}//end function
	
	function getDisapprove() {
		if(count($this->deny) > 0) {
			$this->disapprove = in_array($this->extension, $this->deny);
		}//end if
		
		return $this->disapprove;
	}//end function
	
	function getOriginalFilename() {
		return $this->orgfilename;
	}//end function

	function getFileLocation() {
		return $this->filelocation;
	}//end function

	function getFilesize() {
		return $this->filesize;
	}//end function

	function getAllowedType() {
		return implode(", ", $this->allow);
	}//end function
	
	function getDeniedType() {
		return implode(", ", $this->deny);
	}//end function

	function getError() {
		return $this->error;
	}//end function
}//end class
?>