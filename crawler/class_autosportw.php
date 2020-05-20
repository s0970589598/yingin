<?php
	class sport_tw{
		public function sport_tw_game(){
			$this->sport_tw_numofgame();
		}
		private function sport_tw_numofgame(){
			echo $json_url = 'https://www.sportslottery.com.tw/web/services/rs/betting/activeCategories/15102/0.json?locale=tw&brandId=defaultBrand&channelId=1';
			$JsonFile=$this->Curl($json_url);
			$Jsonarr = json_decode($JsonFile,true);
			for($i=0;$i<count($Jsonarr);$i++)
			{
				$categorId = $Jsonarr[$i]["categoryId"];
				$name = $Jsonarr[$i]["name"];
				$numOfGames = $Jsonarr[$i]["numOfGames"];
				$numOfNormalGames =  $Jsonarr[$i]["numOfNormalGames"];
				echo '<a href="/upgamev1/sportlotterytw_game.php?givecatid='.$categorId.'">'.$name.'</a>&nbsp;&nbsp;&nbsp;&nbsp;';
			}
			echo'<br>';	echo'<br>';
		}
			public function sport_tw_num2(){
				$json_url = 'https://www.sportslottery.com.tw/web/services/rs/betting/activeCategories/15102/0.json?locale=tw&brandId=defaultBrand&channelId=1';
				$JsonFile=$this->Curl($json_url);
				$Jsonarr = json_decode($JsonFile,true);
					for($i=0;$i<count($Jsonarr);$i++)
					{
						$categorId = $Jsonarr[$i]["categoryId"];
						$name = $Jsonarr[$i]["name"];
						$numOfGames = $Jsonarr[$i]["numOfGames"];
						$numOfNormalGames =  $Jsonarr[$i]["numOfNormalGames"];
						if($categorId=='s-441' or $categorId=='s-442' or $categorId=='s-443' or $categorId=='s-445' or $categorId=='s-447' or $categorId=='s-647') {
							$this->GetCateIDGame($categorId,$numOfGames,$name);
						}
					}
			}
			private function GetCateIDGame($CateID , $numGames,$aclass)
			{
				date_default_timezone_set("Asia/Taipei");
				$updatetime=date("Y-m-d H:i:s");
				include('connection.php');
				$startrun=0;
				$upstart=0;
				 $url = 'https://www.sportslottery.com.tw/web/services/rs/betting/games/15102/0.json?status=active&limit='.$numGames.'&action=excludeTournamentWithExceptionPriority&marketLimit=1&sportId='.$CateID.'&locale=tw&brandId=defaultBrand&channelId=1';
				$numFile = $this->Curl($url);
				$numarr = json_decode($numFile ,true);
				$finalstart=count($numarr);
				$sql32 = "SELECT	arnum,categoryId FROM `gamesc` WHERE categoryId='$CateID'";
				$result32 = mysqli_query($database_link,$sql32) or die(mysqli_error());
				$row32 = mysqli_fetch_assoc($result32);
				$count_32=mysqli_num_rows($result32);
				if($CateID=='s-441' and $finalstart>=30){
					echo '*';
						if($row32['arnum']>=$finalstart){
							$startrun=0;
							$upstart=0;
							$finalstart=ceil($finalstart/2);
						}else{
							if($row32['arnum']==0){
								$startrun=0;
								$upstart=ceil($numGames/2);
								$finalstart=ceil($numGames/2);
							}else{
								$startrun=$row32['arnum'];
								$upstart=0;
								$finalstart=count($numarr);
							}
						}
					if($count_32==0){
						 $sqla62 = "INSERT INTO `gamesc`(`categoryId`,`name`,`date`,`numOfGames`,`json`,`arnum`) VALUES('$CateID','$aclass','$updatetime','$numGames','$numFile','')";
						mysqli_query($database_link,$sqla62);
					}else{
						  $sqla62 = "UPDATE `gamesc` SET `arnum` = '$upstart',`date` = '$updatetime' ,`numOfGames`='$numGames' where   categoryId='$CateID' ";
						mysqli_query($database_link,$sqla62);
					}
				
				}
				//var_dump($numarr);
				for ($i=$startrun ; $i < $finalstart; $i++) {
						$ni = $numarr[$i]["ni"];
						$num = $numarr[$i]["num"];
						$code = $numarr[$i]["code"];
						$status = $numarr[$i]["status"];
						if (!  empty($numarr[$i]["markets"]))
						{
							$mins = $numarr[$i]["markets"][0]["mins"];
						}else {
							$mins='';
						}
						$kdt = substr($numarr[$i]["kdt"], 0, 10);        //開賣時間
						//$edt = substr($numarr[$i]["markets"][0]["edt"], 0, 10);        //停賣時間
						//$realtime = date("Y-m-d H:i:s", $edt);
						$Catchtime = date("Y-m-d H:i:s");
						$adate=date("Y-m-d",$kdt);
						$ah=date("H",$kdt);
						$aii=date("i",$kdt);
						$lv = $numarr[$i]["lv"];
						$ti = $numarr[$i]["ti"];        //聯賽編號
						$ci = $numarr[$i]["ci"];        //國家編號
						$ai = $numarr[$i]["ai"];        //客編號
						$hi = $numarr[$i]["hi"];        //主編號
						$hteam = $numarr[$i]["lexicon"]["resources"][$hi];        //主隊
						$ateam = $numarr[$i]["lexicon"]["resources"][$ai];        //客隊
						if (!  empty($numarr[$i]["competitors"]["a"])) {
							$ap = $numarr[$i]["competitors"]["a"];
							$hp = $numarr[$i]["competitors"]["h"];
							$apitch = $numarr[$i]["lexicon"]["resources"][$ap];
							$hpitch = $numarr[$i]["lexicon"]["resources"][$hp];
						}else{
							$apitch = '';
							$hpitch='';
						}

					$Cate = $numarr[$i]["lexicon"]["resources"][$ti];        //聯賽名稱
						$Country = $numarr[$i]["lexicon"]["resources"][$ci];//國家名稱
						if($numarr[$i]["lv"]=='true'){
							 $midle= 'midle';
						}else{
							 $midle='';
						}

						if($mins==1){
							 $single='single';
						}else{
							 $single='';
						}
						$this->GetgameHandicap($ni,$kdt,$code,$hteam,$ateam,$adate,$ah,$aii,$aclass,$Cate,$ateam,$hteam,$midle,$single,$apitch,$hpitch);
				}
			}

			private function GetgameHandicap($ni,$kdt,$code,$hteam,$ateam,$adate,$ah,$aii,$aclass,$Cate,$ateam,$hteam,$midle,$single,$apitch,$hpitch)
			{
				$sclet='';
				$scletpa='';
				$shlet='';
				$shletpa='';
				$scnotletpa='';
				$spnotletpa='';
				$shnotletpa='';
				$scbigs='';
				$scbigspa='';
				$shbigs='';
				$shbigspa='';
				echo $adate.'&nbsp;&nbsp;'.$ah.':'.$aii;
				echo $Cate;
				echo $single.$midle;
				echo $code;
				echo $hteam;
				echo $ateam;
				echo $apitch,$hpitch;
				//echo $kdttime;
				echo '<br>';
				$url ="https://www.sportslottery.com.tw/web/services/rs/betting/games/15102/0.json?eventMethods=1&eventMethods=2&nevIds=".$ni."&locale=tw&brandId=defaultBrand&channelId=1";
				$num_handicap = $this->Curl($url);
				$num_hand_arr = json_decode($num_handicap ,true);
				//var_dump($num_hand_arr);
				$now1=date("Y-m-d",strtotime("+1 day"));
				foreach ($num_hand_arr as $value)
				{
					$timeux=number_format($value["kdt"],3,'.','');
					$currenttime = substr( $timeux ,0,10 );
					$gameday = date("Y年m月d日",$currenttime);
					$gametime = date("H:i",$currenttime);
					$gameweek = date("w",$currenttime);
					$adate=date("Y-m-d",$currenttime);
					$ah=date("H",$currenttime);
					$ai=date("i",$currenttime);
 					$si=$value["si"];
					$ti=$value["ti"];
					$sta_val=$value['status'];
					echo $now1.'***';
					if($adate<=$now1){//只抓今明天的
					foreach ($value["markets"] as $key2 => $value2)
					{
						$fi = $value2["fi"];
						$v1 = $value2["v1"];
						$g = $value2["g"];
						$i = $value2["i"];
						if(is_array($value2))
							foreach ($value2["codes"] as $key3 => $value3)
							{
								if(is_array($value3))
								{
									$count = count($value3);
									$hodds= $value2["codes"][0]["oddPerSet"]["1"];
									$aodds= $value2["codes"][1]["oddPerSet"]["1"];
									if(! empty($value2["codes"][2]["oddPerSet"]["1"])){
										$podds= $value2["codes"][2]["oddPerSet"]["1"];
									}else{
										$podds='';
									}
									$c1 = $value2["codes"][0]["c"];//玩法
									$c2 = $value2["codes"][1]["c"];
									if(! empty($value2["codes"][2]["c"])){
										$c3= $value2["codes"][2]["c"];
									}else{
										$c3='';
									}
								}
							}else{
							break;
						}
						if($si=='s-442'){
							$spnotletpa='';
						}
						if($c1==447 or $c2==447 or $c3==447){
							if($v1 !=0){//判斷有無讓分
								if($v1 > 0){
									$odd="-";
								}else{
									$odd="+";
								}
								echo '客讓:'.$hodds."(".$odd.abs($v1).")";
								$sclet=$odd.abs($v1);
								$scletpa=$hodds;
							}
						}
						if($c1==445 or $c2==445 or $c3==445){
							if($v1 !=0){//判斷有無讓分
								if($v1>0){
									$odd2="+";
								}else{
									$odd2="-";
								}
								if($c1==446 or $c2==446 or $c3==446){
									echo '主讓:'.$podds."(".$odd2.abs($v1).")***";
									echo '<br>';
									$shlet=$odd2.abs($v1);
									$shletpa=$podds;

								}else{
									echo '主讓:'.$aodds."(".$odd2.abs($v1).")---";
									echo '<br>';
									$shlet=$odd2.abs($v1);
									$shletpa=$aodds;
								}
							}
						}
						if($c1==446 or $c2==446 or $c3==446){
									echo '讓和:'.$aodds;
									echo '<br>';
									$spletpa=$aodds;
						}
						if($c1==402or $c2==402 or $c3==402){
							echo '客不讓分:'.$hodds;
							$scnotletpa=$hodds;
						}
						if($c1==401 or $c2==401 or $c3==401){
							echo '不讓分和:'.$aodds;
							$spnotletpa=$aodds;

						}
						if($c1==400 or $c2==400 or $c3==400){
							if($c1==401 or $c2==401 or $c3==401){
								echo '主不讓分:'.$podds;
								echo '<br>';
								$shnotletpa=$podds;
							}else{
								echo '主不讓分:'.$aodds;
								echo '<br>';
								$shnotletpa=$aodds;
								$spnotletpa='';
							}
						}
						if($c1==471 or $c2==471 or $c3==471){
							if($v1 !=0){//判斷有無讓分
								echo '大:'.$hodds."(".$v1.")";
								$scbigs=$v1;
								$scbigspa=$hodds;
							}
						}
						if($c1==472 or $c2==472 or $c3==472){
							if($v1 !=0){//判斷有無讓分
								echo '小:'.$aodds."(".$v1.")";
								echo '<br>';
								$shbigs=$v1;
								$shbigspa=$aodds;
							}
						}
						if($c1==475 or $c2==475 or $c3==475){//原478 5.5 now 4.5
							if($v1 !=0){//判斷有無讓分
								echo '大:'.$hodds."(".$v1.")";
								$scbigs=$v1;
								$scbigspa=$hodds;
							}
						}
						if($c1==476 or $c2==476 or $c3==476){//原477 5.5 now 4.5
							if($v1 !=0){//判斷有無讓分
								echo '小:'.$aodds."(".$v1.")";
								echo '<br>';
								$shbigs=$v1;
								$shbigspa=$aodds;
							}
						}
					}
					
					$this->addata($si,$ti,$ni,$kdt,$num_handicap,$code,$hteam,$ateam,$adate,$ah,$aii,$aclass,$Cate,$ateam,$hteam,$midle,$single,$sclet,$scletpa,$scnotletpa,$scbigs,$scbigspa,$shlet,$shletpa,$shnotletpa,$spnotletpa,$shbigs,$shbigspa,$sta_val,$apitch,$hpitch,$spletpa);
				echo $sta_val;
					}//只抓今明天的
				}
			}
			private function addata($si,$ti,$ni,$kdt,$num_handicap,$code,$hteam,$ateam,$adate,$ah,$aii,$aclass,$Cate,$ateam,$hteam,$midle,$single,$sclet,$scletpa,$scnotletpa,$scbigs,$scbigspa,$shlet,$shletpa,$shnotletpa,$spnotletpa,$shbigs,$shbigspa,$sta_val,$apitch,$hpitch,$spletpa)
			{
				 include('connection.php');
				echo '$ni'.$ni;
				$sql3 = "SELECT * FROM `gass1analysis` WHERE `ni` = '$ni' and `adate`='$adate'";
				$result4 = mysqli_query($database_link,$sql3) or die(mysqli_errno());
				$row4=mysqli_fetch_assoc($result4);
				$count=mysqli_num_rows($result4);
					if ($count == 0)
					{
						$aname=$ateam.'vs'.$hteam;
						$sql5 = "INSERT INTO `gass1analysis`(`si`,`ti`,`gameid`,`midle`,`single`,`aname`,`adate`,`ah`,`ai`,`aclass`,`aclass2`,`upteam`,`underteam`,`sclet`,`scletpa`,`scnotletpa`,`scbigs`,`scbigspa`,`shlet`,`shletpa`,`shnotletpa`,`spnotletpa`,`shbigs`,`shbigspa`,`sclet1`,`scletpa1`,`scnotletpa1`,`scbigs1`,`scbigspa1`,`shlet1`,`shletpa1`,`shnotletpa1`,`spnotletpa1`,`shbigs1`,`shbigspa1`,`bet_json`,`kdt`,`status`,`ni`,`CPIT`,`HPIT`,`spletpa`,`spletpa1`) VALUES
						  ('$si','$ti','$code','$midle','$single','$aname','$adate','$ah','$aii','$aclass','$Cate','$ateam','$hteam','$sclet','$scletpa','$scnotletpa','$scbigs','$scbigspa','$shlet','$shletpa','$shnotletpa','$spnotletpa','$shbigs','$shbigspa','$sclet','$scletpa','$scnotletpa','$scbigs','$scbigspa','$shlet','$shletpa','$shnotletpa','$spnotletpa','$shbigs','$shbigspa','$num_handicap','$kdt','$sta_val','$ni','$apitch','$hpitch','$spletpa','$spletpa')";
						mysqli_query($database_link,$sql5);
					}else {
						if($num_handicap != $row4['bet_json'])
						{
							//更新
							if($row4['spletpa1']==''){
								$sqlspletp1=",`spletpa1`='$spletpa'";
							}
							echo $sql = "UPDATE `gass1analysis` SET `single`='$single',`midle`='$midle',`bet_json` = '$num_handicap',`status` = '$sta_val',`kdt` = '$kdt' ,`sclet`='$sclet',`scletpa`=$scletpa,`scnotletpa`='$scnotletpa',`scbigs`='$scbigs',`scbigspa`='$scbigspa',`shlet`='$shlet',`shletpa`='$shletpa',`shnotletpa`='$shnotletpa',`spnotletpa`='$spnotletpa',`shbigs`='$shbigs',`shbigspa`='$shbigspa',`CPIT`='$apitch',`HPIT`='$hpitch',`spletpa`='$spletpa' $sqlspletp1 WHERE `ni` = '$ni' and (`status` != 'completed' or `status` != 'cancelled') ";
						mysqli_query($database_link,$sql);
						}
					}
					mysqli_close($database_link);
			}

			public function autosportwscore($givecatid,$ti){
				$date=1;
				$finale=$this->pagescore($givecatid,$ti);
				for($page=1;$page<=$finale;$page++){
					$hotgame_url= "https://www.sportslottery.com.tw/web/services/rs/betting/results/15102/" . $date . ".json?sportId=" . $givecatid . "&tournamentId=".$ti."&page=".$page."&locale=tw&brandId=defaultBrand&channelId=1";
					$hotgame=$this->Curl($hotgame_url);
					$hotg = json_decode($hotgame, true);
					$this->decodescore2($hotg);
				}
				
			}
				private function pagescore($si,$ti){
				date_default_timezone_set("Asia/Taipei");
				$date=date('Y-m-d');
				include 'connection.php';
				$chkactive = "SELECT aclass,aid,si FROM `gass1analysis` WHERE adate='$date' and si='$si' and ti='$ti'";
				$resultactive = mysqli_query( $database_link,$chkactive) or die(mysqli_error());
				$nums =  mysqli_num_rows($resultactive);
				if($nums>50){
					$resultpage='2';
				}else{
					$resultpage='1';
				}
				return $resultpage;
			}
			
			private function decodescore2($hotg){
				if(is_array($hotg)){
						echo'--'. count($hotg["betGameResults"]).'--';
						for($i=0;$i<count($hotg["betGameResults"]);$i++){
								$ahh=0;
								 $acc=0;
							echo '<br>';
								if(!empty($hotg["betGameResults"][$i])){
							 	$away = $hotg["betGameResults"][$i]["a"];
								$home = $hotg["betGameResults"][$i]["h"];
								$s=$hotg["betGameResults"][$i]['s'];
								$ti =$hotg["betGameResults"][$i]["t"];
								echo $aclass=$hotg["lexicon"]["resources"][$s];
								echo $cattype = $hotg["lexicon"]["resources"][$ti];//賽事類型
								echo $hotg["betGameResults"][$i]["id"];//ni
								echo $hotg["betGameResults"][$i]["cd"];		//賽事編號
								if(! is_null($hotg["betGameResults"][$i]["hpp"])){
									
								echo $awayteam = $hotg["lexicon"]["resources"][$away];//客
								echo $hometeam = $hotg["lexicon"]["resources"][$home];//主
								}else{
									$md = $hotg["betGameResults"][$i]["md"];
									echo $hotg["betGameResults"][$i]["lexicon"]["resources"][$md];
								}
								$gametime1=number_format($hotg["betGameResults"][$i]["d"],3,'.','');
								$currenttime = substr( $gametime1 ,0,10 );
								echo  $gametime = date("Y-m-d",$currenttime);
								echo $gametime3 = date("H:i",$currenttime);
								echo $st=$hotg["betGameResults"][$i]["st"];//狀態
								echo '<br>';
								if(! is_null($hotg["betGameResults"][$i]["hpp"])){
										$mysingleah=array();
										for($j=1;$j<=10;$j++){
											if($s!='s-445') {
												if ($hotg["betGameResults"][$i]["hpp"][$j] != '-1') {
													$ahh += $hotg["betGameResults"][$i]["hpp"][$j];
												}
												if($hotg["betGameResults"][$i]["vsp"][$j]!='-1'){
													$acc+=$hotg["betGameResults"][$i]["vsp"][$j];
												}
											}else{
												if ($hotg["betGameResults"]["hpp"][$j] != '-1') {
													if( $hotg["betGameResults"][$i]["hpp"][$j]>$hotg["betGameResults"][$i]["vsp"][$j])
													{
														 $ahh +=1;
													}elseif($hotg["betGameResults"][$i]["hpp"][$j]<$hotg["betGameResults"][$i]["vsp"][$j]){
														$acc+=1;
													}
												}

											}
												$mysingleah[]=$hotg["betGameResults"][$i]["hpp"][$j];
												$mysingleah[]=$hotg["betGameResults"][$i]["vsp"][$j];
										}
								}else{
								$lwcd = $hotg["betGameResults"][$i]["lwcd"][0];
								echo $hotg[$i]["lexicon"]["resources"][$lwcd];
								}
						echo '<br>';
							//echo $j;
							echo 'ah-'.$ahh;//主總分
							echo 'ac-'.$acc;//客總分
							echo '<br>';
							$jsonboxscore=json_encode($mysingleah);
							$this->upscoresql($st,$acc,$ahh,$hotg["betGameResults"][$i]['cd'],$gametime,$jsonboxscore);
								}
						}
				}
				
			}
			private function upscoresql($st,$acc,$ahh,$valuecd,$gametime,$mysingleah){
				include 'connection.php';
			$sqlbox = "SELECT gameid,gametime FROM `boxscore` WHERE gameid='$valuecd' and gametime='$gametime'";
			$resultbox = mysqli_query($database_link,$sqlbox) or die(mysqli_error());
			$numboxscore=mysqli_num_rows($resultbox);
							if($st=='completed' ) {
								$sqla1 = "UPDATE `gass1analysis` SET  `status`='$st',`upscore` = '$acc',`underscore` = '$ahh' WHERE `gameid` = '$valuecd' and adate='$gametime'";
								mysqli_query($database_link,$sqla1);
								$sqla2 = "UPDATE `gass2analysis` SET  `status`='$st',`upscore` = '$acc',`underscore` = '$ahh'  WHERE `gameid` = '$valuecd' and adate='$gametime'";
								mysqli_query($database_link,$sqla2);
								if($numboxscore==0){
								echo $sqla3 = "INSERT INTO `boxscore`(`gameid`,`gametime`,`scorebox`)value('$valuecd','$gametime','$mysingleah')";
								mysqli_query($database_link,$sqla3);
								}
							}else{
								$sqla1 = "UPDATE `gass1analysis` SET  `status`='$st' WHERE `gameid` = '$valuecd' and adate='$gametime'";
								mysqli_query($database_link,$sqla1);
								$sqla2 = "UPDATE `gass2analysis` SET  `status`='$st' WHERE `gameid` = '$valuecd' and adate='$gametime'";
								mysqli_query($database_link,$sqla2);
							}
							mysqli_close($database_link);
			}
		
		//随机IP
/*			private function Rand_IP(){

				$ip2id= round(rand(600000, 2550000) / 10000); //第一种方法，直接生成
				$ip3id= round(rand(600000, 2550000) / 10000);
				$ip4id= round(rand(600000, 2550000) / 10000);
				//下面是第二种方法，在以下数据中随机抽取
				$arr_1 = array("218","218","66","66","218","218","60","60","202","204","66","66","66","59","61","60","222","221","66","59","60","60","66","218","218","62","63","64","66","66","122","211");
				$randarr= mt_rand(0,count($arr_1)-1);
				$ip1id = $arr_1[$randarr];
				echo $ip1id.".".$ip2id.".".$ip3id.".".$ip4id;
				return $ip1id.".".$ip2id.".".$ip3id.".".$ip4id;
			}
*/			
			    public function Curl($url)//170814判斷ip有無被鎖
				{
					for($i=255;$i>=254;$i--){
						$privateip='172.31.5.'.$i;
						$JsonFile=$this->CurlSt($privateip,$url);
						if(! empty($JsonFile)){
							 return $JsonFile;  
						 }            
					}
					 return $JsonFile; 
				}
			   
				public function CurlSt($privateip,$url)//170814判斷ip有無被鎖
				{
				
					$agent= 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36';
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_TIMEOUT, 5);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_USERAGENT, $agent);
					curl_setopt($ch, CURLOPT_INTERFACE, $privateip);
					$JsonFile = curl_exec($ch);
					curl_close($ch);
					return $JsonFile;
			   }



