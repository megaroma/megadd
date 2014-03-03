<?php
namespace megadd\classes\error
{
class debug extends \megadd\classes\error
{
	public function message(\Exception $e) {
		print_r($e);
		exit;
	}
}
}
?>