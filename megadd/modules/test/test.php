<?php
namespace megadd\modules\test
{
if (!defined('MEGADD')) die ('401 page not found');
use megadd\classes\core;
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