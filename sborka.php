<?php
//kniga pokupok
echo "start\n";

#add tests

$data = file2array('in.csv');
//var_dump($data);


$base = file_get_contents('tpl.xml');
$tpl = file_get_contents('tpl1.xml');

$text = '';
$sum=0;

foreach($data as $element){
	//var_dump($element);
	$fill = str_replace('$line1',$element["line1"],$tpl);
	$fill = str_replace('$line2',$element["line2"],$fill);
	$fill = str_replace('$line3',$element["line3"],$fill);
	$fill = str_replace('$line4',$element["line4"],$fill);
	$fill = str_replace('$line5',$element["line5"],$fill);
	$fill = str_replace('$line6',$element["line6"],$fill);
	$fill = str_replace('$line7',clear($element["line7"]),$fill);
	$fill = str_replace('$line8',clear($element["line8"]),$fill);
	$tmp8 = clear($element["line8"]);
	$fill = str_replace('$line9',$element["line9"],$fill);
	$text.=$fill;
	$sum+=$tmp8;
}

$base = str_replace('$data',$text,$base);
$base = str_replace('$sum',$sum,$base);
file_put_contents('NO_NDS.8_7801_7801_780161151018_20160725_4D085B51-7556-4827-BD18-0466799C6603.xml',$base);

echo "done\n";

function file2array($filename){
	if(file_exists($filename)){
		$tmp = file_get_contents($filename);
		if($tmp){
			if (strstr($tmp,'﻿')) $tmp = mb_strcut($tmp,3);
			$keys = explode("\r\n",$tmp);
			if (sizeof($keys)==1) $keys = explode("\n",$tmp);
			$i=0;
			foreach($keys as $str){
				if(mb_strlen(trim($str))>0){
					if(($str[0]==';') and ($str[1]!=';')){
						$ex = explode(';',$str);
						$id = $i;
						//$data[$id]['line1'] = $ex[0];
						$data[$id]['line1'] = $i+1;
						$data[$id]['line2'] = $ex[1];
						$data[$id]['line3'] = $ex[2];
						$data[$id]['line4'] = $ex[3];
						$data[$id]['line5'] = $ex[4];
						$data[$id]['line6'] = $ex[5];
						$data[$id]['line7'] = $ex[6];
						$data[$id]['line8'] = $ex[7];
						$data[$id]['line9'] = $ex[8];
						$i++;
					}
				}	
			}
			return $data;
		} else return false;
	} else return false;
}


function clear($str){
	//echo "$str\n";
	$str = trim($str);
	$str = str_replace(',','.',$str);
	$str = preg_replace('|[^\d\.]|','',$str);
	//echo "$str\n";
	return $str;
}
?>