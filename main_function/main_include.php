<?php
session_start();
include_once 'function.php';
$mysqli = connect_database();
$user_id = token();

