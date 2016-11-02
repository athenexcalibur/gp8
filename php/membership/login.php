<?php
include(dirname(__FILE__)."/../database.php");
include_once "userfunctions.php";

$_POST = array(); //workaround for broken PHPstorm
parse_str(file_get_contents('php://input'), $_POST);
cSessionStart();

if (isset($_POST["email"], $_POST["password"]))
{
    $email = mysqli_real_escape_string(Database::getConnection(), $_POST["email"]);
 
    if (login($email, $_POST["password"]) === true)
    {
        header("Location: ../../index.php");
        exit;
    }
    else header("Location: ../../index.php?error=" . urlencode("Invalid email or password, please try again."));
} 
else header("Location: ../../index.php?error=" . urlencode("Invalid request."));

?>