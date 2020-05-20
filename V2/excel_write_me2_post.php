<?php
require_once 'PHPExcel-1.8/Classes/PHPExcel.php';
//print_r($_POST);
error_reporting(0);


$Y=$_POST['year'];
$M=$_POST['month'];
$Date=$_POST['date1'];
$eitem=$_POST['eitem'];
$ia=0;
for($eit=0;$eit<count($eitem);$eit++){
  if(! empty($eitem[$eit])){
    //商品
    $itemarr[$ia]=$eitem[$eit];
    $ia++;
  }
}
//print_r($itemarr);
//exit;
$shop='新店民權';
$shop2='新莊和興';
$shop3='桃園大興';

/*加店家find key point->如加店家在此新增*/

//echo $days=date("t",strtotime("Y-m-d"));

// 新增Excel物件
$objPHPExcel = new PHPExcel();

//30->  450

//設定操作中的工作表
$objPHPExcel->setActiveSheetIndex(0);
$sheet = $objPHPExcel->getActiveSheet();
//將工作表命名
$sheet->setTitle($Y.$M);
 
 
//商品
//$itemarr=array("金選奶茶","檸檬紅茶","脫脂奶粉","朱古力粉","砂糖包","咖啡(藍色裝)","二氧化碳鋼瓶","可樂","芬達","雪碧","蘋果汁","1231","8895","dfd");

$dati1=0;
$dati=1;
$CO=count($itemarr)+4;
//$ASTYE='A1:'.chr(66+(count($itemarr)-1)).($Date*(3+count($itemarr)));
$ASTYE='A1:'.'G'.($CO*$Date);
/*如加店家在此新增*/
//須修正G

// 設定格式：使用陣列
$Astyle = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => '000000')
        ),
    ),
    'alignment' => array('wrap'=> 0,
             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
     ),
    'font'   => array(
                      'size' => '12',
                      'color' => array('argb' => '000000')
                      )   
);
$sheet->getStyle($ASTYE)->applyFromArray($Astyle);


$sheet->getColumnDimension('A')->setWidth(15);//日期格式
$sheet->getColumnDimension('B')->setWidth(24);//店家
$sheet->getColumnDimension('D')->setWidth(24);
$sheet->getColumnDimension('F')->setWidth(24);
/*如加店家在此新增*/

