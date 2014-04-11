<?php
namespace megadd\modules\db\classes
{
if (!defined('MEGADD')) die ('401 page not found');
use megadd\classes\core;
class result
{
private $db;
private $res; 
private $affected_rows;

public function __construct($result) {
$this->db = core::module('db');
$this->res = $result;
$this->affected_rows = $this->db->affected_rows();
}

public function count() {
return $this->affected_rows;
}

public function fetch () {
return $this->db->fetchrow($this->res);
}

public function seek($offset) {
$this->db->data_seek($this->res,$offset);
}

public function rows () {
$this->seek(0);
$rows = array();
while ($row = $this->fetch() ) {
$rows[] = $row;
}
return $rows;
}

public function free() {
$this->db->free_result($this->res);
}

}
}