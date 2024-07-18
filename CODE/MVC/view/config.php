<?php

$conn = mysqli_connect("localhost", "root", "", "ql_nhayen");

if (!$conn) {
    echo "Connection Failed";
}