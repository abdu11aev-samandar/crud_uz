<?php

if (!defined('__CONFIG__')) {
    exit('Access Denied');
}

//Allways set default_timezone
date_default_timezone_set("Asia/Tashkent");

//Allow errors
error_reporting(1);
ini_set('display_errors', 'On');

//Include classes
include_once "classes/DB.php";
include_once "classes/Filter.php";
include_once "classes/Request.php";
include_once "classes/User.php";
include_once "helpers.php";

$con = DB::getConnection();