<?php
require 'class_connection.php';
class crawler extends SqlTool{
	public function Curl_st($url)//170814判斷ip有無被鎖
	{
		    $privateip='';
		    $JsonFile=$this->Curl_content($privateip,$url);
			return $this->de_json_gistaiwan($JsonFile);
	}
			   
	public function Curl_content($privateip,$url)//170814判斷ip有無被鎖
	{
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				    $JsonFile = curl_exec($ch);
					curl_close($ch);
					return $JsonFile;
	}

	public function de_json_gistaiwan($JsonFile){
		header('Content-Type: application/json; charset=utf-8');
	    $Jsonarr = json_decode($this->removeBOM($JsonFile),true);
	    //var_dump($Jsonarr);
	    $this->arrjson($Jsonarr);
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

		for($i=0;$i<count($Jsonarr['XML_Head']['Infos']['Info']);$i++){
	    	    $city[$i]=$this->city($Jsonarr['XML_Head']['Infos']['Info'][$i]['Add']);
	    	    $area[$i]=$this->area($Jsonarr['XML_Head']['Infos']['Info'][$i]['Add']);
	    	    $address[$i]=$Jsonarr['XML_Head']['Infos']['Info'][$i]['Add'];
	    	    $class1[$i]=$this->class1($Jsonarr['XML_Head']['Infos']['Info'][$i]['Class1']);
	    	    $class2[$i]=$this->class1($Jsonarr['XML_Head']['Infos']['Info'][$i]['Class2']);
	    	    $class3[$i]=$this->class1($Jsonarr['XML_Head']['Infos']['Info'][$i]['Class3']);
	    	    $spotname[$i]=$this->repstr($Jsonarr['XML_Head']['Infos']['Info'][$i]['Name']);
	    	    $opentime[$i]=$Jsonarr['XML_Head']['Infos']['Info'][$i]['Opentime'];
	    	    $description[$i]['description']=$Jsonarr['XML_Head']['Infos']['Info'][$i]['Description'];

				$info[$i]['Level']=$this->Level($Jsonarr['XML_Head']['Infos']['Info'][$i]['Level']);
	    	    $info[$i]['picture1']=$Jsonarr['XML_Head']['Infos']['Info'][$i]['Picture1'];
	    	    $info[$i]['picture2']=$Jsonarr['XML_Head']['Infos']['Info'][$i]['Picture2'];
	    	    $info[$i]['picture3']=$Jsonarr['XML_Head']['Infos']['Info'][$i]['Picture3'];			   
	    	    $px[$i]['px']=$Jsonarr['XML_Head']['Infos']['Info'][$i]['Px'];
	    	    $py[$i]['py']=$Jsonarr['XML_Head']['Infos']['Info'][$i]['Py'];
	    	    $info[$i]['tel']=$Jsonarr['XML_Head']['Infos']['Info'][$i]['Tel'];
	    	    $ticketinfo[$i]['ticketinfo']=$Jsonarr['XML_Head']['Infos']['Info'][$i]['Ticketinfo'];
	    	    $toldescribe[$i]['toldescribe']=$Jsonarr['XML_Head']['Infos']['Info'][$i]['Toldescribe'];
	    	    $travellinginfo[$i]['travellinginfo']=$Jsonarr['XML_Head']['Infos']['Info'][$i]['Travellinginfo'];
	    	    $de_jsoninfo[$i]=json_encode($info[$i]);
	    	    $check['$i']=$city[$i].$area[$i].$address[$i].$class1[$i].$class2[$i].$class3[$i].$spotname[$i].$opentime[$i].$de_jsoninfo[$i];
	    	    $checkinfoupdate[$i]=md5($check['$i']);
	    	    $this->CUspotdata($city[$i],$area[$i],$address[$i],$class1[$i],$class2[$i],$class3[$i],$spotname[$i],$opentime[$i],$de_jsoninfo[$i],$checkinfoupdate[$i],$description[$i]['description'], $px[$i]['px'], $py[$i]['py'],$ticketinfo[$i]['ticketinfo'],$toldescribe[$i]['toldescribe'],$travellinginfo[$i]['travellinginfo']);
	    }
	}
	private function CUspotdata($city,$area,$address,$class1,$class2,$class3,$spotname,$opentime,$info,$checkinfoupdate,$description,$px,$py,$ticketinfo,$toldescribe,$travellinginfo){
		$search['spotname']=$spotname;
		$search['checkupdate']=$checkinfoupdate;
	
			    echo $sql="UPDATE `spot` SET `checkupdate`='$checkinfoupdate' ,`info`='$info',`px`='$px',`py`='$py',`ticketinfo`='$ticketinfo',`toldescribe`='$toldescribe' ,`travellinginfo`='$travellinginfo' where  spotname='$spotname'";
				$re=$this->execute_dml($sql);
				//$arrow=$this->Rspotdata('searchspid',$search);
				//var_dump($arrow);
				//$spid='';
				/////$spid=$arrow[0]['spid'];
 			    //$sql2="INSERT INTO `spot_tag`(`spid`,`description`) VALUES ('$spid','$description')";
		    	//$re2=$this->execute_dml($sql2);

		
	}
	public function Rspotdata($type,$search){
		$arr_row=array();
		switch ($type){
			case 'searchspotname':  $sql="select spotname from spot where spotname='$search[spotname]'";break;
			case 'searcheckupdate': $sql="select checkupdate from spot where checkupdate='$search[checkupdate]'";break;
			case 'Readcity': $sql="select city from spot group by city";break;
			case 'searcharea':  $sql="select city,area from spot where city ='$search[city]' group by city,area";break;
			case 'searchspot':  $sql="select * from spot where city ='$search[city]' and area ='$search[area]'";break;
			case 'searchspid':  $sql="select spid from spot where spotname ='$search[spotname]'";break;



		}
		 $result=$this->execute_dql($sql);
	     while($row=Mysqli_fetch_array($result)){
	     	$arr_row[]=$row;
		 }
		return $arr_row;
	}

	private function repstr($TestStr){
		 $str=preg_replace('/\s(?=)/', '', $TestStr);
		 return $str;
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