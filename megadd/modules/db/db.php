<?php
namespace megadd\modules\db
{
if (!defined('MEGADD')) die ('Error 404 Not Found');
use megadd\classes\core;
abstract class db
{

static function getInstance()
{
$conf = core::conf('db');
if ($conf['driver'] == 'mysqli')
{
return new classes\mysqli();
}

}


abstract function connect();
abstract function begin();
abstract function commit();
abstract function rollback();
abstract function autocommit($status = true);
abstract function escape($value);
abstract function query($query,$param = array());
abstract function affected_rows();
abstract function fetchrow($res);
abstract function data_seek($res,$offset);
abstract function free_result($res);
abstract function close();
abstract function set_charset($charset);

public function quote($value)
	{
		if ($value === NULL)
		{
			return 'NULL';
		}
		elseif ($value === TRUE)
		{
			return "'1'";
		}
		elseif ($value === FALSE)
		{
			return "'0'";
		}
		elseif (is_array($value))
		{
			return '('.implode(', ', array_map(array($this, __FUNCTION__), $value)).')';
		}
		elseif (is_int($value))
		{
			return (int) $value;
		}
		elseif (is_float($value))
		{
	
			return sprintf('%F', $value);
		}

		return $this->escape($value);
	}


}
}