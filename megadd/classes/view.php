<?php
namespace megadd\classes {
if (!defined('MEGADD')) die ('401 page not found');
class view
{
private $template = "";
private $path = "";

private $data = array();

public function __construct ($template, $path = "app/view/")
{
$this->template = $template;
$this->path = $path;
}

function __set($name,$value) 
{
$this->data[$name] = $value;
}
function __get($name) 
{
return (isset($this->data[$name]))? $this->data[$name] : '';
}
public function render()
{
foreach ($this->data as $key => $value)
{
if (is_object($value))
  {
  $$key = $value->render();
  } else
  {
  $$key = $value;
  }
}

ob_start();
include $this->path.$this->template.".php";
$text = ob_get_contents();
ob_end_clean();
return $text;
}


}
}