for($j=3;$j<($Date+3);$j++){
	
    //合併儲存格日期
	$datecc='A'.(1+($CO*$dati1)).':A'.($dati*$CO);
	$datestr='A'.(1+($CO*$dati1));

    $shopBC='B'.(1+($CO*$dati1)).':C'.(1+($CO*$dati1));
    //合併儲存格 店家
    $shopBC2='B'.(2+($CO*$dati1)).':C'.(2+($CO*$dati1));
    //合併儲存格 地址
    $shopBC3='B'.(3+($CO*$dati1)).':C'.(3+($CO*$dati1));
    //合併儲存格 統編
    $shopDE='D'.(1+($CO*$dati1)).':E'.(1+($CO*$dati1));
    $shopDE2='D'.(2+($CO*$dati1)).':E'.(2+($CO*$dati1));
    $shopDE3='D'.(3+($CO*$dati1)).':E'.(3+($CO*$dati1));
    $shopFG='F'.(1+($CO*$dati1)).':G'.(1+($CO*$dati1));
    $shopFG2='F'.(2+($CO*$dati1)).':G'.(2+($CO*$dati1));
    $shopFG3='F'.(3+($CO*$dati1)).':G'.(3+($CO*$dati1));
   /*如加店家在此新增*/



    //店家內文位置
    $shopB='B'.(1+($CO*$dati1));
    $shopD='D'.(1+($CO*$dati1));
    $shopF='F'.(1+($CO*$dati1));
    /*如加店家在此新增*/

    //地址內文位置
    $shopB2='B'.(2+($CO*$dati1));
    $shopD2='D'.(2+($CO*$dati1));
    $shopF2='F'.(2+($CO*$dati1));
    /*如加店家在此新增*/

    //統編內文位置
    $shopB3='B'.(3+($CO*$dati1));
    $shopD3='D'.(3+($CO*$dati1));
    $shopF3='F'.(3+($CO*$dati1));
    /*如加店家在此新增*/

    //'項目內文位置'
    $itemB4='B'.(4+($CO*$dati1));
    $itemC4='C'.(4+($CO*$dati1));
    $itemD4='D'.(4+($CO*$dati1));
    $itemE4='E'.(4+($CO*$dati1));
    $itemF4='F'.(4+($CO*$dati1));
    $itemG4='G'.(4+($CO*$dati1));
    /*如加店家在此新增*/


	// 設定格式：使用陣列
	$shopstyle = array(
	    'borders' => array(
	        'allborders' => array(
	            'style' => PHPExcel_Style_Border::BORDER_THIN,
	            'color' => array('argb' => '000000')
	        ),
	    ),
	    'font'   => array('bold' => true,
	                      'size' => '16',
	                      'color' => array('argb' => '000000')
	                      )   
	);
	//合併儲存格格式
	$sheet->getStyle($shopBC)->applyFromArray($shopstyle);
	$sheet->getStyle($shopDE)->applyFromArray($shopstyle);
	$sheet->getStyle($shopFG)->applyFromArray($shopstyle);
	/*如加店家在此新增*/
    
	//執行合併儲存格
	$sheet->mergeCells($datecc);

	$sheet->mergeCells($shopBC);
	$sheet->mergeCells($shopBC2);
	$sheet->mergeCells($shopBC3);

	$sheet->mergeCells($shopDE);
	$sheet->mergeCells($shopDE2);
	$sheet->mergeCells($shopDE3);

	$sheet->mergeCells($shopFG);
	$sheet->mergeCells($shopFG2);
	$sheet->mergeCells($shopFG3);
	/*如加店家在此新增*/




	$sheet->setCellValue($datestr,$Y.'/'.$M.'/'.($j-2)); 
	$sheet->setCellValue($shopB,'新店民權店'); 
	$sheet->setCellValue($shopB2,'地址:新店區民權路103號'); 
	$sheet->setCellValue($shopB3,'統編:65235901'); 
	$sheet->setCellValue($itemB4,'品項'); 
	$sheet->setCellValue($itemC4,'訂貨量'); 

    $sheet->setCellValue($shopD,'新莊和興店'); 
	$sheet->setCellValue($shopD2,'地址:新莊區和興街69號'); 
	$sheet->setCellValue($shopD3,'統編:66460905'); 
	$sheet->setCellValue($itemD4,'品項'); 
	$sheet->setCellValue($itemE4,'訂貨量');

	$sheet->setCellValue($shopF,'桃園大興店'); 
	$sheet->setCellValue($shopF2,'地址:桃園區大興西路一段325號'); 
	$sheet->setCellValue($shopF3,'統編:69643963'); 
	$sheet->setCellValue($itemF4,'品項'); 
	$sheet->setCellValue($itemG4,'訂貨量'); 
    
    /*如加店家在此新增*/



	$itemandnum=$itemB4.':'.$itemC4;
	$sheet->getStyle($itemandnum)->applyFromArray(
    	array('fill'     => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('argb' => 'B8B8DC')
         ),
         )
	);
	$itemandnum2=$itemD4.':'.$itemE4;
	$sheet->getStyle($itemandnum2)->applyFromArray(
    	array('fill'     => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('argb' => 'B8B8DC')
         ),
         )
	);
	$itemandnum3=$itemF4.':'.$itemG4;
	$sheet->getStyle($itemandnum3)->applyFromArray(
    	array('fill'     => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('argb' => 'B8B8DC')
         ),
         )
	);

    for($b=0;$b<count($itemarr);$b++){
    	$orderst[$b]=chr(66+$b);
    }
	for($a=0;$a<count($itemarr);$a++){

		$itemr1='B'.($a+5+($CO*$dati1));
		$itemr2='C'.($a+5+($CO*$dati1));
		$itemr3='D'.($a+5+($CO*$dati1));
		$itemr4='E'.($a+5+($CO*$dati1));
        $itemr5='F'.($a+5+($CO*$dati1));
		$itemr6='G'.($a+5+($CO*$dati1));
        /*如加店家在此新增*/
        /*如加店家在此新增*/

		$orderc='=INDIRECT("'.$shop.'"&"!'.CHR(66+$a).$j.'")';
		$orderc2='=INDIRECT("'.$shop2.'"&"!'.CHR(66+$a).$j.'")';
		$orderc3='=INDIRECT("'.$shop3.'"&"!'.CHR(66+$a).$j.'")';
		/*如加店家在此新增*/

		$sheet->setCellValue($itemr1,$itemarr[$a]);
		$sheet->setCellValue($itemr2,$orderc);
		$sheet->setCellValue($itemr3,$itemarr[$a]);
		$sheet->setCellValue($itemr4,$orderc2);
		$sheet->setCellValue($itemr5,$itemarr[$a]);
		$sheet->setCellValue($itemr6,$orderc3);
		/*如加店家在此新增*/
		/*如加店家在此新增*/

	}
	$dati++;
    $dati1++;
    
}




