<?php
function Swap($array, $i, $j){
    $temp = $array[$i];
    $array[$i] = $array[$j];
    $array[$j] = $temp;
    return $array;
}
//swap if array[i] > array[j]
function SwapIfGraterThan($array, $i, $j){
    if($array[$i] > $array[$j])
        $array = Swap($array,$i,$j);

    return $array;
}

//QuickSort用
//QuickSortでSwapする場所を探索(左側)
function LeftSwapPoint($pivot,$array,$l){
    while($pivot > $array[$l])
            $l++;
    return $l;
}
//QuickSortでSwapする場所を探索(右側)
function RightSwapPoint($pivot,$array,$r){
    while($pivot < $array[$r])
            $r--;
    return $r;
}

//MergeSort用
//左の配列と右の配列を結合
function MergeLeftAndRightArray($left_array, $right_array){
    $merged_array = array();
    //左の配列と右の配列の先頭を比べ、小さいほうを新しい配列に順に入れる
    while(!empty($left_array) && !empty($right_array)){
        if($left_array[0] < $right_array[0]){
            $merged_array[] = array_shift($left_array);
        }elseif($left_array[0] >= $right_array[0]){
            $merged_array[] = array_shift($right_array);
        }
    }
    //どっちかがなくなったら残りをそのまま結合
    if(empty($left_array)){
        $merged_array = array_merge($merged_array, $right_array);
    }
    elseif(empty($right_array)){
        $merged_array = array_merge($merged_array, $left_array);
    }
    return $merged_array;
}