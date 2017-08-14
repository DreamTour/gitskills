<?php
/**
*分页获取产品信息
*请求参数：
  pageNum-需显示的页号；默认为1
  type-可选，默认为1
*输出结果：
  {
    totalRecord: 60,
    pageSize: 11,
    pageCount: 6,
    type: 1,
    pageNum: 1,
    data: [{},{} ... {}]
  }
*/
@$start=$_REQUEST['start'] or $start=0;
$count=4;
require('init.php');

$sql="SELECT * FROM mfw_gl LIMIT $start,$count";
$result=mysqli_query($conn,$sql);
$output = mysqli_fetch_all($result,MYSQLI_ASSOC);
$list=json_encode($output);
echo $list;
?>