$objPHPExcel->createSheet();
$objPHPExcel->setactivesheetindex(1);
$sheet2 = $objPHPExcel->getActiveSheet();

$sheet2->getStyle('B1:D1')->applyFromArray(
    array('fill'     => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('argb' => 'F9F900')
         ),
         )
);

//將工作表命名
$sheet2->setTitle($shop);
$sheet2->mergeCells('B1:D1');
$sheet2->setCellValue('B1',$shop);
$sheet2->setCellValue('A2','日期');
for($c=0;$c<count($itemarr);$c++){
    	$shopitem[$c]=chr(66+$c).'2';
        $sheet2->setCellValue($shopitem[$c],$itemarr[$c]);
        $sheet2->getColumnDimension(chr(66+$c))->setWidth(15);

}
for($f=3;$f<($Date+3);$f++){
	$shopdate='A'.$f;
	$sheet2->setCellValue($shopdate,$M.'月'.($f-2).'日'); 

}


$ASSTYE='A1:'.chr(66+(count($itemarr)-1)).($Date+2);
// 設定格式：使用陣列
$ASHOPSTYE = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => '000000')
        ),
    ),
    'alignment' => array('wrap'=> 0,
             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
     ),
    'font'   => array(
                      'size' => '12',
                      'color' => array('argb' => '000000')
                      )   
);

$sheet2->getStyle($ASSTYE)->applyFromArray($ASHOPSTYE);




$objPHPExcel->createSheet();
$objPHPExcel->setactivesheetindex(2);
$sheet3 = $objPHPExcel->getActiveSheet();
$sheet3->getStyle('B1:D1')->applyFromArray(
    array('fill'     => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('argb' => 'F9F900')
         ),
         )
);
$sheet3->getStyle($ASSTYE)->applyFromArray($ASHOPSTYE);

//將工作表命名
$sheet3->setTitle($shop2);
$sheet3->mergeCells('B1:D1');
$sheet3->setCellValue('B1',$shop2);
$sheet3->setCellValue('A2','日期');
for($g=0;$g<count($itemarr);$g++){
    	$shopitem[$g]=chr(66+$g).'2';
        $sheet3->setCellValue($shopitem[$g],$itemarr[$g]);
        $sheet3->getColumnDimension(chr(66+$g))->setWidth(15);

}
for($h=3;$h<($Date+3);$h++){
	$shopdate='A'.$h;
	$sheet3->setCellValue($shopdate,$M.'月'.($h-2).'日'); 
}


//----------------------------------------------------------個別店家sheet

$objPHPExcel->createSheet();
$objPHPExcel->setactivesheetindex(3);
$sheet4 = $objPHPExcel->getActiveSheet();
$sheet4->getStyle('B1:D1')->applyFromArray(
    array('fill'     => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('argb' => 'F9F900')
         ),
         )
); 
//將工作表命名
$sheet4->getStyle($ASSTYE)->applyFromArray($ASHOPSTYE);
$sheet4->setTitle($shop3);
$sheet4->mergeCells('B1:D1');
$sheet4->setCellValue('B1',$shop3);
$sheet4->setCellValue('A2','日期');
for($i=0;$i<count($itemarr);$i++){
    	$shopitem[$i]=chr(66+$i).'2';
        $sheet4->setCellValue($shopitem[$i],$itemarr[$i]);
        $sheet4->getColumnDimension(chr(66+$i))->setWidth(15);
}
for($k=3;$k<($Date+3);$k++){
	$shopdate='A'.$k;
	$sheet4->setCellValue($shopdate,$M.'月'.($k-2).'日'); 
}

//------------------------------------------------------




/*如加店家在此新增*/











//合併後的儲存格，設定時指定左上角那個。



//若要在 2003 跟 2007 之間切換，選然下面兩段其中一段即可。
//Excel 2007
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$Y.$M.'_FT.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
/*
//Excel 2003
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="01simple.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); //Excel 2003 = Excel 5
*/
//=============================================================================================
$objWriter->save('php://output');
exit;

?>