<?php
require 'class_connection.php';
class crawler extends SqlTool{
	//function __construct($url){
		//return $this->Curl_st($url);
	//}
	
	public function Curl_st($url)//170814判斷ip有無被鎖
	{
		//for($i=255;$i>=254;$i--){
			//$privateip='172.31.5.'.$i;
		    $privateip='';
		    $JsonFile=$this->Curl_content($privateip,$url);
			//if(! empty($JsonFile)){
				// return $JsonFile;  
			 //}            
		//}
			return $this->de_json_gistaiwan($JsonFile);
		//return $JsonFile; 
	}
			   
	public function Curl_content($privateip,$url)//170814判斷ip有無被鎖
	{
		//$agent= 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36';
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					//curl_setopt($ch, CURLOPT_TIMEOUT, 5);
					//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
					//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					//curl_setopt($ch, CURLOPT_USERAGENT, $agent);
					//curl_setopt($ch, CURLOPT_INTERFACE, $privateip);
				    $JsonFile = curl_exec($ch);
					curl_close($ch);
					return $JsonFile;
	}

	public function de_json_gistaiwan($JsonFile){
		header('Content-Type: application/json; charset=utf-8');
	    $Jsonarr = json_decode($this->removeBOM($JsonFile),true);
	    $this->arrjson($Jsonarr);
	    //var_dump($Jsonarr);
	    //echo json_last_error() . "\n"; // 4
		//echo json_last_error_msg() . "\n"; // Syntax error, malformed JSO
			
	}
    private function removeBOM($str = '')
	{
	    if (substr($str, 0,3) == pack("CCC",0xef,0xbb,0xbf))
	        $str = substr($str, 3);

	    return $str;
	}

