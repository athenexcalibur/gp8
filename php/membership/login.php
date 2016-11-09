<?php
include_once "../database.php";
include_once "../user.php";

$_POST = array(); //workaround for broken PHPstorm
parse_str(file_get_contents('php://input'), $_POST);
cSessionStart();

if (isset($_POST["email"], $_POST["password"]))
{
    $email = mysqli_real_escape_string(Database::getConnection(), $_POST["email"]);

    try
    {
        $_SESSION["user"] = new User($email, $_POST["password"]);
        header("Location: ../../index.php");
        exit;
    }
    catch (Exception $e)
    {
        header("Location: ../../index.php?error=" . $e->getMessage());
        exit;
    }
} 
else header("Location: ../../index.php?error=" . urlencode("Invalid request."));

?>