<?php
include "control/ku/configure.php";
$url = "http://www.yumukeji.com/project/aizai/control/ku/interface.php?type=newGoodsTypeOne";
$data = array(
	/*"goodsid" => "dEr73861718iL",*/
	"goodsTypeOneName" => "242443",
	"goodsTypeOneNameList" => "3243",
	"goodsTypeOneNameShow" => "100"

);
/*$data['json'] = json_encode($array,JSON_UNESCAPED_UNICODE);*/
$result = Curl($url,$data);
echo $result;

/**
 * 发送post请求
 * @param string $url 请求地址
 * @param array $post_data post键值对数据
 * @return string
 */
/*function send_post($url, $post_data) {

	$postdata = http_build_query($post_data);
	$options = array(
		'http' => array(
			'method' => 'POST',
			'header' => 'Content-type:application/x-www-form-urlencoded',
			'content' => $postdata,
			'timeout' => 15 * 60 // 超时时间（单位:s）
		)
	);
	$context = stream_context_create($options);
	$result = file_get_contents($url, false, $context);

	return $result;
}

//使用方法
$post_data = array(
	'goodsName' => '111111',
	'price' => '166'
);
send_post('http://www.yumukeji.com/project/aizai/control/ku/interface.php?type=newGoods', $post_data);*/

echo head("ad");
?>