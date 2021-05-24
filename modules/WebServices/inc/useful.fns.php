<?php
	function Date_Time() {
		$day_name = array("Domingo", "Lunes","Martes","Miercoles","Jueves","Viernes","S�bado");
	  $month = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	  
	  $num_day_week = date("w");
	  $num_month = date("n");
	  $day = date("d");
	  $year = date("Y");
	  $hour = date("g:i A");
	  $sp_date = $day_name[$num_day_week]." ".$day." de ".$month[$num_month-1]." del ".$year." ".$hour ;
	  
	  echo $sp_date;
	}//end function
	
	function getMonth($nmonth) {
		$month = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
		
		return $month[abs($nmonth)-1];
	}//end function
	
	function Date_Num() {
		$day = date("d");
		$month = date("m");
		$year = date("y");
		
		$date = $day."-".$month."-".$year;
		return $date;
	}//end function
	
	function Date_Det() {
		$day_name = array("Domingo", "Lunes","Martes","Miercoles","Jueves","Viernes","S�bado");
		
		$num_day_week = date("w");
		$day = date("j");
		$month = date("n");
		$year = date("y");
		
		$date = $day_name[$num_day_week]." ".$day." / ".$month." / ".$year;
		return $date;
	}//function
	
	function xmlspecialchars($string) {
		$sparray = array('ñ'=>'�',
										 'á'=>'�',
										 'é'=>'�',
										 'í'=>'�',
										 'ó'=>'�',
										 'ú'=>'�');
		
		while($chars = each($sparray)) {
			$string = str_replace($chars["key"], $chars["value"], $string);
		}//end while
		return $string;
	}//function
	
	function tildes($string) {
		$sparray = array('�'=>'&Aacute;',
										 '�'=>'&aacute;',
										 '�'=>'&Eacute;',
										 '�'=>'&eacute;',
										 '�'=>'&Iacute;',
										 '�'=>'&iacute;',
										 '�'=>'&Oacute;',
										 '�'=>'&oacute;',
										 '�'=>'&Uacute;',
										 '�'=>'&uacute;',
										 '�'=>'&Ntilde;',
										 '�'=>'&ntilde;');
		
		while($chars = each($sparray)) {
			$string = str_replace($chars['key'], $chars['value'], $string);
		}//end while
		return $string;
	}//function
	
	function mailaddress($address) {
		if((strlen($address)<6) || !(ereg("^[a-zA-Z0-9_.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$", $address))) {
	  	return false;
	  }//end if
	  else {
	  	return $address;
	  }//end else
	}//function
	
	function keyword($string) {
		$strarray = split(", ", $string);
		return $strarray;
	}//function
	
	function sumary($string) {
		$str = trim($string);
		$num = strlen (stripslashes($str));
		$array = split(" ", $str);
		if(count($array) > 30) {
			for($i=0; $i<30; $i++)
				$txt .= $array[$i]." ";
			$txt .= "...";
		}//end if
		else
			$txt .= $string;
			
		return $txt;		
	}//function
	
	function title($string) {
		$str = trim($string);
		$num = strlen (stripslashes($str));
		$array = split(" ", $str);
		if(count($array) > 10) {
			for($i=0; $i<10; $i++)
				$txt .= $array[$i]." ";
			$txt .= "...";
		}//end if
		else
			$txt .= $string;
			
		return $txt;		
	}//end function
	
	function largeURL($url) {
		$str = trim($url);
		$array = parse_url($str);
		$cad = "http://".$array['host']."/";
		return $cad;		
	}//end function
	
	function leap($year) {
		if($year%4 == 0 && ($year%100 != 0 || $year%400 == 0))
			return true;
		else
			return false;
	}//end function
	
	function getDay($mdstr) {
		$dayofyear = array("0101"=>1, "0102"=>2, "0103"=>3, "0104"=>4, "0105"=>5, "0106"=>6, "0107"=>7, "0108"=>8, "0109"=>9, "0110"=>10, "0111"=>11, "0112"=>12, "0113"=>13, "0114"=>14, "0115"=>15, "0116"=>16, "0117"=>17, "0118"=>18, "0119"=>19, "0120"=>20, "0121"=>21, "0122"=>22, "0123"=>23, "0124"=>24, "0125"=>25, "0126"=>26, "0127"=>27, "0128"=>28, "0129"=>29, "0130"=>30, "0131"=>31,
											 "0201"=>32, "0202"=>33, "0203"=>34, "0204"=>35, "0205"=>36, "0206"=>37, "0207"=>38, "0208"=>39, "0209"=>40, "0210"=>41, "0211"=>42, "0212"=>43, "0213"=>44, "0214"=>45, "0215"=>46,"0216"=>47, "0217"=>48, "0218"=>49, "0219"=>50, "0220"=>51, "0221"=>52, "0222"=>53, "0223"=>54, "0224"=>55, "0225"=>56, "0226"=>57, "0227"=>58, "0228"=>59,
											 "0301"=>60, "0302"=>61, "0303"=>62, "0304"=>63, "0305"=>64, "0306"=>65, "0307"=>66, "0308"=>67, "0309"=>68, "0310"=>69, "0311"=>70, "0312"=>71, "0313"=>72, "0314"=>73, "0315"=>74, "0316"=>75, "0317"=>76, "0318"=>77, "0319"=>78, "0320"=>79, "0321"=>80, "0322"=>81, "0323"=>82, "0324"=>83, "0325"=>84, "0326"=>85, "0327"=>86, "0328"=>87, "0329"=>88, "0330"=>89, "0331"=>90,
											 "0401"=>91, "0402"=>92, "0403"=>93, "0404"=>94, "0405"=>95, "0406"=>96, "0407"=>97, "0408"=>98, "0409"=>99, "0410"=>100, "0411"=>101, "0412"=>102, "0413"=>103, "0414"=>104, "0415"=>105, "0416"=>106, "0417"=>107, "0418"=>108, "0419"=>109, "0420"=>110, "0421"=>111, "0422"=>112, "0423"=>113, "0424"=>114, "0425"=>115, "0426"=>116, "0427"=>117, "0428"=>118, "0429"=>119, "0430"=>120,
											 "0501"=>121, "0502"=>122, "0503"=>123, "0504"=>124, "0505"=>125, "0506"=>126, "0507"=>127, "0508"=>128, "0509"=>129, "0510"=>130, "0511"=>131, "0512"=>132, "0513"=>133, "0514"=>134, "0515"=>135, "0516"=>136, "0517"=>137, "0518"=>138, "0519"=>139, "0520"=>140, "0521"=>141, "0522"=>142, "0523"=>143, "0524"=>144, "0525"=>145, "0526"=>146, "0527"=>147, "0528"=>148, "0529"=>149, "0530"=>150, "0531"=>151,
											 "0601"=>152, "0602"=>153, "0603"=>154, "0604"=>155, "0605"=>156, "0606"=>157, "0607"=>158, "0608"=>159, "0609"=>160, "0610"=>161, "0611"=>162, "0612"=>163, "0613"=>164, "0614"=>165, "0615"=>166, "0616"=>167, "0617"=>168, "0618"=>169, "0619"=>170, "0620"=>171, "0621"=>172, "0622"=>173, "0623"=>174, "0624"=>175, "0625"=>176, "0626"=>177, "0627"=>178, "0628"=>179, "0629"=>180, "0630"=>181,
											 "0701"=>182, "0702"=>183, "0703"=>184, "0704"=>185, "0705"=>186, "0706"=>187, "0707"=>188, "0708"=>189, "0709"=>190, "0710"=>191, "0711"=>192, "0712"=>193, "0713"=>194, "0714"=>195, "0715"=>196, "0716"=>197, "0717"=>198, "0718"=>199, "0719"=>200, "0720"=>201, "0721"=>202, "0722"=>203, "0723"=>204, "0724"=>205, "0725"=>206, "0726"=>207, "0727"=>208, "0728"=>209, "0729"=>210, "0730"=>211, "0731"=>212,
											 "0801"=>213, "0802"=>214, "0803"=>215, "0804"=>216, "0805"=>217, "0806"=>218, "0807"=>219, "0808"=>220, "0809"=>221, "0810"=>222, "0811"=>223, "0812"=>224, "0813"=>225, "0814"=>226, "0815"=>227, "0816"=>228, "0817"=>229, "0818"=>230, "0819"=>231, "0820"=>232, "0821"=>233, "0822"=>234, "0823"=>235, "0824"=>236, "0825"=>237, "0826"=>238, "0827"=>239, "0828"=>240, "0829"=>241, "0830"=>242, "0831"=>243,
											 "0901"=>244, "0902"=>245, "0903"=>246, "0904"=>247, "0905"=>248, "0906"=>249, "0907"=>250, "0908"=>251, "0909"=>252, "0910"=>253, "0911"=>254, "0912"=>255, "0913"=>256, "0914"=>257, "0915"=>258, "0916"=>259, "0917"=>260, "0918"=>261, "0919"=>262, "0920"=>263, "0921"=>264, "0922"=>265, "0923"=>266, "0924"=>267, "0925"=>268, "0926"=>269, "0927"=>270, "0928"=>271, "0929"=>272, "0930"=>273,
											 "1001"=>274, "1002"=>275, "1003"=>276, "1004"=>277, "1005"=>278, "1006"=>279, "1007"=>280, "1008"=>281, "1009"=>282, "1010"=>283, "1011"=>284, "1012"=>285, "1013"=>286, "1014"=>287, "1015"=>288, "1016"=>289, "1017"=>290, "1018"=>291, "1019"=>292, "1020"=>293, "1021"=>294, "1022"=>295, "1023"=>296, "1024"=>297, "1025"=>298, "1026"=>299, "1027"=>300, "1028"=>301, "1029"=>302, "1030"=>303, "1031"=>304,
											 "1101"=>305, "1102"=>306, "1103"=>307, "1104"=>308, "1105"=>309, "1106"=>310, "1107"=>311, "1108"=>312, "1109"=>313, "1110"=>314, "1111"=>315, "1112"=>316, "1113"=>317, "1114"=>318, "1115"=>319, "1116"=>320, "1117"=>321, "1118"=>322, "1119"=>323, "1120"=>324, "1121"=>325, "1122"=>326, "1123"=>327, "1124"=>328, "1125"=>329, "1126"=>330, "1127"=>331, "1128"=>332, "1129"=>333, "1130"=>334,
											 "1201"=>335, "1202"=>336, "1203"=>337, "1204"=>338, "1205"=>339, "1206"=>340, "1207"=>341, "1208"=>342, "1209"=>343, "1210"=>344, "1211"=>345, "1212"=>346, "1213"=>347, "1214"=>348, "1215"=>349, "1216"=>350, "1217"=>351, "1218"=>352, "1219"=>353, "1220"=>354, "1221"=>355, "1222"=>356, "1223"=>357, "1224"=>358, "1225"=>359, "1226"=>360, "1227"=>361, "1228"=>362, "1229"=>363, "1230"=>364, "1231"=>365);
		
		return $dayofyear[$mdstr];
	}//end function
	
	function getLDay($mdstr) {
		$dayofbyear = array("0101"=>1, "0102"=>2, "0103"=>3, "0104"=>4, "0105"=>5, "0106"=>6, "0107"=>7, "0108"=>8, "0109"=>9, "0110"=>10, "0111"=>11, "0112"=>12, "0113"=>13, "0114"=>14, "0115"=>15, "0116"=>16, "0117"=>17, "0118"=>18, "0119"=>19, "0120"=>20, "0121"=>21, "0122"=>22, "0123"=>23, "0124"=>24, "0125"=>25, "0126"=>26, "0127"=>27, "0128"=>28, "0129"=>29, "0130"=>30, "0131"=>31,
											  "0201"=>32, "0202"=>33, "0203"=>34, "0204"=>35, "0205"=>36, "0206"=>37, "0207"=>38, "0208"=>39, "0209"=>40, "0210"=>41, "0211"=>42, "0212"=>43, "0213"=>44, "0214"=>45, "0215"=>46,"0216"=>47, "0217"=>48, "0218"=>49, "0219"=>50, "0220"=>51, "0221"=>52, "0222"=>53, "0223"=>54, "0224"=>55, "0225"=>56, "0226"=>57, "0227"=>58, "0228"=>59, "0229"=>60,
											  "0301"=>61, "0302"=>62, "0303"=>63, "0304"=>64, "0305"=>65, "0306"=>66, "0307"=>67, "0308"=>68, "0309"=>69, "0310"=>70, "0311"=>71, "0312"=>72, "0313"=>73, "0314"=>74, "0315"=>75, "0316"=>76, "0317"=>77, "0318"=>78, "0319"=>79, "0320"=>80, "0321"=>81, "0322"=>82, "0323"=>83, "0324"=>84, "0325"=>85, "0326"=>86, "0327"=>87, "0328"=>88, "0329"=>89, "0330"=>90, "0331"=>91,
											  "0401"=>92, "0402"=>93, "0403"=>94, "0404"=>95, "0405"=>96, "0406"=>97, "0407"=>98, "0408"=>99, "0409"=>100, "0410"=>101, "0411"=>102, "0412"=>103, "0413"=>104, "0414"=>105, "0415"=>106, "0416"=>107, "0417"=>108, "0418"=>109, "0419"=>110, "0420"=>111, "0421"=>112, "0422"=>113, "0423"=>114, "0424"=>115, "0425"=>116, "0426"=>117, "0427"=>118, "0428"=>119, "0429"=>120, "0430"=>121,
											  "0501"=>122, "0502"=>123, "0503"=>124, "0504"=>125, "0505"=>126, "0506"=>127, "0507"=>128, "0508"=>129, "0509"=>130, "0510"=>131, "0511"=>132, "0512"=>133, "0513"=>134, "0514"=>135, "0515"=>136, "0516"=>137, "0517"=>138, "0518"=>139, "0519"=>140, "0520"=>141, "0521"=>142, "0522"=>143, "0523"=>144, "0524"=>145, "0525"=>146, "0526"=>147, "0527"=>148, "0528"=>149, "0529"=>150, "0530"=>151, "0531"=>152,
											  "0601"=>153, "0602"=>154, "0603"=>155, "0604"=>156, "0605"=>157, "0606"=>158, "0607"=>159, "0608"=>160, "0609"=>161, "0610"=>162, "0611"=>163, "0612"=>164, "0613"=>165, "0614"=>166, "0615"=>167, "0616"=>168, "0617"=>169, "0618"=>170, "0619"=>171, "0620"=>172, "0621"=>173, "0622"=>174, "0623"=>175, "0624"=>176, "0625"=>177, "0626"=>178, "0627"=>179, "0628"=>180, "0629"=>181, "0630"=>182,
											  "0701"=>183, "0702"=>184, "0703"=>185, "0704"=>186, "0705"=>187, "0706"=>188, "0707"=>189, "0708"=>190, "0709"=>191, "0710"=>192, "0711"=>193, "0712"=>194, "0713"=>195, "0714"=>196, "0715"=>197, "0716"=>198, "0717"=>199, "0718"=>200, "0719"=>201, "0720"=>202, "0721"=>203, "0722"=>204, "0723"=>205, "0724"=>206, "0725"=>207, "0726"=>208, "0727"=>209, "0728"=>210, "0729"=>211, "0730"=>212, "0731"=>213,
											  "0801"=>214, "0802"=>215, "0803"=>216, "0804"=>217, "0805"=>218, "0806"=>219, "0807"=>220, "0808"=>221, "0809"=>222, "0810"=>223, "0811"=>224, "0812"=>225, "0813"=>226, "0814"=>227, "0815"=>228, "0816"=>229, "0817"=>230, "0818"=>231, "0819"=>232, "0820"=>233, "0821"=>234, "0822"=>235, "0823"=>236, "0824"=>237, "0825"=>238, "0826"=>239, "0827"=>240, "0828"=>241, "0829"=>242, "0830"=>243, "0831"=>244,
											  "0901"=>245, "0902"=>246, "0903"=>247, "0904"=>248, "0905"=>249, "0906"=>250, "0907"=>251, "0908"=>252, "0909"=>253, "0910"=>254, "0911"=>255, "0912"=>256, "0913"=>257, "0914"=>258, "0915"=>259, "0916"=>260, "0917"=>261, "0918"=>262, "0919"=>263, "0920"=>264, "0921"=>265, "0922"=>266, "0923"=>267, "0924"=>268, "0925"=>269, "0926"=>270, "0927"=>271, "0928"=>272, "0929"=>273, "0930"=>274,
											  "1001"=>275, "1002"=>276, "1003"=>277, "1004"=>278, "1005"=>279, "1006"=>280, "1007"=>281, "1008"=>282, "1009"=>283, "1010"=>284, "1011"=>285, "1012"=>286, "1013"=>287, "1014"=>288, "1015"=>289, "1016"=>290, "1017"=>291, "1018"=>292, "1019"=>293, "1020"=>294, "1021"=>295, "1022"=>296, "1023"=>297, "1024"=>298, "1025"=>299, "1026"=>300, "1027"=>301, "1028"=>302, "1029"=>303, "1030"=>304, "1031"=>305,
											  "1101"=>306, "1102"=>307, "1103"=>308, "1104"=>309, "1105"=>310, "1106"=>311, "1107"=>312, "1108"=>313, "1109"=>314, "1110"=>315, "1111"=>316, "1112"=>317, "1113"=>318, "1114"=>319, "1115"=>320, "1116"=>321, "1117"=>322, "1118"=>323, "1119"=>324, "1120"=>325, "1121"=>326, "1122"=>327, "1123"=>328, "1124"=>329, "1125"=>330, "1126"=>331, "1127"=>332, "1128"=>333, "1129"=>334, "1130"=>335,
											  "1201"=>336, "1202"=>337, "1203"=>338, "1204"=>339, "1205"=>340, "1206"=>341, "1207"=>342, "1208"=>343, "1209"=>344, "1210"=>345, "1211"=>346, "1212"=>347, "1213"=>348, "1214"=>349, "1215"=>350, "1216"=>351, "1217"=>352, "1218"=>353, "1219"=>354, "1220"=>355, "1221"=>356, "1222"=>357, "1223"=>358, "1224"=>359, "1225"=>360, "1226"=>361, "1227"=>362, "1228"=>363, "1229"=>364, "1230"=>365, "1231"=>366);
		
		return $dayofbyear[$mdstr];
	}//end function
	
	function suffix($dn) {
		$a_suffix = str_ireplace("DC=", "@", $dn);
		$a_suffix = str_ireplace(",DC=", ".", $dn);
		
		return $a_suffix;
	}//end function
?>