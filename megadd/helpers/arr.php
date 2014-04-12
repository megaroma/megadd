<?php
namespace megadd\helpers
{
if (!defined('MEGADD')) die ('401 page not found');
static class arr {

static function get($arr , $name, $default) {
return isset($arr[$name]) ? $arr[$name] : $default;
}


}




}
?>