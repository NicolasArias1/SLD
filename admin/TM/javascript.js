function checkForBlank(ctr, msg)
{
	if(ctr.value==0)
	{
		alert("Insert the "+msg);
		ctr.value="";
		ctr.focus();
		return true;
	}
	else return false;
}