<?php
namespace megadd\classes\error
{
use megadd\classes\core;

	class debug extends \megadd\classes\error	{
		public function message($type,\Exception $e) {
			//echo $type.'<br>';
			//print_r($e); //$e->getFile()
			//$t = $e->getTrace();
			//foreach ( $t as $k=>$v) {
			//echo "<div id=\"id_$k\" class=\"test\" onclick=\"test($k);\">line = ".$v['line']." file=".$v['file']." </div>";}
			//print_r($t);
			$view = core::view('error_debug_screen','megadd/views/');
			$view->type = $type;
			$view->message = $e->getMessage();
			$traces = $e->getTrace();
			$view->code = $e->getCode();
			$files = array(); 
			$trace = array();
			foreach ($traces as $k => $v) {
			if (isset ($v['file'])) {
			$trace[$k] = $v; 
			$tmp_file = file($v['file']);
			$l = count($tmp_file);
			$start = ($v['line'] > 10)? $v['line'] - 9 : 1;
			$end = (($v['line']+10) > $l) ? $l : $v['line']+10;
			$files[$k]  = "";
			$buf = array();
			for($i = $start;$i < $end;$i++) {
			$buf[$i] = $tmp_file[$i-1].'&nbsp;';
			}
			$lines[$k] = $v['line'];
			$files[$k]=$buf;//syntaxhighlight::process($files[$k],$start,$v['line']-1 );
			} 
			}
			$view->trace = $trace;
			$view->files = $files;
			$view->lines = $lines;
			echo $view->render();
			exit;
		}
	}
}
?>