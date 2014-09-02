<?php

require "my_sort_helper.php";

$unsorted_array = array( 91,5,4,1,7,8,3,878,1,12,135,61,1235,52, );
echo "UnSorted:";
print_r($unsorted_array);
//各種ソートによる出力.
//こちらからはSortしてほしい配列を投げるだけにする
echo "Bubble:";
print_r(BubbleSort($unsorted_array));

echo "Shell:";
print_r(ShellSort($unsorted_array));

echo "Quick:";
print_r(QuickSort($unsorted_array));

echo "Merge:";
print_r(MergeSort($unsorted_array));


//バブルソート
function BubbleSort($array){
    $array_count = count($array);
    for($i = 0; $i < $array_count; $i++){
        for($j = $array_count-1; $j > $i; $j--){
            $array = SwapIfGraterThan($array,$i,$j);
        }
    }
    return $array;
}
//シェルソート
function ShellSort($array){
    $array_count = count($array);
    for($part = $array_count/2; (int)($part) > 0; $part /=2){
        $part = (int)$part;
        //間隔partをあけて単純挿入ソート
        $array = InsertSort($array,$part,$array_count);
    }
    return $array;
}
//単純挿入ソート
function InsertSort($array, $part, $array_count){
    for($i = 0; $i < $array_count-$part; $i++){
        for($j = $i+$part; $j < $array_count; $j += $part){
            $array = SwapIfGraterThan($array,$i,$j);
        }	
    }
    return $array;
}
//クイックソート　
function QuickSort($array){
    return QuickInner($array, 0, count($array)-1);
}
//再帰的
function QuickInner($array, $left, $right){
    $l = $left;
    $r = $right;
    $pivot = $array[(int)(($left+$right)/2)];
    while($l < $r){
        //swapする場所の探索
        $l = LeftSwapPoint($pivot,$array,$l);
        $r = RightSwapPoint($pivot,$array,$r);
        if($l >= $r) break;
        $array = Swap($array, $l, $r);
        //次の探索へ
        $l++; 
        $r--;
    }
    if($l - $left > 1){
        $array = QuickInner($array, $left, $r);
    }
    if($right - $r > 1){
        $array = QuickInner($array, $l, $right);
    }
    return $array;
}

//マージソート
function MergeSort($array){
    return MergeInner($array, 0, count($array)-1);
}
function MergeInner($array, $left, $right){
    //要素が一つだったら戻す
    if($left >= $right){
        $return_array = array($array[$left]);
        return $return_array;
    }
    $center = (int)(($left+$right)/2);
    $left_array = MergeInner($array, $left, $center);
    $right_array = MergeInner($array, $center+1, $right);
    return MergeLeftAndRightArray($left_array, $right_array);
}
