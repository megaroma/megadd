<?php
namespace megadd\exceptions
{
class modexception extends \Exception {
    public function __construct($errno, $errstr) {
        parent::__construct();
        $this->code = $errno;
        $this->message = $errstr;
    }
}
}
?>