<?php

$host = "mysql";
$user = "perpus_user";
$pass = "perpus_pass";
$database = "db_perpus";

$db = mysqli_connect($host, $user, $pass, $database)
or die("gagal koneksi ke database");