<?php

	require_once 'mysqlfunctions.php';
	/*function which displays month as per the input date*/
	function display_month($day, $month, $year)
	{
		//getting number of days in the month
		$days_in_month = date("t", mktime(0, 0, 0, $month, 1, $year));
		//getting week day--> 0 for sunday; 1 for monday and so on
		$numeric_week_day = date("w", mktime(0, 0, 0, $month, 1, $year));
		print "<center><table width='100%' height='100%' border='2'>\n";
		print "\t<tr>\n";
		print "\t\t<td width='14%' class='calHeader'>Domingo</td>\n";
		print "\t\t<td width='14%' class='calHeader'>Lunes</td>\n";
		print "\t\t<td width='14%' class='calHeader'>Martes</td>\n";
		print "\t\t<td width='14%' class='calHeader'>Miercoles</td>\n";
		print "\t\t<td width='14%' class='calHeader'>Jueves</td>\n";
		print "\t\t<td width='15%' class='calHeader'>Viernes</td>\n";
		print "\t\t<td width='15%' class='calHeader'>Sabado</td>\n";
		print "\t</tr>\n";
		print "\t<tr>\n";
		for ($i = 1; $i <= $numeric_week_day; $i++)
		{
			print "\t\t<td align='center' bgcolor='#8EA5BB'></td>\n";
		}
		for($j = 1+$numeric_week_day; $j <= $days_in_month+$numeric_week_day; $j++)
		{
			$temp_day = $j-$numeric_week_day;
			if ($j == $day+$numeric_week_day)
				print "\t\t<td align='center' bgcolor='#8EA5BB'>";
			else
				print "\t\t<td align='center' bgcolor='#8EA5BB'>";

			print "<a href='$_SERVER[PHP_SELF]?date=$temp_day-$month-$year' class='ast5'>";
			print "$temp_day";
			print "</a></td>\n";
			if($j % 7 == 0)
			{
				print "\t</tr>\n";
				print "\t<tr>\n";
			}
		}
		print "\t</tr>\n";
		print "</table></center>\n";
	}
	/*function to display tasks of a particular user on a particular date*/
	function display_tasks($userid, $date, $sortby)
	{
		$database_link = selection_of_db();
		$who="";
		$groupId="";
		$groupName="";	
		$select_task_query = "select * from sld_users where id=".$userid;
		$result = mysql_query($select_task_query, $database_link) or die("Query Failed : " . mysql_error());
		$result=mysql_fetch_array($result);
		if($result['level']==1)
		{
			$who='user';
			$groupName=$result['group_Name'];
			$group_query = "select * from user_groups where Name='".$groupName."'";
			$result = mysql_query($group_query, $database_link) or die("Query Failed : " . mysql_error());
			$result=mysql_fetch_array($result);
			$groupId=$result['groupId'];
			if(!empty($groupId))
			{
				$select_task_query = "select taskid, id, description, TIME_FORMAT(startdatetime,'%h:%i %p') as Start_Time ,task_workrelated, TIME_FORMAT(enddatetime,'%h:%i %p') as End_Time, priority, iscompleted from calendar_tasks where groupID=".$groupId." or id=".$userid ." and DATE_FORMAT(entryDate,'%e-%c-%Y') like'".$date."'";	
			}
			else
			{
				$select_task_query = "select taskid, id, description, TIME_FORMAT(startdatetime,'%h:%i %p') as Start_Time ,task_workrelated, TIME_FORMAT(enddatetime,'%h:%i %p') as End_Time, priority, iscompleted from calendar_tasks where id=".$userid ." and DATE_FORMAT(entryDate,'%e-%c-%Y') like'".$date."'";			
			}				
		}	
		else
		{
			$who='user';
			$groupName=$result['group_Name'];
			$group_query = "select * from user_groups where Name='".$groupName."'";
			$result = mysql_query($group_query, $database_link) or die("Query Failed : " . mysql_error());
			$result=mysql_fetch_array($result);
			$groupId=$result['groupId'];
			if(!empty($groupId))
			{
				$select_task_query = "select taskid, id, description, TIME_FORMAT(startdatetime,'%h:%i %p') as Start_Time ,task_workrelated, TIME_FORMAT(enddatetime,'%h:%i %p') as End_Time, priority, iscompleted from calendar_tasks where groupID=".$groupId." or id=".$userid ." and DATE_FORMAT(entryDate,'%e-%c-%Y') like'".$date."'";	
			}
			else
			{
				$select_task_query = "select taskid, id, description, TIME_FORMAT(startdatetime,'%h:%i %p') as Start_Time ,task_workrelated, TIME_FORMAT(enddatetime,'%h:%i %p') as End_Time, priority, iscompleted from calendar_tasks where id=".$userid ." and DATE_FORMAT(entryDate,'%e-%c-%Y') like'".$date."'";			
			}	
			
		}		
		
		$result = mysql_query($select_task_query, $database_link) or die("Query Failed : " . mysql_error());
		print "<table border='0' width='100%' cellpadding=6>\n";
		print "\t<tr>\n";
			print "\t\t<td align='left'><b><font face=verdana>Inicia</b></td>\n";
			print "\t\t<td align='left'><b><font face=verdana>Termina</b></td>\n";
			print "\t\t<td align='left'><b><font face=verdana>Descripci&oacute;n</b></td>\n";
			print "\t\t<td align='center'><b><font face=verdana>Estaci&oacute;n</b></td>\n";
			//print "\t\t<td align='center'><b><font face=verdana>Completed</b></td>\n";
			print "\t\t<td align='left'><b><font face=verdana>Eliminar</b></td>\n";
			//print "\t\t<td align='center'><b><font face=verdana>Work related</b></td>\n";
		print "\t</tr>\n";
		$row = mysql_num_rows($result);	
		while($row = mysql_fetch_array($result))
		{
			print "\t<tr>\n";
				print "\t\t<td align='center'>$row[Start_Time]</td>\n";
				print "\t\t<td align='center'>$row[End_Time]</td>\n";
				if($who=='user')
					print "\t\t<td align='center'><a class=ast3  href=taskdetails.php?taskid=$row[taskid]&todaysdate=$date>$row[description]</a></td>\n";
				else
					print "\t\t<td align='center'><a class=ast3  href=taskdetails.php?taskid=$row[taskid]&todaysdate=$date>$row[description]</a></td>\n";
				print "\t\t<td align='center'>$row[priority]</td>\n";
				//$check = ($row['iscompleted']==1) ? 'checked' : '';
				//print "\t\t<td align='center'><input type='checkbox' name='chkIsComplete[]' value='$row[taskid]' $check onclick='document.forms[0].btnUpdate.disabled=false;'></td>\n";
				print "\t\t<td align='center'><input type='checkbox' name='chkDelete[]' value='$row[taskid]' onclick='document.forms[0].btnDelete.disabled=false;'></td>\n";
				$check = ($row['task_workrelated']==1) ? 'checked' : '';
				//print "\t\t<td align='center'><input type='checkbox' name='chkIsworkrelated[]' value='$row[taskid]' $check onclick='document.forms[0].btnUpdate.disabled=false;'></td>\n";
			print "\t</tr>\n";
		}
		print "\t<tr>\n";
				if($who=='user')
					print "\t\t<td align='left' colspan='4'><input type='button' class='input_button' style='width:70pt' value='Nuevo' name='btnAddTask' onclick='javascript:window.location.href=\"taskdetails.php?todaysdate=$date\"'></td>\n";
				else if($who=='user')
					print "\t\t<td align='left' colspan='4'><input type='button' class='input_button' style='width:70pt' value='Nuevo' name='btnAddTask' onclick='javascript:window.location.href=\"taskdetails.php?todaysdate=$date\"'></td>\n";
				//print "\t\t<td align='center'><input type='submit' value='Update' name='btnUpdate' class='buttonclass'  disabled onclick='document.forms[0].submit();'></td>\n";
				print "\t\t<td align='left'><input type='submit' value='Eliminar' name='btnDelete' class='input_button'  disabled onclick='document.forms[0].submit();'></td>\n";
		print "\t</tr>\n";
		print "</table>\n";
		mysql_close($database_link);
	}
	/*function to display usernames along with check boxes*/
	function display_users()
	{
		$database_link = selection_of_db();
		$select_users_query = "select * from sld_users where level='3'";
		$result = mysql_query($select_users_query, $database_link) or die("Query Failed : " . mysql_error());
		print "<table width=100% cellspacing=5>\n";
		print "\t<tr>\n";
			print "\t\t<td align='center'><b><font face=verdana>Delete</b></td>";
			print "\t\t<td align='center'><b><font face=verdana>Make Admin</b></td>";
			print "\t\t<td align='center'><b><font face=verdana>User Name</b></td>";
			print "\t\t<td align='center'><b><font face=verdana>Hours per day</b></td>";
			print "\t\t<td align='center'><b><font face=verdana>Hours per week</b></td>";
			print "\t\t<td align='center'><b><font face=verdana>Hours per month</b></td>";
			print "\t\t<td align='center'><b><font face=verdana>Hours per year</b></td>";
		print "\t</tr>";
		while($row = mysql_fetch_array($result))
		{
			print "\t<tr>\n";
				print "\t\t<td align='center'><input type='checkbox'  name='chkDelete[]' value='$row[id]' onclick='document.forms[0].btnDelete.disabled=false;'></td>\n";
				print "\t\t<td align='center'><input type='checkbox'  name='chkMakeAdmin[]' value='$row[id]' onclick='document.forms[0].btnMakeAdmin.disabled=false;'></td>\n";
				print "\t\t<td align='center'><font face=verdana>$row[userName]</td>\n";
				if($row['Type']=='general')
				{
				print "\t\t<td align='center'><font face=verdana>$row[hours_per_day]</td>\n";
				print "\t\t<td align='center'><font face=verdana>$row[hours_per_week]</td>\n";	
				print "\t\t<td align='center'><font face=verdana>$row[hours_per_month]</td>\n";
				print "\t\t<td align='center'><font face=verdana>$row[hours_per_year]</td>\n";
				}
				if($row['Type']=='group')
				{
					$select_group_query = "select * from user_groups"; //where Name='Graphics Group'";//.$row['group_Name']."'";
					$groupresult = mysql_query($select_group_query, $database_link) or die("Query Failed : " . mysql_error());
					$rows=mysql_num_rows($groupresult);
					if($grouprow = mysql_fetch_array($groupresult))
					{
						print "\t\t<td align='center'><font face=verdana>$grouprow[hours_per_day]</td>\n";
						print "\t\t<td align='center'><font face=verdana>$grouprow[hours_per_month]</td>\n";
						print "\t\t<td align='center'><font face=verdana>$grouprow[hours_per_year]</td>\n";
					}	
				}	
			print "\t</tr>\n";
		}
		print "\t<tr>\n";
			print "\t\t<td align='center'><input type='submit' value='Delete' class='buttonclass' name='btnDelete' disabled style='width:70px'></td>\n";
			print "\t\t<td align='center'><input type='submit' value='Make Admin' class='buttonclass' name='btnMakeAdmin' disabled style='width:70px'></td>\n";
			print "\t\t<td align='left'>&nbsp;</td>\n";
		print "\t</tr>\n";
		print "</table>\n";
	}
?>