	private function city($string){
		 $restr=mb_substr( $string,0,3,"utf-8");
		 if(preg_match("/\d/", $restr)){
		 	return mb_substr( $string,3,3,"utf-8");
		 }else{
		 	return $restr;
		 }

	}
	private function area($string){
		 $restr=mb_substr( $string,6,3,"utf-8");
		 $rest2r=mb_substr( $string,3,1,"utf-8");
		 if(!preg_match("/\d/", $rest2r)){
		 	return mb_substr( $string,3,3,"utf-8");
		 }else{
		 	return $restr;
		 }

	}
	private function arrjson($Jsonarr){

		for($i=0;$i<count($Jsonarr['Infos']['Info']);$i++){
	    	    $city[$i]=$this->city($Jsonarr['Infos']['Info'][$i]['Add']);
	    	    $area[$i]=$this->area($Jsonarr['Infos']['Info'][$i]['Add']);
	    	    $address[$i]=$Jsonarr['Infos']['Info'][$i]['Add'];
	    	    $class1[$i]=$this->class1($Jsonarr['Infos']['Info'][$i]['Class1']);
	    	    $class2[$i]=$this->class1($Jsonarr['Infos']['Info'][$i]['Class2']);
	    	    $class3[$i]=$this->class1($Jsonarr['Infos']['Info'][$i]['Class3']);
	    	    $spotname[$i]=$Jsonarr['Infos']['Info'][$i]['Name'];
	    	    $opentime[$i]=$Jsonarr['Infos']['Info'][$i]['Opentime'];
				
				$info[$i]['Level']=$this->Level($Jsonarr['Infos']['Info'][$i]['Level']);
	    	    $info[$i]['description']=$Jsonarr['Infos']['Info'][$i]['Description'];
	    	    $info[$i]['picture1']=$Jsonarr['Infos']['Info'][$i]['Picture1'];
	    	    $info[$i]['picture2']=$Jsonarr['Infos']['Info'][$i]['Picture2'];
	    	    $info[$i]['picture3']=$Jsonarr['Infos']['Info'][$i]['Picture3'];			   
	    	    $info[$i]['px']=$Jsonarr['Infos']['Info'][$i]['Px'];
	    	    $info[$i]['py']=$Jsonarr['Infos']['Info'][$i]['Py'];
	    	    $info[$i]['tel']=$Jsonarr['Infos']['Info'][$i]['Tel'];
	    	    $info[$i]['ticketinfo']=$Jsonarr['Infos']['Info'][$i]['Ticketinfo'];
	    	    $info[$i]['toldescribe']=$Jsonarr['Infos']['Info'][$i]['Toldescribe'];
	    	    $info[$i]['travellinginfo']=$Jsonarr['Infos']['Info'][$i]['Travellinginfo'];
	    	    $de_jsoninfo[$i]=json_encode($info[$i]);
	    	    $check['$i']=$city[$i].$area[$i].$address[$i].$class1[$i].$class2[$i].$class3[$i].$spotname[$i].$opentime[$i].$de_jsoninfo[$i];
	    	    $checkinfoupdate[$i]=md5($check['$i']);
	    	    $this->CUspotdata($city[$i],$area[$i],$address[$i],$class1[$i],$class2[$i],$class3[$i],$spotname[$i],$opentime[$i],$de_jsoninfo[$i],$checkinfoupdate[$i]);
	    }
	}
	private function CUspotdata($city,$area,$address,$class1,$class2,$class3,$spotname,$opentime,$info,$checkinfoupdate){
		$search['spotname']=$spotname;
		$search['checkupdate']=$checkinfoupdate;
		if($spotname!=@$this->Rspotdata('searchspotname',$search)[0]['spotname']){

		     echo $sql="INSERT INTO `spot`(`city`,`area`,`address`,`class1`,`class2`,`class3`,`spotname`,`opentime`,`info`,`checkupdate`,`source`) VALUES ('$city','$area','$address','$class1','$class2','$class3','$spotname','$opentime','$info','$checkinfoupdate','datagovtw')";
		    $re=$this->execute_dml($sql);
		}else{
			if($checkinfoupdate!=@$this->Rspotdata('searcheckupdate',$search)[0]['checkupdate']){
				echo $sql="UPDATE `spot` SET `city`='$city',`area`='$area',`address`='$address',`class1`='$class1',`class2`='$class2',`class3`='$class3',`opentime`='$opentime',`info`='$info',`checkupdate`='$checkinfoupdate' where  spotname='$spotname'";
				$re=$this->execute_dml($sql);
			}
		}
	}
	public function Rspotdata($type,$search){
		$arr_row=array();
		switch ($type){
			case 'searchspotname':  $sql="select spotname from spot where spotname='$search[spotname]'";break;
			case 'searcheckupdate': $sql="select checkupdate from spot where checkupdate='$search[checkupdate]'";break;
			case 'Readcity': $sql="select city from spot group by city";break;
			case 'searcharea':  $sql="select city,area from spot where city ='$search[city]' group by city,area";break;
			case 'searchspot':  $sql="select * from spot where city ='$search[city]' and area ='$search[area]'";break;
			case 'allspot':  $sql="select * from spot as s inner join spot_tag as st on s.spid=st.spid";break;
			case 'choicecity':  $sql="select city from spot as s group by city ";break;
			case 'choicearea':  $sql="select city,area from spot as s where city='$search[city]' group by area ";break;
			case 'choiceclass1':  $sql="SELECT class1 FROM `spot`  group by class1 order by class1";break;
			case 'choiceclass2':  $sql="SELECT class2 FROM `spot` where class2 <> '' group by class2 order by class2";break;
			case 'choiceclass3':  $sql="SELECT class3 FROM `spot` where class3 <> '' group by class3 order by class3";break;
			case 'choiceclass1a':  $sql="SELECT class1 FROM `spot` where city ='$search[city]' and area ='$search[area]' group by class1 order by class1";break;
			case 'choiceclass2a':  $sql="SELECT class2 FROM `spot` where city ='$search[city]' and area ='$search[area]' and class2 <> '' group by class2 order by class2";break;
			case 'choiceclass3a':  $sql="SELECT class3 FROM `spot` where city ='$search[city]' and area ='$search[area]' and class3 <> '' group by class3 order by class3";break;
			case 'cityspot':  $sql="select * from spot as s  inner join spot_tag as st on s.spid=st.spid where city='$search[city]'";break;
			case 'areaspot':  $sql="select * from spot as s inner join spot_tag as st on s.spid=st.spid where area='$search[area]'";break;
			
		}
		//echo $sql;
		 $result=$this->execute_dql($sql);
	     while($row=Mysqli_fetch_array($result)){
	     	$arr_row[]=$row;
		 }
		return $arr_row;
	}

	

	private function class1($c1){
		switch ($c1){
			case 1: return '文化'; break;
			case 2: return '生態'; break;
			case 3: return '古蹟'; break;
			case 4: return '廟宇'; break;
			case 5: return '藝術'; break;
			case 6: return '小吃/特產'; break;
			case 7: return '國家公園'; break;
			case 8: return '國家風景'; break;
			case 9: return '休閒農業'; break;
			case 10: return '溫泉'; break;
			case 11: return '自然風景'; break;
			case 12: return '遊憩'; break;
			case 13: return '體育健身'; break;
			case 14: return '觀光工廠'; break;
			case 15: return '都會公園'; break;
			case 16: return '森林遊樂區'; break;
			case 17: return '林場'; break;
			case 18: return '其他'; break;
			default: return ''; break;
		}
		
	}
	private function Level($l1){
		switch ($l1){
			case 1: return '一級'; break;
			case 2: return '二級'; break;
			case 3: return '三級'; break;
			case 4: return '國定'; break;
			case 5: return '直轄市定'; break;
			case 6: return '縣(市)定'; break;
			case 9: return '非古蹟'; break;
			default: return ''; break;
		}
		
	}

}

?>