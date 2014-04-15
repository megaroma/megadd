<?php
namespace megadd\modules\db\classes
{
if (!defined('MEGADD')) die ('Error 404 Not Found');
use megadd\classes\core;
class mysqli extends \megadd\modules\db\db
{
private $con = false;

public function connect()
 {
 $conf = core::conf('db');
 $host = ($conf['port'] == '')? $conf['host'] : $conf['host'].':'.$conf['port'];
 $this->con = mysqli_connect($host, $conf['user'], $conf['password'], $conf['database']);
 if (mysqli_connect_errno()) {
		throw new \megadd\exceptions\modexception(mysqli_connect_errno(), "Mysqli connect failed: ".mysqli_connect_error());
	}
 }

public function begin()
{
 if($this->con) {
	return mysqli_begin_transaction($this->con);
 } else throw new \megadd\exceptions\modexception(13, "MySqli error: Database not connected");
} 


public function commit()
{
 if($this->con) {
	return mysqli_commit($this->con);
 } else throw new \megadd\exceptions\modexception(13, "MySqli error: Database not connected");
} 


public function rollback()
{
 if($this->con) {
	return mysqli_rollback($this->con);
 } else throw new \megadd\exceptions\modexception(13, "MySqli error: Database not connected");
} 


public function autocommit($status = true)
{
 if($this->con) {
	return mysqli_autocommit($this->con,$status);
 } else throw new \megadd\exceptions\modexception(13, "MySqli error: Database not connected");
} 


public function escape($value)
	{
	if($this->con) {
	$value = mysqli_real_escape_string($this->con, (string) $value);
		return "'$value'";
     } else throw new \megadd\exceptions\modexception(13, "MySqli error: Database not connected");
		}



public function query($query,$param = array())
	{ 
	$values = array_map(array ($this,"quote"), $param);
   $query = strtr($query, $values);

        if(!($result = mysqli_query($this->con, $query)))
		 throw new \megadd\exceptions\modexception(mysqli_errno($this->con), "Mysqli query error: ".mysqli_error($this->con));

		  return new result($result);
	}	 
 		

public function affected_rows()
	{ 
		if($this->con) {
    return mysqli_affected_rows($this->con);
	
	 } else throw new \megadd\exceptions\modexception(13, "MySqli error: Database not connected");
	}	

public function fetchrow($res) {
		if($this->con) {
    return mysqli_fetch_assoc($res);
	 } else throw new \megadd\exceptions\modexception(13, "MySqli error: Database not connected");
}		

public function data_seek($res,$offset) {
		if($this->con) {
    mysqli_data_seek($res, $offset);
	 } else throw new \megadd\exceptions\modexception(13, "MySqli error: Database not connected");
}

public function free_result($res) {
		if($this->con) {
    mysqli_free_result($res);
	 } else throw new \megadd\exceptions\modexception(13, "MySqli error: Database not connected");
}


public function close()
	{
			if($this->con) {
    return mysqli_close($this->con);
	 } else throw new \megadd\exceptions\modexception(13, "MySqli error: Database not connected");

	}

public function set_charset($charset)
{
			if($this->con) {
    return mysqli_set_charset($this->con, $charset); 
	 } else throw new \megadd\exceptions\modexception(13, "MySqli error: Database not connected");

	}
	
}
}