<?php
namespace megadd\classes
{
abstract class controller
{
private $id = "";
private $signals = array();

public function run ($action,$id)
{
$this->id = $id;
$method = "action_".$action;
$this->before();
$signal_action = $this->run_signal();
if($signal_action != '')
{
$this->$signal_action();
} else
{
$this->$method();
}
$this->after();
}

public function respond($view)
{
if (is_object($view))
  {
  echo $view->render();
  } else
  {
  echo $view;
  }
}


public function signal($data)
{
$this->signals[] = $data;
}


public function  run_signal()
{ 
$true_signal_id = array();
foreach( $this->signals as $signal_id => $signal_data)
{
$signal_stat = true;
if (isset($signal_data['id']))
 {
	if($signal_data['id'] != $this->id) $signal_stat = false;
 }
if(isset($signal_data['post'])) 
 { 
  if(is_array($signal_data['post']))
  {
  foreach ($signal_data['post'] as $post) 
    {
	if(!$this->check_signal($_POST,$post)) $signal_stat = false;
	} 
  } else
  {
	if(!$this->check_signal($_POST,$signal_data['post'])) $signal_stat = false;
  }
}
if(isset($signal_data['get'])) 
 {
  if(is_array($signal_data['get']))
  {
  foreach ($signal_data['get'] as $get) 
    {
	if(!$this->check_signal($_GET,$get)) $signal_stat = false;
	} 
  } else
  {
	if(!$this->check_signal($_GET,$signal_data['get'])) $signal_stat = false;
  }
}
if(isset($signal_data['session'])) 
 {
  if(is_array($signal_data['session']))
  {
  foreach ($signal_data['session'] as $session) 
    {
	if(!$this->check_signal($_SESSION,$session)) $signal_stat = false;
	} 
  } else
  {
	if(!$this->check_signal($_SESSION,$signal_data['session'])) $signal_stat = false;
  }
}  
if(isset($signal_data['cookie'])) 
 {
  if(is_array($signal_data['cookie']))
  {
  foreach ($signal_data['cookie'] as $cookie) 
    {
	if(!$this->check_signal($_COOKIE,$cookie)) $signal_stat = false;
	} 
  } else
  {
	if(!$this->check_signal($_COOKIE,$signal_data['cookie'])) $signal_stat = false;
  }
}  

if ($signal_stat) {
$true_signal_id[] = $signal_id;
}  
}


foreach ($true_signal_id as $signal_id) 
{
if (isset($this->signals[$signal_id]['slot']))
  {
  $method = 'slot_'.$this->signals[$signal_id]['slot'];
  $this->$method();
  }

if (isset($this->signals[$signal_id]['action']))
  {
  $method = 'action_'.$this->signals[$signal_id]['action'];
  return $method;
  }
  
}

return '';
}

private function check_signal($arr,$data)
{
  
if (isset($arr[$data]) && ($arr[$data] != '' )) {
  return true;
} else {
  return false;
}

}


abstract function before();
abstract function after();

}
}


?>