<?php

namespace App\Tool;

class Lang
{



    private $dir = "/resources/lang/";//定义缓存目录

    private $langtype ;
    private $wenjian ;
    private $key='c_a_sss'; // 文件名 md5加密 密钥

   public function __construct($langtype,$str_ste){

        $this->langtype=$langtype;

        if($str_ste){

            $this->wenjian=$str_ste;
        }else{

            $this->wenjian='demo';
        }


    }



    public function set_dir($dirpath)
    {
        $this->dir=$dirpath;
        $this->make_dir($this->dir);
    }
    public function read($key)
    {


        $filename=$this->get_filename($key);


        if(is_file($filename))
        {
            $datas = include($filename);
            if(isset($datas[$key])){

                return $datas[$key];
            }




        }
        return false;
    }

    public function write($key,$re_wey)
    {


        $filename=$this->get_filename($key);


        if(!is_file($filename)){

            $this->make_file($filename);
        }

          $str=include($filename);

        $data=array($key=>$re_wey);

        if(is_array($str)){

            $array_merge_recursive=array_merge_recursive($str,$data);
        }else{

            $array_merge_recursive=$data;
        }



        $text='<?php return '.var_export($array_merge_recursive,true).';';

        if($handle = fopen($filename,'w+'))
        {
            flock($handle,LOCK_EX);
            $rs = fputs($handle,$text);
            flock($handle,LOCK_UN);
            fclose($handle);
            if($rs!==false){return true;  }
        }
        return false;
    }


    private function get_filename($key)
    {

        if(is_string($key)){
            $gen_surl= str_replace('\\','/',dirname(dirname(dirname(__FILE__)))).'/';

            $argc=$this->wenjian;
             return $gen_surl.$this->dir.$this->langtype.'/'.$argc.'.php';

        }else{

            return null;
        }


    }
    private function make_dir($path)
    {
        if (! file_exists ( $path ))
        {
            if (! mkdir ( $path, 0777,true)) die ( '无法创建缓存文件夹' . $path );
        }
    }
    private function del_file($dir)
    {
        if (is_dir($dir))
        {
            $dh=opendir($dir);//打开目录 //列出目录中的所有文件并去掉 . 和 ..
            while (false !== ( $file = readdir ($dh))) {
                if($file!="." && $file!="..") {
                    $fullpath=$dir."/".$file;
                    if(!is_dir($fullpath)) {
                        unlink($fullpath);
                    } else {
                        $this->del_file($fullpath);
                    }
                }
            }
            closedir($dh);
        }
    }


    private function make_file($dir){

        $fopen = @fopen($dir, 'wb ');//新建文件命令
        fclose($fopen);
    }
}


