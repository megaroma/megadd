<?php
namespace megadd\exceptions
{
class sysexception extends \Exception {
    public function __construct($errno, $errstr) {
        parent::__construct();
        $this->code = $errno;
        $this->message = $errstr;
    }
}
}
?>