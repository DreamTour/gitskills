<?php
class editFileName{
    private $dir = "";
    public function __construct($dir=null){
        if(empty($dir)){
            $this->dir = dirname(__FILE__);
        }else{
            $this->dir = $dir;
        }
        $this->chengeName();
    }
    public function chengeName(){
        $arr=scandir($this->dir);
        foreach ($arr as $v){
            if($v != "." && $v != ".."){
                $html = @file_get_contents($v);
                $newfile = substr(strstr($v,"--"), 2);
                $fillpath = str_replace("-", "/", $newfile);
                $path = dirname($fillpath);
                if(!is_dir($path) && $path != ""){
                    mkdir($path,0777,true);
                }
                file_put_contents($fillpath, $html);
                if(preg_match("/--/", $v) != 0){
                    unlink($v);
                }
            }
        }
        echo "ok";
    }
}
$ob=new editFileName();