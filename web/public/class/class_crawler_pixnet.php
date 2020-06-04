<?php
require 'class_connection.php';
class crawlerPixnet extends SqlTool{
	//function __construct($url){
		//return $this->Curl_st($url);
	//}

	public function Curl_st($url)//170814判斷ip有無被鎖
	{
		//for($i=255;$i>=254;$i--){
			//$privateip='172.31.5.'.$i;
		    $privateip='';
		    $JsonFile=$this->Curl_content($url);
			//if(! empty($JsonFile)){
				// return $JsonFile;
			 //}
		//}
			return $this->de_json_gistaiwan($JsonFile);
		//return $JsonFile;
	}

	public function Curl_content($url)//170814判斷ip有無被鎖
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

}

?>