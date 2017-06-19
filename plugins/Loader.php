<?php 

include_once('core/Event.php');
include_once('core/Hook.php');

function Loader($dir = 'plugins',$DieOnFail = true){
  Event('Before Loading Directory: '.$dir);
  if($dir=='plugins'){
  
    if($handle = opendir('core')){
      while (false !== ($class = readdir($handle))){
        $include_path='plugins/'.$class;
        if((!(strpos($class,'.php')===false)) && $class != "." && $class != ".." && file_exists($include_path)){
          Event('Before Loading: '.$include_path);
          include_once($include_path);
          Event('After Loading: '.$include_path);
        }
      }
      closedir($handle);
    }
  
  }else{
    
    if(
      (!(file_exists($dir)))&&
      $DieOnFail
    ){
      die('Loader could not find dir: '.$dir);
    }

    if(file_exists($include_path=$dir.'/Routing.php')){
      Event('Before Loading: '.$include_path);
      include_once($include_path);
      Event('After Loading: '.$include_path);
    }else{
      Event('Could not find: '.$include_path);
    }
    
    if($handle = opendir($dir)){
      while (false !== ($extension = readdir($handle))){
        $Path=$dir.'/'.$extension;
        if($extension != "." && $extension != ".." && is_dir($Path)){
          Event('Before Recursively Loading Subdirectory: '.$extension);
          Loader($Path);
          Event('After Recursively Loading Subdirectory: '.$extension);
        }
      }
      closedir($handle);
    }
    
  }
  Event('After Loading Directory: '.$dir);
}
