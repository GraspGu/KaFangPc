<?php
//配版规则，以下数据单位均为厘米cm
/*
    命名方式：
    调整-- ：ad_--
    配版--：fini_--
 */
/*****成衣胸围的计算方法*****/

$ad_chest = $chest + 3 - ($chest % 3);//调整胸围
/*****胸围的配版*****/
if ($chest <= 90) {    //瘦体的判定
    $fini_chest = $ad_chest + 12;
}else{
    //通用配版
    $fini_chest = $ad_chest + 9;
}
/*****腰围的配版*****/
$fini_waist = $ad_chest - 12;   //普通配版腰围
if (intval($waist) + 1 + 3 >= $fini_waist) {    //考虑特体情况
    $fini_waist = intval($waist) + 1 + 4;
}
/*****领围和肩宽的配版规则*****/
$fini_neck = intval($neck) + 2; //上领围
$fini_shoulder = intval($shoulder) + 1; //肩宽
/*****臂围的配版规则*****/
if ($arm > ($fini_chest/3 + 1 - 3)) {   //臂围过粗判定
    $fini_arm = intval($arm) + 4;
} else {
    //普通用户配版
    $fini_arm = $fini_chest/3 + 1;
}
/*****腕围的配版规则*****/
$fini_wrist = $wrist + 3;
/*****袖长和衣长均为实测数据*****/
$fini_sleeve = $sleeve;
$fini_clothes = $clothes;   //前衣长
/*****下摆围的配版规则*****/
if ((intval($hip) + 1 + 3) > ($fini_chest - 2)) {
    //臀围过大
    $fini_sweep = $hip + 4;
}else{
    //正常臀围
    $fini_sweep = $fini_chest - 2;
}

 ?>