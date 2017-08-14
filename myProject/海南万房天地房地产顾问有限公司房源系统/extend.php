<?php
/*
*全站扩展函数库，可全站调用
*/
/********第一个函数*****************************/
function extendOne(){
    $html = "
	asdf
	";
    return $html;
}
function Stitching($array){
    $str = "";
    foreach ($array as $v){
        $str .= ',"'.$v.'"';
    }
    $str = substr($str, 1);
    if (empty($array)) {
        return "";
    }
    return $str;
}
function delquod($array) {
    foreach($array as $k=>$i) {
        $array[$k] = str_replace('"',"",$i);
    }
    return $array;
}
?>
