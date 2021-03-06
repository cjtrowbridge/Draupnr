<?php

Hook('Build','ExampleHomepageBuild();');

function ExampleHomepageBuild(){
  global $App;
  
  $PageName = 'Draupnir Example';
  $DestinationFile = 'index.html';
  $TemplateFile = 'example-homepage/template.html';
  
  
  //Check if it is time to build
  if(file_exists($DestinationFile)){
    $FileTime = filemtime($DestinationFile);
    if(date('Y-m-d')==date('Y-m-d',$FileTime)){
      //If the template's destination was last built today, we don't need to build it again.
      echo '<p>Skipped template "'.$DestinationFile.' because it was freshly built."</p>'.PHP_EOL;
      return;
    }
  }
  
  
  //Get data
  $FeedURL = 'http://quotesondesign.com/wp-json/posts?filter[orderby]=rand&filter[posts_per_page]=1&callback=';
  $Feed = FetchURL($FeedURL);
  $Feed = json_decode($Feed,true);
  $Feed=$Feed[0];
  
  $Content = '
  
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h1>'.$PageName.'</h1>
        <p><em>Here Is A Daily Random Design Quote!</em></p>
        '.$Feed['content'].'
        <p><a href="'.$Feed['link'].'" target="_blank"><i>By: '.$Feed['title'].'</i></a></p>
      </div>
    </div>
  </div>
  
  ';
  
  
  //Organize the data
  $Data = array(
    'PAGE_TITLE' => $PageName,
    'PAGE_CONTENTS' => $Content
  );
  
  
  //Get template
  if(!(file_exists($TemplateFile))){
    echo '<p>Skipped template "'.$TemplateFile.' because the template file could not be found!"</p>'.PHP_EOL;
    return;
  }
  $Template = file_get_contents($TemplateFile);
  if(!($Template)){
    echo '<p>Skipped template "'.$TemplateFile.' because the template file could not be loaded!"</p>'.PHP_EOL;
    return;
  }
  
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
  
  $PageNameDirectory = str_replace(' ','-',$PageName);
  if(!(file_exists('archive/'.$PageNameDirectory.'/'))){
    mkdir('archive/'.$PageNameDirectory);
  }
  file_put_contents('archive/'.$PageNameDirectory.'/'.date('Y-m-d').'.html',$Template);
  
  
  //TODO check if archive write failed because of weird filename and email admin
  //TODO check for unused [VAR] and email admin
}
