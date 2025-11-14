<?php

class ConnectionController {

    private $HOST = "localhost";
    private $USER = "root";
    private $PASS = "";
    private $PORT = 3307;
    private $DB = "bd_login";

    function connect() {
        $conn = new mysqli($this->HOST,$this->USER,$this->PASS,$this->DB,$this->PORT);
        if ($conn) {
            return $conn;
        } else {
            return false;
        }
    }
}
?>