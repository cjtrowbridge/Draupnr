<?php

Hook('Build','HomepageBuild();');

function HomepageBuild(){
  $PageName = 'Homepage';
  $DestinationFile = '../index2.html';
  $TemplateFile = 'template.html';
  
  
  //Check if it is time to build
  $FileTime = filemtime($DestinationFile);
  if(date('Y-m-d')==date('Y-m-d',$FileTime)){
    //If the template's destination was last built today, we don't need to build it again.
    echo '<p>Skipped template "'.$DestinationFile.' because it was freshly built."</p>'.PHP_EOL;
    return;
  }
  
  
  //Get data
  $FeedURL = 'http://quotesondesign.com/wp-json/posts?filter[orderby]=rand&filter[posts_per_page]=1&callback=';
  $Feed = FetchURL($FeedURL);
  $Feed = json_decode($Feed,true);
  $Feed=$Feed[0];
  
  
  //Organize the data
  $Data = array(
    'PAGE_TITLE' => $PageName,
    'PAGE_CONTENTS' => '<h1>Homepage</h1><p><em>Here Is A Daily Random Design Quote!</em></p>'.PHP_EOL.$Feed['content'].PHP_EOL.'<p><a href="'.$Feed['link'].'" target="_blank"><i>By: '.$Feed['title'].'</i></a></p>'
  );
  
  
  //Get template
  $Template = file_get_contents($Template);
  
  
  //Fill in template from each of our datasets
  foreach(array(
    $App,
    $Data
  ) as $Dataset){
    foreach($Dataset as $Key => $Value){
      $Template = str_replace('['.$Key.']',$Value,$Template);
    }
  }
  
  
  //Write to destination and archive
  file_put_contents($DestinationFile,$Template);
  file_put_contents('archive/'.$PageName.'/'.date('Y-m-d').'.html',$Template);
  
  
  //TODO check if archive write failed because of weird filename and email admin
  //TODO check for unused [VAR] and email admin
}
