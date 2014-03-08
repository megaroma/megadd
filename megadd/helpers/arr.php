<?php
namespace megadd\helpers
{
static class arr {

static function get($arr , $name, $default) {
return isset($arr[$name]) ? $arr[$name] : $default;
}


}




}
?>