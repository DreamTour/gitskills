<?php
include_once "ku/adfunction.php";
header("Content-type: text/html; charset=utf-8");
class Files{
    private $dir=""; //指定目录
    public function __construct($dir){
        $this->dir = ServerRoot;
    }
    
    private function fileSuffix($filename){ //文件后缀名
    	return strtolower(trim(substr(strrchr($filename, '.'), 1)));
    }
    
    private function bldir($dir){ //返回指定目录下所有文件json 数据
    	$array = array();
        $chilarray=array();
        $handle = opendir($dir);
        if( $handle ){
            while ( ( $file = readdir ( $handle ) ) !== false ){
                if ( $file != '.' && $file != '..'){
                    $cur_path = $dir.DIRECTORY_SEPARATOR. $file;
                    if ( is_dir ( $cur_path ) ){
                        $chilarray = $this->bldir( $cur_path );
                        $array=array_merge($array,$chilarray);
                    }elseif(is_file($cur_path) && strpos('php js css',$this->fileSuffix($file))!==false){
                        $array[] = $cur_path;
                    }
                }
            }
            closedir($handle);
        }
        return $array;
    }        
	

	public function getfiles(){
		return $array=$this->bldir($this->dir);
	}


    public function getfileContent($file){
    	echo file_get_contents($file);
    }

    public function download(){
        if(empty($this->dir)){
            echo "<script>alert('no dir');</script>";
            return false;
        }
    	$files=$this->getfiles();
    	foreach($files as $file){
    		$filepath=$file;
    		$href = $this->seturl($file);
    		$file=str_replace('./', '', $file);
    		$file=str_replace('../', '-', $file);
    		$file=str_replace('/', '-', $file);
    		$file=str_replace('\\', '-', $file);
    		echo "<a href='$href' download='$file'>$filepath</a>";
    		echo "<br/>";
    	}
            echo 
<<<EOT
<input type="button" id="button" onclick="downloads()" value="下载多个文件"/>
<script type="text/javascript" src="https://ss1.bdstatic.com/5eN1bjq8AAUYm2zgoY3K/r/www/cache/static/protocol/https/jquery/jquery-1.10.2.min_65682a2.js"></script>

<script type="text/javascript">
	var obj = $('a');
	length = obj.length;
$("#button").val("下载"+length+"个文件");
function downloads(){
	for(var i =0;i<length;i++){
		obj[i].click();
	}
}

</script>
EOT;

    }
    public function seturl($file){  
		return $_SERVER['PHP_SELF']."?action=getfileContent&file=".$file;  
    }

}

 $obj=new Files();
 @$action=$_GET['action'];
 @$file = $_GET['file'];
 if($action=='getfileContent'){
 	$obj->$action($file);
 }else{
	$obj->download();
 }
exit();


