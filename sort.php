<?php
$first_array = array( 91,5,4,1,7,8,3,878,1,12,135,61,1235,52, );
echo "First:";　
print_r($first_array);
$array_count = count($first_array);

echo "Bubble:";
$bubble_array = Bubble($first_array, $array_count);
print_r($bubble_array);

echo "Shell:";
$shell_array = Shell($first_array, $array_count);
print_r($shell_array);

echo "Quick:";
$quick_array = Quick($first_array, 0, $array_count-1);
print_r($quick_array);

echo "Marge:";
$marge_array = Marge($first_array, 0, $array_count-1);
print_r($marge_array);

function swap($array, $i, $j){
    $temp = $array[$i];
    $array[$i] = $array[$j];
    $array[$j] = $temp;
    return $array;
}

function TradeCheck($array, $i, $j){
    if($array[$i] > $array[$j])
        $array = swap($array,$i,$j);

    return $array;
}
//バブルソート
function Bubble($array, $array_count){
    for($i = 0; $i < $array_count; $i++){
        for($j = $array_count-1; $j > $i; $j--){
            $array = TradeCheck($array,$i,$j);
        }
    }
    return $array;
}
//シェルソート
function Shell($array, $array_count){
    for($part = $array_count/2; (int)($part) > 0; $part /=2){
            $part = (int)$part;
            $array = InsertSort($array,$part,$array_count);
    }
    return $array;
}
//単純挿入ソート
function InsertSort($array, $part, $array_count){
    for($i = 0; $i < $array_count-$part; $i++){
        for($j = $i+$part; $j < $array_count; $j += $part){
            $array = TradeCheck($array,$i,$j);
        }	
    }
    return $array;
}
//クイックソート　再帰的
function Quick($array, $left, $right){
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
        $array = swap($array, $l, $r);
        //次の探索へ
        $l++; $r--;
    }
    if($l - $left > 1)
        $array = quick($array, $left, $r);
    if($right - $r > 1){
        $array = quick($array, $l, $right);
    }
    return $array;
}
//マージソート
function Marge($array, $left, $right){
    //要素が一つだったら戻す
    if($left >= $right){
        $return_array = array($array[$left]);
        return $return_array;
    }
    $center = (int)(($left+$right)/2);
    $left_array = marge($array, $left, $center);
    $right_array = marge($array, $center+1, $right);
    $return_array = array();
    $l = count($left_array); $r = count($right_array);
    //結合した配列内でソート
    for($n = $left; $n < $right; $n++){
        if($left_array[0] < $right_array[0]){
            $return_array[] = array_shift($left_array);
            $l--;
        }elseif($left_array[0] >= $right_array[0]){
            $return_array[] = array_shift($right_array);
            $r--;
        }
        if($l <= 0 ){
            $return_array = array_merge($return_array, $right_array);
            break;
        }
        if($r <= 0 ){
            $return_array = array_merge($return_array, $left_array);
            break;
        }
    }
    return $return_array;
}