//			public function Curl($json_url)
//					{
//						$url = $json_url;
//						$ch2 = curl_init();
//						$user_agent = "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36";//模拟windows用户正常访问
//						curl_setopt($ch2, CURLOPT_URL, $url);
//						curl_setopt($ch2, CURLOPT_TIMEOUT, 60);
//
//						curl_setopt($ch2, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.$this->Rand_IP(), 'CLIENT-IP:'.$this->Rand_IP()));
//						//追踪返回302状态码，继续抓取
//						curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER,false );
//						curl_setopt($ch2, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/536.6 (KHTML, like Gecko) Chrome/20.0.1090.0 Safari/536.6');
//
//						curl_setopt($ch2, CURLOPT_USERAGENT, "CURL");
//						curl_setopt($ch2, CURLOPT_HEADER, false);
//						curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
//						curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, true);
//						curl_setopt($ch2, CURLOPT_NOBODY, false);
//						curl_setopt($ch2, CURLOPT_REFERER, 'http://www.baidu.com/');//模拟来路
//						curl_setopt($ch2, CURLOPT_USERAGENT, $user_agent);
//						//curl_setopt($ch, CURLOPT_TIMEOUT, 20);
//						//************Change ip****************
//						curl_setopt($ch2, CURLOPT_INTERFACE, "172.31.5.255");
//						//*************************
//						$temp = curl_exec($ch2);
//						$httpcode = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
//						if($httpcode != "200")
//						{
//							$date = date('Y-m-d H:i:s');
//							$Sub = '更新異常，請檢查 EC2 連線狀態';
//							$this->deliver_curlmsg($Sub);
//						}
//						$temp = curl_exec($ch2);
//						curl_close($ch2);
//						return $temp;
//					}
					
					
		public function deliver_curlmsg($message){
					 $playerid=array('c04ed5be-18ee-4acc-b20f-202298904d90');
					  $content = array(
					  "en" => 'sport58',
					  "zh-Hant" => $message
							);
						$fields = array(
						  'app_id' => "2bb4e63d-e84b-4dae-91dc-38f321dc2a0a",
						  'include_player_ids' => $playerid,
						  'data' => array("foo" => "bar"),
						  'contents' => $content,
						  'url'=>'https://aws.amazon.com/tw/'
						);
					$fields = json_encode($fields);
					//print("\nJSON sent:\n");
					//print($fields);
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
										   'Authorization: Basic NGEyZmMyYWUtNTI3Zi00YTUyLWI0OGUtOGFiZTYxMDU4NDhm'));
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
					curl_setopt($ch, CURLOPT_HEADER, FALSE);
					curl_setopt($ch, CURLOPT_POST, TRUE);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
					$response = curl_exec($ch);
					curl_close($ch);
					return $response;
			  }
	}
?>