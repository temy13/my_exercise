<?php
$first_array = array( 91,5,4,1,7,8,3,878,1,12,135,61,1235,52, );
echo "First:";
print_r($first_array);
$array_count = count($first_array);
echo "Bubble:";
print_r(Bubble($first_array, $array_count));
echo "Shell:";
print_r(Shell($first_array, $array_count));
echo "Quick:";
print_r(Quick($first_array, 0, $array_count-1));
echo "Merge:";
print_r( Merge($first_array, 0, $array_count-1));

function swap($array, $i, $j){
    $temp = $array[$i];
    $array[$i] = $array[$j];
    $array[$j] = $temp;
    return $array;
}

function TradeOrNot($array, $i, $j){
    if($array[$i] > $array[$j])
        $array = swap($array,$i,$j);

    return $array;
}
//バブルソート
function Bubble($array, $array_count){
    for($i = 0; $i < $array_count; $i++){
        for($j = $array_count-1; $j > $i; $j--){
            $array = TradeOrNot($array,$i,$j);
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
            $array = TradeOrNot($array,$i,$j);
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
        $l++; 
        $r--;
    }
    if($l - $left > 1){
        $array = Quick($array, $left, $r);
    }
    if($right - $r > 1){
        $array = Quick($array, $l, $right);
    }
    return $array;
}
//マージソート
function Merge($array, $left, $right){
    //要素が一つだったら戻す
    if($left >= $right){
        $return_array = array($array[$left]);
        return $return_array;
    }
    $center = (int)(($left+$right)/2);
    $left_array = Merge($array, $left, $center);
    $right_array = Merge($array, $center+1, $right);
    return MergeLeftAndRightArray($left_array, $right_array);
}
function MergeLeftAndRightArray($left_array, $right_array){
    $merged_array = array();
    //結合した配列内でソート
    while(!empty($left_array) && !empty($right_array)){
        if($left_array[0] < $right_array[0]){
            $merged_array[] = array_shift($left_array);
        }elseif($left_array[0] >= $right_array[0]){
            $merged_array[] = array_shift($right_array);
        }
    }
    if(empty($left_array)){
        $merged_array = array_merge($merged_array, $right_array);
    }
    elseif(empty($right_array)){
        $merged_array = array_merge($merged_array, $left_array);
    }
    return $merged_array;
}