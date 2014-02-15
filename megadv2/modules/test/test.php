<?php
namespace megadv2\modules\test
{
if (!defined('MEGADV')) die ('401 page not found');
use megadv2\classes\core;
class test
{

static function getInstance()
{
$conf = core::conf('test');
if ($conf['mode'] == 'debug')
{
return new classes\debug();
}

}




}
}