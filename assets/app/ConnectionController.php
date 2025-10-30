<?php

class ConnectionController {

    private $HOST = "localhost";
    private $USER = "root";
    private $PASS = "";
    private $DB = "bd_login";

    function connect() {
        $conn = new mysqli($this->HOST,$this->USER,$this->PASS,$this->DB);
        if ($conn) {
            return $conn;
        } else {
            return false;
        }
    }
}
?>