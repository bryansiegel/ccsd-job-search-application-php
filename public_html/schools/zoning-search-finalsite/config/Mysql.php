<?php

class Mysql {

    public function connect() {
        $servername = "trmysql.ccsd.net";
        $username = "root";
        $password = "rawr4486";
        $conn = mysqli_connect($servername, $username, $password);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        return $conn;
        }
}
