<?php

if (!defined('__CONFIG__')) {
    exit('Access Denied');
}

date_default_timezone_set("Asia/Tashkent");

error_reporting(1);
ini_set('display_errors', 'On');

include_once "classes/DB.php";
include_once "classes/Filter.php";
include_once "classes/Request.php";
include_once "classes/User.php";
include_once "helpers.php";

$con = DB::getConnection();