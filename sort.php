<?php

$array = array( 91,5,4,1,7,8,3,878,1,12,135,61,1235,52, );
echo "first:";
showarray($array);
$array_count = count($array);
bubble($array,$array_count);
shell($array,$array_count);
$quick_array = quick($array,0,$array_count-1);
echo "quick:";
showarray($quick_array);
$marge_array = marge($array,0,$array_count-1);
echo "marge:";
showarray($marge_array);




function swap($array,$i,$j){

	//echo $i."&".$j.">>".$array[$i]."<>".$array[$j]."\n";
	$temp = $array[$i];
	$array[$i] = $array[$j];
	$array[$j] = $temp;
	return $array;

}

function bubble($array,$array_count){

	echo "bubble:";
	for($i = 0; $i < $array_count; $i++):
		for($j = 0; $j < $array_count; $j++):
			if($array[$i] < $array[$j])
				$array = swap($array,$i,$j);
		endfor;
	endfor;
	
	showarray($array);
}

function shell($array,$array_count){

	echo "shell:";
	for($part = $array_count/2; (int)($part) > 0; $part /=2):
			$part = (int)$part;
			$array = insert_Sort($array,$part,$array_count);
	endfor;
	showarray($array);
}

function insert_Sort($array,$part,$array_count){

	for($i = 0; $i < $array_count-$part; $i++):
		for($j = $i+$part; $j < $array_count; $j += $part):
			if($array[$i] > $array[$j])
				$array = swap($array,$i,$j);
		endfor;
	endfor;

	return $array;
}
//クイックソート　再帰的
function quick($array,$left,$right){

	$l = $left;
	$r = $right;
	$pivot = $array[(int)(($left+$right)/2)];
	while($l < $r){
		//tradeする場所の探索
		while($pivot > $array[$l])
			$l++;
		while($pivot < $array[$r])
			$r--;
		if($l >= $r) break;
		$array = swap($array,$l,$r);
		//次の探索へ
		$l++; $r--;
	}
	if($l - $left > 1)
		$array = quick($array,$left,$r);
	if($right - $r > 1){
		$array = quick($array,$l,$right);
	}
	return $array;
}

function marge($array,$left,$right){

	//要素が一つだったら戻す
	if($left >= $right){
		$return_array = array($array[$left]);
		return $return_array;
	}
	$center = (int)(($left+$right)/2);
	$left_array = marge($array,$left,$center);
	$right_array = marge($array,$center+1,$right);
	$return_array = array();
	$l = count($left_array); $r = count($right_array);
	//結合した配列内でソート
	for($n = $left; $n < $right; $n++){
		if($left_array[0] < $right_array[0]){
			$return_array[] = array_shift($left_array);
			$l--;
		}else{
			$return_array[] = array_shift($right_array);
			$r--;
		}
		if($l <= 0 ){
			$return_array = array_merge($return_array,$right_array);
			break;
		}
		if($r <= 0 ){
			$return_array = array_merge($return_array,$left_array);
			break;
		}
	}
	return $return_array;
}

function showarray($array){

	foreach ($array as $key => $value) {
		echo "[".$value."]";
	}
	echo "\n";
}