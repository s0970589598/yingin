<?php
	$qid=$_POST['qid'];
	$rid=$_POST['rid'];

	$rid1='';
	$rid2='';
	$rid3='';
	$rid4='';
	$rid5='';
	$rid6='';
	$rid7='';
	$cookie_name='choice';
	if(isset($_COOKIE[$cookie_name])){
		$decode=json_decode($_COOKIE[$cookie_name],true);
		$rid1=$decode['q1'];
		$rid2=$decode['q2'];
		$rid3=$decode['q3'];
		$rid4=$decode['q4'];
		$rid5=$decode['q5'];
		$rid6=$decode['q6'];
		$rid7=$decode['q7'];
		$city=$decode['city'];
	}

	if($_POST['sta']=='add'){
		if($qid=='q1'){
			$rid1=$rid;
		}elseif($qid=='q2'){
			$rid2=$rid;
		}elseif($qid=='q3'){
			$rid3=$rid;
		}elseif($qid=='q4'){
			$rid4=$rid;
		}elseif($qid=='q5'){
			$rid5=$rid;
		}elseif($qid=='q6'){
			$rid6=$rid;
		}elseif($qid=='q7'){
			$rid7=$rid;
		}elseif($qid=='city'){
			$city=$rid;

		}


	}elseif($_POST['sta']=='del'){
		if($qid=='q1'){
			$rid1='';
		}elseif($qid=='q2'){
			$rid2='';
		}elseif($qid=='q3'){
			$rid3='';
		}elseif($qid=='q4'){
			$rid4='';
		}elseif($qid=='q5'){
			$rid5='';
		}elseif($qid=='q6'){
			$rid6='';
		}elseif($qid=='q7'){
			$rid7='';
		}

	}
	$choice=array("city"=>$city,"q1"=>$rid1,"q2"=>$rid2,"q3"=>$rid3,"q4"=>$rid4,"q5"=>$rid5,"q6"=>$rid6,"q7"=>$rid7);

	header('Content-Type: application/json; charset=utf-8');
    echo $json=json_encode($choice);
	
	setcookie($cookie_name, $json, time() + (86400 * 30), "/"); // 86400 = 1 day
	

?>