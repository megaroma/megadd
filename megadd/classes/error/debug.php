<?php
namespace megadd\classes\error
{
use megadd\classes\core;
use megadd\helpers\syntaxhighlight;

	class debug extends \megadd\classes\error	{
		public function message($type,\Exception $e) {
			//echo $type.'<br>';
			//print_r($e); //$e->getFile()
			$t = $e->getTrace();
			//foreach ( $t as $k=>$v) {
			//echo "<div id=\"id_$k\" class=\"test\" onclick=\"test($k);\">line = ".$v['line']." file=".$v['file']." </div>";}
			//print_r($t);
			$view = core::view('error_debug_screen','megadd/views/');
			$view->type = $type;
			$view->message = $e->getMessage();
			$view->trace = $e->getTrace();
			$files = array();
			foreach ($view->trace as $k => $v) {
			$tmp_file = file($v['file']);
			$l = count($tmp_file);
			$start = ($v['line'] > 10)? $v['line'] - 10 : 0;
			$end = (($v['line']+10) > $l) ? $l : $v['line']+10;
			$files[$k]  = "";
			for($i = $start;$i < $end;$i++) {
			$files[$k] .= $tmp_file[$i];
			}
			$files[$k]=syntaxhighlight::process($files[$k],$start,$v['line']-1 );
			}
			$view->files = $files;
			echo $view->render();
			exit;
		}
	}
}
?>