<?php
class DatabaseConnection {
    protected $mysqliConnection;    
    public function __construct() {
        $this->mysqliConnection = new mysqli("localhost", "root", "", "miros");
    }
    public function __destruct() {
        if ($this->mysqliConnection) {
            $this->mysqliConnection->close();
        }
    }
}