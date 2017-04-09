<?php
require_once "../database.php";
require_once "../user.php";

cSessionStart();
if (!loginCheck())
{
    header("Location: ../index.php");
    exit();
}

$dbConnection = Database::getConnection();

$_POST = array(); //workaround for broken PHPstorm
parse_str(file_get_contents('php://input'), $_POST);

